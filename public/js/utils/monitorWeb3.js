import Web3 from 'web3';
import store from '../store';
import {ERRORS} from './constants/errors';
import {APPROVED_NETWORK_ID} from './constants/networks';

let monitorWeb3 = function(state) {

    window.onload = () => {
    let web3 = window.web3;
    let divisor = new web3.BigNumber(10).toPower(state.token.decimals);

    // Check for web3 injected by browser
    if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
    } else {

        // Dispatch error - no web3 provider
        store.dispatch('updateWeb3Properties', {
            properties: ['error'],
            values: [ERRORS.NO_WEB3_PROVIDER]
        });
    }

    if (web3) {
        // Reload block number & token balance
        web3.eth.filter('latest', function(err, latestBlock) {
            if (!err) {
                // If it's new block - update block number and account token balance
                if (latestBlock !== state.web3.blockNumber) {
                    // Dispatch state
                    store.dispatch('updateWeb3Properties', {
                        properties: ['blockNumber'],
                        values: [latestBlock]
                    });

                    // Set the account holder token balance
                    state.token.instance().balanceOf(state.web3.coinbase, (err, newAccountBalance) => {
                        if (!err) {

                            newAccountBalance = newAccountBalance.div(divisor).toString();

                            if (newAccountBalance !== state.token.accountBalance) {
                                // Dispatch state
                                store.dispatch('updateTokenProperties', {
                                    properties: ['accountBalance'],
                                    values: [newAccountBalance]
                                });
                            }
                        }
                    });
                }
            }
        });
    }

    setInterval(() => {

        if (web3) {
            // Get network Id
            web3.version.getNetwork((err, newNetworkId) => {
                if (!err) {
                    // Check if network is changed
                    if (newNetworkId !== APPROVED_NETWORK_ID) {

                        // Dispatch error/warning to change network
                        store.dispatch('updateWeb3Properties', {
                            properties: ['networkId', 'error'],
                            values: [newNetworkId, ERRORS.WRONG_NETWORK]
                        });

                    } else if (newNetworkId === APPROVED_NETWORK_ID) {

                        if (ERRORS.NO_ERROR !== state.web3.error) {
                            // Dispatch no error
                            store.dispatch('updateWeb3Properties', {
                                properties: ['error'],
                                values: [ERRORS.NO_ERROR]
                            });
                        }
                    }
                }
            });

            // Reload gas price
            web3.eth.getGasPrice((err, newGasPrice) => {
                if (!err) {
                    // Dispatch state
                    store.dispatch('updateWeb3Properties', {
                        properties: ['gasPrice'],
                        values: [parseInt(newGasPrice, 10)]
                    });
                }
            });
        }

    }, 1000);
    };
};

export default monitorWeb3
