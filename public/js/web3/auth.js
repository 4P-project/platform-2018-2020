'use strict';

const Web3 = require('web3');
const Eth = require('ethjs');
const ethUtil = require('ethereumjs-util');
const axios = require('axios');

export function login(msg, url, callback) {

    web3 = new Web3(web3.currentProvider);
    let eth = new Eth(web3.currentProvider);

    msg = ethUtil.bufferToHex(new Buffer(msg, 'utf-8'));
    let from = web3.eth.accounts[0];

    eth.personal_sign(msg, from)
        .then((signed) => {

            // Create AJAX request to verify signature on server side
            axios.post(url, {

                account: web3.eth.accounts[0],
                signed: signed
            }).then(function (response) {

                if (response.data.auth) {

                    window.location.href = response.data.intended
                } else {

                    callback(response.data.error);
                }

            }).catch(function(error) {

                console.error(error);

            });
        });
}
