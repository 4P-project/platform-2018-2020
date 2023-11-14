import Web3 from 'web3';
import Eth from 'ethjs';
import ether from '../utils/ether';
import {address, ABI} from './constants/documentContract';
import {APPROVED_NETWORK_ID} from './constants/networks';
import {FEE_TAKER_ADDRESS} from './constants/feeTaker';
import axios from 'axios';

import TokenMethods from './tokenMethods';

export default class DocumentContract {

    constructor(contract) {
        this.contract = contract;
    }

    static getDocumentContract() {
        return new Promise((resolve, reject) => {
            let web3 = window.web3;

            if (typeof web3 !== 'undefined') {
                web3 = new Web3(web3.currentProvider);
                let contract = web3.eth.contract(ABI).at(address);

                resolve(contract);
            }
        });
    }

    isValidSignature(from, calculatedHash, v, r, s) {
        return new Promise((resolve, reject) => {
            this.contract.isValidSignature(from, calculatedHash, v, r, s, (err, isValid) => {
                if (err) {
                    reject(err);
                } else {
                    resolve(isValid);
                }
            });
        });
    }

    getDocument(receiver, index) {
        return new Promise((resolve, reject) => {
            this.contract.getDocument(receiver, index, (err, document) => {
                if (err) {
                    reject(err);
                } else {
                    resolve(document);
                }
            });
        });
    }

    getLastDocumentIndex(receiver) {
        return new Promise((resolve, reject) => {
            this.contract.getLastDocumentIndex(receiver, (err, lastDocumentIndex) => {
                if (err) {
                    reject(err);
                } else {
                    resolve(lastDocumentIndex);
                }
            });
        });
    }

    async getDocumentsInRange(receiver, from, to = null) {
        let documents = [];

        try {
            let lastDocumentIndex = await this.getLastDocumentIndex(receiver);

            // Check if range is not exceeded
            if (to > lastDocumentIndex || to === null) {
                to = lastDocumentIndex;
            }

            if (from > lastDocumentIndex) {
                from = lastDocumentIndex;
            }

            for (let i = from; i <= to; i++) {
                const document = await this.getDocument(receiver, i);

                // If document is not deleted
                if (document[1]) {
                    documents.push({
                        sender: document[0],
                        link: document[1],
                        name: document[2],
                        description: document[3],
                        docType: document[4],
                        openedAt: document[5],
                    });
                }
            }
        } catch (err) {
            console.error(err);
        }

        return documents;
    }

    /**
     * Method return gas price in wei
     *
     * @returns string
     */
    getGasPrice() {
        return web3.toWei(2, 'gwei');
    };

    /**
     * Method return gas Limit
     *
     * @returns {number}
     */
    getGasLimit() {
        return 600000;
    };

    calculatePreSignedDocumentHash(sender, receiver, link, name, description, docType, nonce) {
        return new Promise((resolve, reject) => {
            this.contract.calculatePreSignedDocumentHash(sender, receiver, link, name, description, docType, nonce, (err, calculatedHash) => {
                if (err) {
                    reject(err);
                } else {
                    resolve(calculatedHash);
                }
            });
        });
    }

    calculatePreSignedTokenHash(sender, receiver, value, fee, nonce) {
        return new Promise((resolve, reject) => {
            this.contract.calculatePreSignedDocumentHash(sender, receiver, value, fee, nonce, (err, calculatedHash) => {
                if (err) {
                    reject(err);
                } else {
                    resolve(calculatedHash);
                }
            });
        });
    }

    setPreSignedDocument(sender, receiver, link, name, description, docType, nonce, v, r, s) {
        let self = this;

        return new Promise((resolve, reject) => {

            let contractData = this.contract.setPreSignedDocument.getData(sender, receiver, link, name, description, docType, nonce, v, r, s, {from: FEE_TAKER_ADDRESS});

            // Get nonce
            web3.eth.getTransactionCount(FEE_TAKER_ADDRESS, function(err, nonce) {

                // Prepare transaction parameters
                const txParams = {
                    nonce: web3.toHex(nonce),
                    gasPrice: web3.toHex(self.getGasPrice()),
                    gasLimit: web3.toHex(self.getGasLimit()),
                    to: self.contract.address,
                    data: contractData,
                    chainId: APPROVED_NETWORK_ID
                };

                // Create AJAX request to sign transaction on server side
                axios.post('/transaction/sign', {
                    txParams: txParams
                }).then(function (response) {

                    if (response.data.error) {
                        console.error(response.data.error);
                    }

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
    }

    transferPreSignedTokenWithDocument(sender, receiver, value, fee, nonce, v, r, s, link, name, description, docType) {
        let self = this;

        return new Promise((resolve, reject) => {
            let contractData = this.contract.transferPreSignedTokenWithDocument.getData(sender, receiver, value, fee, nonce, v, r, s, link, name, description, docType, {from: FEE_TAKER_ADDRESS});

            // Get nonce
            web3.eth.getTransactionCount(FEE_TAKER_ADDRESS, function(err, nonce) {

                // Prepare transaction parameters
                const txParams = {
                    nonce: web3.toHex(nonce),
                    gasPrice: web3.toHex(self.getGasPrice()),
                    gasLimit: web3.toHex(self.getGasLimit()),
                    to: self.contract.address,
                    data: contractData,
                    chainId: APPROVED_NETWORK_ID
                };

                // Create AJAX request to sign transaction on server side
                axios.post('/transaction/sign', {
                    txParams: txParams
                }).then(function (response) {

                    if (response.data.error) {
                        console.error(response.data.error);
                    }

                    // Send raw transaction
                    web3.eth.sendRawTransaction('0x' + response.data.signedTx, (err, hash) => {console.log(err);
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
    }

    async sendPreSignedDocumentTransaction(sender, receiver, document) {
        let eth = new Eth(web3.currentProvider);
        let nonce = Date.now();

        // Calculate hash
        let hash = await this.calculatePreSignedDocumentHash(sender, receiver, document.link, document.name, document.description, document.docType, nonce);

        // Sign hash
        let signature = await eth.personal_sign(hash, sender);

        // Get r, s, v values
        let r = signature.substr(0, 66);
        let s = '0x' + signature.substr(66, 64);
        let v = parseInt('0x' + signature.substr(130, 2));

        // Check if signature is valid
        let isValid = await this.isValidSignature(sender, hash, v, r, s);

        // Send transaction if signature is valid
        if (isValid) {
            return await this.setPreSignedDocument(sender, receiver, document.link, document.name, document.description, document.docType, nonce, v, r, s);
        }

        return false;
    }

    async sendPreSignedTokenWithDocument(sender, receiver, document) {
        let eth = new Eth(web3.currentProvider);
        let nonce = Date.now();

        // Convert to wei
        let value = ether(0);
        let fee = ether(18);

        // Calculate hash
        let hash = await this.calculatePreSignedTokenHash(sender, receiver, value, fee, nonce);

        // Sign hash
        let signature = await eth.personal_sign(hash, sender);

        // Get r, s, v values
        let r = signature.substr(0, 66);
        let s = '0x' + signature.substr(66, 64);
        let v = parseInt('0x' + signature.substr(130, 2));

        // Check if signature is valid
        let isValid = await this.isValidSignature(sender, hash, v, r, s);

        // Send transaction if signature is valid
        if (isValid) {
            await this.transferPreSignedTokenWithDocument(sender, receiver, value, fee, nonce, v, r, s, document.link, document.name, document.description, document.docType);
        }
        return false;
    }
}
