<template>
    <div v-if="!error">
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
    <div v-else>
        <error-screen v-bind:error-code="error"></error-screen>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import Card from '../card/Card';
    import ErrorScreen from '../ErrorScreen';
    import monitorWeb3 from '../../utils/monitorWeb3';

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
        }),
        beforeCreate() {
            this.$store.dispatch('registerWeb3').then((result) => {
                this.$store.dispatch('registerToken').then((result) => {
                    monitorWeb3(result.state);
                });
            });
        },
        components: {
            ErrorScreen,
            'card': Card,
            'error-screen': ErrorScreen
        }
    }
</script>
