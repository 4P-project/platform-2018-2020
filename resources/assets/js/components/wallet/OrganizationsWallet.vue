<template>
    <div>
        <div v-if="!error" class="row">
            <!-- Info alert -->
            <div class="col-sm-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
                    Here you can transfer FOUR tokens from your wallet to your employees' wallets. Simply choose the employee and the amount you wish to send.<br>
                    You can also check the balance of your account and your wallet's address.<br>
                    Always double check the amount you wish to send. Once submitted, it cannot be undone.
                </div>
            </div>

            <!-- Transfer FOUR token -->
            <div class="col-md-7">
                <card title="<i class='fa fa-arrow-circle-up'></i> Transfer FOUR token">
                    <div v-if="isInjected" class="row">
                        <!-- Step 1: Input -->
                        <div v-if="formState === 0" class="col-sm-12">
                            <strong class="col-sm-12 control-label">Select employees:</strong>
                            <hr>
                            <div v-for="employee in employees" class="col-sm-12 row employee">
                                <div class="col-sm-6">
                                    <label :for="'employee_' + employee.user.id" :title="employee.user.wallet"><input type="checkbox" :id="'employee_' + employee.user.id" :value="employee" v-model="checkedEmployees"> {{ employee.user.last_name }} {{ employee.user.first_name }}</label>
                                </div>
                                <div class="col-sm-6">
                                    <input v-model.number="employee.amount" step="any" min="0.000000000000000001" class="form-control" placeholder="Enter amount">
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
                                    <strong>Recipient Address:</strong> {{ tos }}
                                    <hr>
                                    <strong>Amount:</strong> {{ values }} {{ tokenSymbol }}

                                    <div class="totals">
                                        <strong>Transaction Fee:</strong> {{ transactionFee }} {{ tokenSymbol }}
                                        <br>
                                        <strong>Total:</strong> {{ sumValues + transactionFee }} {{ tokenSymbol }}
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
                <card title="<i class='fa fa-money'></i> Balance">
                    <div v-if="isInjected" class="row">
                        <div class="col-sm-12">
                            <strong>Wallet Address:</strong> {{ coinbase }}
                            <hr>
                            <strong>Account Balance:</strong> {{ parseFloat(accountBalance) }} {{ tokenSymbol }}
                        </div>
                    </div>
                    <div v-else class="text-center">
                        <img :src="'../../../img/loader.gif'" alt="loading..." height="64" width="64">
                    </div>
                </card>
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
    import axios from 'axios';
    import sweetalert from '../../../vendors/sweetalert2/dist/sweetalert2.min.js';

    export default {
        data() {
            return {
                formState: 0,
                tos: [],
                values: [],
                transactionFee: 0,
                errors: [],
                sumValues: 0,
                employees: [],
                checkedEmployees: []
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
        mounted() {
            // Retrieve employees
            axios.get('/account/employee/ajax-list').then((response) => {
                this.employees = response.data;
            });
        },
        methods: {
            resetForm() {
                this.tos = [];
                this.values = [];
                this.checkedEmployees = [];

                // Clear employees amount
                for (let i = 0; i < this.employees.length; i++) {
                    this.employees[i].amount = null;
                }
            },
            secondStep() {
                this.tos = [];
                this.values = [];

                // Convert selected employees to values and to array
                for (let i = 0; i < this.checkedEmployees.length; i++) {

                    let employee = this.checkedEmployees[i];

                    if (employee.amount > 0){
                        this.tos.push(employee.user.wallet);
                        this.values.push(employee.amount);
                    }
                }

                // Validate
                this.validateForm();

                if (this.errors.length > 0) {
                    return;
                }

                // Estimate transaction fee
                this.transactionFee = this.tokenMethods.estimateTransactionFee(this.tos);

                this.formState = 1;
            },
            validateForm() {
                this.errors = [];

                // Check wallet address
                if (this.tos.length === 0) {
                    this.errors.push('Missing recipient wallet address!');

                } /*else if (!this.$store.state.web3.instance().isAddress(this.to)) {
                    this.errors.push('Recipient wallet address is not valid!');
                }*/

                // Check amount
                /*if (this.value <= 0) {
                    this.errors.push('Amount must be higher then 0!');
                }*/

                // Check if user has enough balance
                let sumValues = 0;
                for (let i = 0; i < this.values.length; i++) {
                    sumValues += parseFloat(this.values[i]);
                }
                this.sumValues = sumValues;

                if ((sumValues + this.transactionFee) > this.accountBalance) {
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
                this.tokenMethods.sendPreSignedManyTransaction(this.coinbase, this.tos, this.values, this.transactionFee).then((result) => {

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
            'error-screen': ErrorScreen
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
    .employee.row {
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #ccc;
    }
</style>
