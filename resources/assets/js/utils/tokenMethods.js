import Eth from 'ethjs';
import ether from '../utils/ether';
import {APPROVED_NETWORK_ID} from './constants/networks';
import {FEE_TAKER_ADDRESS} from './constants/feeTaker';
import axios from 'axios';

const TRANSFER_SINGLE = 0;
const TRANSFER_BULK = 1;
const TRANSFER_MANY = 2;

function TokenMethods(token) {

    this.token = token;

    /**
     * Method return calculated hash
     *
     * @param from
     * @param to
     * @param value
     * @param fee
     * @param nonce
     * @returns {Promise<any>}
     */
    this.calculateHash = function(from, to, value, fee, nonce) {

        return new Promise((resolve, reject) => {

            this.token.calculateHash(from, to, value, fee, nonce, (err, calculatedHash) => {

                if (err) {
                    reject(err);
                } else {
                    resolve(calculatedHash);
                }
            });

        });
    };

    /**
     * Method return calculated many hash
     *
     * @param from
     * @param tos
     * @param values
     * @param fee
     * @param nonce
     * @returns {Promise<any>}
     */
    this.calculateManyHash = function(from, tos, values, fee, nonce) {

        return new Promise((resolve, reject) => {

            this.token.calculateManyHash(from, tos, values, fee, nonce, (err, calculatedHash) => {

                if (err) {
                    reject(err);
                } else {
                    resolve(calculatedHash);
                }
            });

        });
    };

    /**
     * Method check if signature is valid
     *
     * @param from
     * @param calculatedHash
     * @param v
     * @param r
     * @param s
     * @returns {Promise<any>}
     */
    this.isValidSignature = function(from, calculatedHash, v, r, s) {

        return new Promise((resolve, reject) => {

            this.token.isValidSignature(from, calculatedHash, v, r, s, (err, isValid) => {

                if (err) {
                    reject(err);
                } else {
                    resolve(isValid);
                }
            });

        });
    };

    /**
     * Method return number of FOUR tokens for a given ETH
     *
     * @param eth
     * @returns {number}
     */
    this.getTokensFromEther = function(eth) {
        // TODO:: get conversion from ETH/FOUR when token arrive on market

        // Assume that ETH price is 400€
        let euroEth = 400;

        // Assume that FOUR price is 0.1€
        let euroFour = 0.1;

        return (euroEth / euroFour) * eth;
    };

    /**
     * Method return gas price in wei
     *
     * @returns string
     */
    this.getGasPrice = function() {
        return web3.toWei(2, 'gwei');
    };

    /**
     * Method return gas Limit
     *
     * @returns {number}
     */
    this.getGasLimit = function() {
        return 600000;
    };

    /**
     * Method return estimated gas units for transaction
     *
     * @param transfers
     * @returns {number}
     */
    this.estimateGasUnits = function(transfers) {

        // Gas units for feeTaker transfer + to (2 * transfer)
        let gasUnits = 95000;

        // For each subsequent transfer add 21k units of gas
        gasUnits += (30000 * (transfers - 1));

        return gasUnits;
    };

    /**
     * Method return estimated transaction fee in FOUR tokens
     *
     * @param to
     * @returns {number}
     */
    this.estimateTransactionFee = function(to) {

        let transfers = 1;

        if (Array.isArray(to)) {
            transfers = to.length;
        }

        // Estimate Gas Units
        let gasUnits = this.estimateGasUnits(transfers);

        // Calculate transaction fee in ETH
        let txCostEth = web3.fromWei(gasUnits * this.getGasPrice(), 'ether');

        // Return FOUR fee * 2
        return this.getTokensFromEther(txCostEth) * 2;
    };

    /**
     * Method send raw transaction
     *
     * @param from
     * @param to
     * @param value
     * @param fee
     * @param nonce
     * @param v
     * @param r
     * @param s
     * @param transferType
     * @returns {Promise<any>}
     */
    this.transferPreSigned = function(from, to, value, fee, nonce, v, r, s, transferType) {

        let self = this;

        return new Promise((resolve, reject) => {

            let contractData = null;

            // Get transaction data depends on transfer type
            if (transferType === TRANSFER_SINGLE) {
                contractData = self.token.transferPreSigned.getData(from, to, value, fee, nonce, v, r, s, {from: FEE_TAKER_ADDRESS});

            } else if (transferType === TRANSFER_BULK) {
                contractData = self.token.transferPreSignedBulk.getData(from, to, value, fee, nonce, v, r, s, {from: FEE_TAKER_ADDRESS});

            } else if (transferType === TRANSFER_MANY) {
                contractData = self.token.transferPreSignedMany.getData(from, to, value, fee, nonce, v, r, s, {from: FEE_TAKER_ADDRESS});
            }

            // Get nonce
            web3.eth.getTransactionCount(FEE_TAKER_ADDRESS, function(err, nonce) {

                // Prepare transaction parameters
                const txParams = {
                    nonce: web3.toHex(nonce),
                    gasPrice: web3.toHex(self.getGasPrice()),
                    gasLimit: web3.toHex(self.getGasLimit()),
                    to: self.token.address,
                    data: contractData,
                    chainId: APPROVED_NETWORK_ID
                };

                // Create AJAX request to sign transaction on server side
                axios.post('/transaction/sign', {
                    txParams: txParams
                }).then(function (response) {

                    // Send raw transaction
                    web3.eth.sendRawTransaction('0x' + response.data.signedTx, (err, hash) => {
                        if (err) {
                            reject(err);
                        } else {
                            resolve(hash);
                        }
                    });

                }).catch(function(error) {
                    console.error(error);
                });

            });
        });
    };

    /**
     * Method prepare data for pre-signed transaction
     *
     * @param from
     * @param to
     * @param value
     * @param fee
     * @returns {Promise<*>}
     */
    this.sendPreSignedTransaction = async function(from, to, value, fee) {

        let eth = new Eth(web3.currentProvider);
        let nonce = Date.now();

        // Convert to wei
        value = ether(value);
        fee = ether(fee);

        // Calculate hash
        let hash = await this.calculateHash(from, to, value, fee, nonce);

        // Sign hash
        let signature = await eth.personal_sign(hash, from);

        // Get r, s, v values
        let r = signature.substr(0, 66);
        let s = '0x' + signature.substr(66, 64);
        let v = parseInt('0x' + signature.substr(130, 2));

        // Check if signature is valid
        let isValid = await this.isValidSignature(from, hash, v, r, s);

        // Send transaction if signature is valid
        if (isValid) {
            return await this.transferPreSigned(from, to, value, fee, nonce, v, r, s, TRANSFER_SINGLE);
        }

        return false;
    };

    /**
     * Method prepare data for bulk pre-signed transaction
     *
     * @param from
     * @param to
     * @param value
     * @param fee
     * @returns {Promise<*>}
     */
    this.sendPreSignedBulkTransaction = async function(from, to, value, fee) {

        let eth = new Eth(web3.currentProvider);

        // Data object
        let data = {
            from: [],
            to: to,
            value: [],
            fee: [],
            nonce: [],
            v: [],
            r: [],
            s: []
        };

        // Prepare required data for each pre-signed transaction
        for (let i = 0; i < to.length; i++) {

            data.from[i] = from;
            data.value[i] = ether(value[i]);
            data.fee[i] = fee;
            data.nonce[i] = Date.now() + i;

            // Calculate hash
            let hash = await this.calculateHash(data.from[i], data.to[i], data.value[i], data.fee[i], data.nonce[i]);

            // Sign hash
            let signature = await eth.personal_sign(hash, data.from[i]);

            // Get r, s, v values
            data.r[i] = signature.substr(0, 66);
            data.s[i] = '0x' + signature.substr(66, 64);
            data.v[i] = parseInt('0x' + signature.substr(130, 2));

            // Check if signature is valid
            let isValid = await this.isValidSignature(from, hash, data.v[i], data.r[i], data.s[i]);

            // Break if signature is invalid
            if (!isValid) {
                return false;
            }
        }

        // Send transaction
        return await this.transferPreSigned(data.from, data.to, data.value, data.fee, data.nonce, data.v, data.r, data.s, TRANSFER_BULK);
    };

    /**
     * Method prepare data for many pre-signed transaction
     *
     * @param from
     * @param tos
     * @param values
     * @param fee
     * @returns {Promise<*>}
     */
    this.sendPreSignedManyTransaction = async function(from, tos, values, fee) {

        let eth = new Eth(web3.currentProvider);
        let nonce = Date.now();

        // Convert to wei
        fee = ether(fee);

        for (let i = 0; i < values.length; i++) {
            values[i] = ether(values[i]);
        }

        // Calculate hash
        let hash = await this.calculateManyHash(from, tos, values, fee, nonce);

        // Sign hash
        let signature = await eth.personal_sign(hash, from);

        // Get r, s, v values
        let r = signature.substr(0, 66);
        let s = '0x' + signature.substr(66, 64);
        let v = parseInt('0x' + signature.substr(130, 2));

        // Check if signature is valid
        let isValid = await this.isValidSignature(from, hash, v, r, s);

        // Send transaction if signature is valid
        if (isValid) {
            return await this.transferPreSigned(from, tos, values, fee, nonce, v, r, s, TRANSFER_MANY);
        }

        return false;
    };
}

export default TokenMethods
