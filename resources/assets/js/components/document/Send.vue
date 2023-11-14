<template>
    <div>
        <div v-if="!error" class="row">
            <!-- Info alert -->
            <div class="col-sm-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
                    Here you can transfer documents.
                </div>
            </div>

            <!-- Upload document -->
            <div class="col-md-7">
                <card title="<i class='fa fa-arrow-circle-up'></i> Send document">
                    <div v-if="isInjected" class="row">
                        <!-- Step 1: Input -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="recipient-address">Recipient Address:</label>
                                <div class="col-12">
                                    <input type="text" id="recipient-address" v-model="to" class="form-control" placeholder="Enter recipient wallet address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="document-name">Document Name:</label>
                                <div class="col-12">
                                    <input type="text" id="document-name" v-model="document.name" class="form-control" placeholder="Enter document name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="document-description">Document Description:</label>
                                <div class="col-12">
                                    <input type="text" id="document-description" v-model="document.description" class="form-control" placeholder="Enter document description">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="document-type">Document Type:</label>
                                <div class="col-12">
                                    <select id="document-type" v-model="document.docType" class="form-control">
                                        <option value="0">Payslip</option>
                                        <option value="1">Medical</option>
                                        <option value="2">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="dropzone">File:</label>
                                <div class="col-12">
                                    <vue-dropzone id="dropzone" @vdropzone-success="dropzoneSuccess" ref="dropzone" :options="dropzoneOptions"/>
                                </div>
                            </div>
                            <div v-if="errors.length" class="form-group">
                                <div class="col-12">
                                    <div v-for="error in errors" class="alert alert-danger">
                                        <strong>{{ error }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-actions">
                                <div class="col-12 col-sm-offset-5">
                                    <button type="reset" class="btn btn-effect-ripple btn-secondary" @click="resetForm">Reset</button>
                                    <button type="submit" class="btn btn-effect-ripple btn-success" @click="send">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center">
                        <img :src="'../../../img/loader.gif'" alt="loading..." height="64" width="64">
                    </div>
                </card>
            </div>
            <!-- Account Balance -->
            <div class="col-md-5">
                <balance/>
            </div>
        </div>
        <div v-else>
            <error-screen v-bind:error-code="error"/>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import Card from '../card/Card';
    import ErrorScreen from '../ErrorScreen';
    import DocumentContract from '../../utils/DocumentContract';
    import monitorWeb3 from '../../utils/monitorWeb3';
    import {ETHERSCAN_TX_URL} from '../../utils/constants/networks';
    import vue2Dropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';
    import NodeRSA from 'node-rsa';
    import randomString from 'random-string';
    const crypto = require('crypto');

    const Buffer = require('buffer/').Buffer;

    export default {
        data() {
            return {
                to: null,
                recipientPubKey: null,
                document: {
                    link: '',
                    name: '',
                    description: '',
                    docType: null
                },
                errors: [],
                dropzoneOptions: {
                    url: '/account/documents/saveFile',
                    maxFiles: 1,
                    maxFilesize: 20,
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxfilesexceeded: function(file) {
                        this.removeAllFiles(true);
                        this.addFile(file);
                    }
                }
            }
        },
        computed: mapState({
            isInjected: state => state.web3.isInjected,
            coinbase: state => state.web3.coinbase,
            error: state => state.web3.error,
            documentContract() {
                if (this.isInjected) {
                    return new DocumentContract(this.$store.state.document.instance);
                }
                return null;
            }
        }),
        beforeCreate() {
            this.$store.dispatch('registerWeb3').then((result) => {
                this.$store.dispatch('registerDocument').then(result => {
                    monitorWeb3(result.state);
                });
            });
        },
        methods: {
            resetForm() {
                this.to = null;
                this.document.name = null;
                this.document.description = null;
                this.document.docType = null;
                this.$refs.dropzone.removeAllFiles(true);
            },
            async validateForm() {
                this.errors = [];
                let files = this.$refs.dropzone.getQueuedFiles();

                // Check receiver wallet address
                if (!this.to) {
                    this.errors.push('Missing recipient wallet address!');

                } else if (!this.$store.state.web3.instance().isAddress(this.to)) {
                    this.errors.push('Recipient wallet address is not valid!');

                } else {
                    // Get public key for document receiver address
                    const res = await axios.post('/account/getPublicKey', {
                        'wallet': this.to
                    });

                    if (res.data.error) {
                        this.errors.push(res.data.error);
                    } else {
                        this.recipientPubKey = res.data.public_key;
                    }
                }

                if (!this.document.docType) {
                    this.errors.push('Please select document type!');
                }

                // Check if file is uploaded
                if (!(files.length > 0)) {
                    this.errors.push('Please upload document!');
                }
            },
            encryptFile() {
                return new Promise((resolve, reject) => {
                    let file = this.$refs.dropzone.getQueuedFiles()[0];

                    const reader = new FileReader();
                    reader.readAsArrayBuffer(file);
                    reader.onload = (e) => {
                        try {
                            let fileData = Buffer.from(reader.result);

                            // Symmetric encrypt
                            const symKey = Buffer.from(randomString({length: 32}));
                            const iv = crypto.randomBytes(16);
                            const cipher = crypto.createCipheriv('aes-256-cbc', symKey, iv);

                            const symEncrypted = Buffer.concat([cipher.update(fileData), cipher.final()]).toString('base64');
                            const symPrefix = symKey.toString('base64') + ':' + iv.toString('base64');

                            // Asymmetric encrypt - encrypt just symmetric key & iv
                            const key = new NodeRSA();
                            key.importKey(this.recipientPubKey, 'pkcs8-public');

                            const encrypted = key.encrypt(symPrefix, 'base64');
                            const data = Buffer.from(encrypted + ':' + symEncrypted);

                            let encryptedFile = new File([Buffer.from(data.toString('base64'), 'base64')], file.name, {type: file.type});

                            // Add file back to dropzone
                            this.$refs.dropzone.removeAllFiles(true);
                            this.$refs.dropzone.addFile(encryptedFile);

                            resolve();
                        } catch (err) {
                            console.error(err);
                            reject();
                        }
                    };
                });
            },
            async send() {
                await this.validateForm();

                if (this.errors.length > 0) {
                    return;
                }

                // Encrypt file with receiver public key
                if (this.recipientPubKey) {
                    await this.encryptFile();

                    // Process file in queue
                    this.$refs.dropzone.processQueue();
                }
            },
            dropzoneSuccess(file, response) {
                this.$refs.dropzone.removeAllFiles(true);
                this.document.link = response.fileUrl;

                // Create transaction to smart contract
                this.createTransaction();
            },
            async createTransaction() {
                this.documentContract.sendPreSignedDocumentTransaction(this.coinbase, this.to, this.document).then(res => {
                    if (res) {
                        let txUrl = '<a href="' + ETHERSCAN_TX_URL + res + '" target="_blank">' + ETHERSCAN_TX_URL + '0x...</a>';
                        this.successAlert('Document was sent', 'Tx URL: \n' + txUrl);
                        this.resetForm();
                    } else {
                        this.dangerAlert('Error', 'Signature is not valid!');
                    }

                }).catch(err => {
                    this.dangerAlert('Error', 'There was an unexpected error!');
                    console.error(err);
                });
            },
            successAlert: function(title, text) {
                swal({
                    title: title,
                    text: text,
                    type: 'success',
                    confirmButtonColor: '#66cc99'
                });
            },
            dangerAlert: function(title, text) {
                swal({
                    title: title,
                    text: text,
                    type: 'error',
                    confirmButtonClass: 'btn btn-danger'
                });
            }
        },
        components: {
            'card': Card,
            'error-screen': ErrorScreen,
            'vue-dropzone': vue2Dropzone,
        }
    }
</script>

<style src="../../../vendors/sweetalert2/dist/sweetalert2.min.css"></style>
<style src="../../../css/custom_css/sweet_alert2.css"></style>
