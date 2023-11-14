import Web3 from 'web3';
import store from '../store';
import {ERRORS} from './constants/errors';

let getWeb3 = new Promise((resolve, reject) => {

    // Wait for loading completion to avoid race conditions with web3 injection timing.
    window.addEventListener('load', function() {

        let web3 = window.web3;

        // Check for web3 injected by browser
        if (typeof web3 !== 'undefined') {

            web3 = new Web3(web3.currentProvider);

            resolve({
                hasInjectedWeb3: web3.isConnected(),
                web3
            });

        } else {
            // Dispatch error - no web3 provider
            store.dispatch('updateWeb3Properties', {
                properties: ['error'],
                values: [ERRORS.NO_WEB3_PROVIDER]
            });

            reject({
                result: null,
                err: 'Unable to connect to Web3'
            });
        }
    });

}).then(result => {

    // Get network ID
    return new Promise((resolve, reject) => {

        result.web3.version.getNetwork((err, networkId) => {

            if (err) {
                result = Object.assign({}, result);
                reject({
                    result,
                    err
                });
            } else {
                resolve(Object.assign({}, result, {networkId}));
            }
        });
    });

}).then(result => {

    // Get gas price
    return new Promise((resolve, reject) => {

        result.web3.eth.getGasPrice((err, gasPrice) => {

            if (err) {
                result = Object.assign({}, result);
                reject({
                    result,
                    err
                });
            } else {
                resolve(Object.assign({}, result, {gasPrice}));
            }
        });
    });

}).then(result => {

    // Get Coinbase
    return new Promise((resolve, reject) => {

        result.web3.eth.getCoinbase((err, coinbase) => {

            if (err) {
                result = Object.assign({}, result);
                reject({
                    result,
                    err
                });
            } else {
                resolve(Object.assign({}, result, {coinbase}));
            }
        });
    });

}).then(result => {

    // Get balance
    return new Promise((resolve, reject) => {

        result.web3.eth.getBalance(result.coinbase, (err, balance) => {

            if (err) {
                result = Object.assign({}, result);
                reject({
                    result,
                    err
                });
            } else {
                resolve(Object.assign({}, result, {balance}));
            }
        });
    });
}).catch(err => {
    console.error(err);
});

export default getWeb3
