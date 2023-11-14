import Web3 from 'web3';

let getWeb3 = new Promise((resolve, reject) => {

    // Check for web3
    if (typeof web3 !== 'undefined') {

        web3 = new Web3(web3.currentProvider);

        resolve({
            injectedWeb3: web3.isConnected(),
            web3() {
                return web3;
            }
        });

    } else {
        reject(new Error('Browser Extension is not installed!'));
    }

}).then(result => {

    // Get network ID
    return new Promise((resolve, reject) => {

        result.web3().version.getNetwork((err, networkId) => {

            if (err) {
                reject(new Error('Unable to retrieve network ID!'));
            } else {
                resolve(Object.assign({}, result, {networkId}));
            }
        });
    });

}).then(result => {

    // Get Coinbase
    return new Promise((resolve, reject) => {

        result.web3().eth.getCoinbase((err, coinbase) => {

            if (err) {
                reject(new Error('Unable to retrieve coinbase!'));
            } else {
                resolve(Object.assign({}, result, { coinbase }));
            }
        });
    });

}).then(result => {

    // Get balance
    return new Promise((resolve, reject) => {

        result.web3().eth.getBalance(result.coinbase, (err, balance) => {

            if (err) {
                reject('Unable to retrieve balance for address: ' + result.coinbase);
            } else {
                resolve(Object.assign({}, result, { balance }));
            }
        });
    });
});

export default getWeb3
