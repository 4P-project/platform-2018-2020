<template>
    <div>
        <div v-if="!error" class="row">
            <!-- Info alert -->
            <div class="col-sm-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
                    Here you can transfer FOUR tokens from your wallet to other ETH - based wallets.<br>
                    You can also check the balance of your account and your wallet's address.<br>
                    Always double check the address of the recipient and amount you wish to send. Once submitted, it cannot be undone.
                </div>
            </div>

            <!-- Transfer FOUR token -->
            <div class="col-md-7">
                <card title="<i class='fa fa-arrow-circle-up'></i> Transfer FOUR token">
                    <div v-if="isInjected" class="row">
                        <!-- Step 1: Input -->
                        <div v-if="formState === 0" class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="recipient-address">Recipient Address:</label>
                                <div class="col-12">
                                    <input type="text" id="recipient-address" v-model="to" class="form-control" placeholder="Enter recipient wallet address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="amount">Amount:</label>
                                <div class="col-12">
                                    <input type="number" id="amount" step="any" min="0.000000000000000001" v-model.number="value" class="form-control" placeholder="Enter amount">
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
                                    <button type="submit" class="btn btn-effect-ripple btn-success" @click="secondStep">Next</button>
                                </div>
                            </div>
                        </div>
                        <!-- Step 2: Review -->
                        <div v-else="formState === 1" class="col-sm-12">
                            <div class="form-group">
                                <div class="col-12">
                                    <strong>Recipient Address:</strong> {{ to }}
                                    <hr>
                                    <strong>Amount:</strong> {{ value }} {{ tokenSymbol }}

                                    <div class="totals">
                                        <strong>Transaction Fee:</strong> {{ transactionFee }} {{ tokenSymbol }}
                                        <br>
                                        <strong>Total:</strong> {{ value + transactionFee }} {{ tokenSymbol }}
                                    </div>
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
                                    <button type="reset" class="btn btn-effect-ripple btn-secondary" @click="formState--">Previous</button>
                                    <button type="submit" class="btn btn-effect-ripple btn-success" @click="transferToken">Transfer</button>
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
                <balance></balance>
            </div>
        </div>
        <div v-else>
            <error-screen v-bind:error-code="error"></error-screen>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import Card from '../card/Card';
    import ErrorScreen from '../ErrorScreen';
    import TokenMethods from '../../utils/tokenMethods';
    import monitorWeb3 from '../../utils/monitorWeb3';
    import {ETHERSCAN_TX_URL} from '../../utils/constants/networks';
    import sweetalert from '../../../vendors/sweetalert2/dist/sweetalert2.min.js';

    export default {
        data() {
            return {
                formState: 0,
                to: null,
                value: null,
                transactionFee: 0,
                errors: []
            }
        },
        computed: mapState({
            isInjected: state => state.web3.isInjected,
            coinbase: state => state.web3.coinbase,
            error: state => state.web3.error,
            tokenSymbol: state => state.token.symbol,
            accountBalance: state => state.token.accountBalance,
            tokenMethods() {
                if (this.isInjected) {
                    return new TokenMethods(this.$store.state.token.instance());
                }
                return null;
            }
        }),
        beforeCreate() {
            this.$store.dispatch('registerWeb3').then((result) => {
                this.$store.dispatch('registerToken').then((result) => {
                    monitorWeb3(result.state);
                });
            });
        },
        methods: {
            resetForm() {
                this.to = null;
                this.value = null;
            },
            secondStep() {
                this.validateForm();

                if (this.errors.length > 0) {
                    return;
                }

                // Estimate transaction fee
                this.transactionFee = this.tokenMethods.estimateTransactionFee(this.to);

                this.formState = 1;
            },
            validateForm() {
                this.errors = [];

                // Check wallet address
                if (!this.to) {
                    this.errors.push('Missing recipient wallet address!');

                } else if (!this.$store.state.web3.instance().isAddress(this.to)) {
                    this.errors.push('Recipient wallet address is not valid!');
                }

                // Check amount
                if (this.value <= 0) {
                    this.errors.push('Amount must be higher then 0!');
                }

                // Check if user has enough balance
                if ((this.value + this.transactionFee) > this.accountBalance) {
                    this.errors.push('Your account balance is to low!');
                }
            },
            transferToken() {
                this.validateForm();

                // Check for errors
                if (this.errors.length > 0) {
                    return;
                }

                // Send transaction
                this.tokenMethods.sendPreSignedTransaction(this.coinbase, this.to, this.value, this.transactionFee).then((result) => {

                    if (result) {
                        this.resetForm();
                        this.formState = 0;

                        let txUrl = '<a href="' + ETHERSCAN_TX_URL + result + '" target="_blank">' + ETHERSCAN_TX_URL + '0x...</a>';
                        this.successAlert('Your transaction is settled', 'Tx URL: \n' + txUrl);
                    } else {
                        this.dangerAlert('Error', 'Signature is not valid!');
                    }
                }).catch((err) => {
                    this.dangerAlert('Error', 'There was an unexpected error!');
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
            ErrorScreen,
            'card': Card,
            'error-screen': ErrorScreen,
        }
    }
</script>
<style src="../../../vendors/sweetalert2/dist/sweetalert2.min.css"></style>
<style src="../../../css/custom_css/sweet_alert2.css"></style>
<style type="text/css" scoped>
    .totals {
        background: #e8e8e8;
        padding: 10px;
        margin-top: 15px;
    }
</style>
