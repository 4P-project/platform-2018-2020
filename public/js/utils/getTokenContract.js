import Web3 from 'web3';
import {address, ABI} from './constants/tokenContract';

let getTokenContract = new Promise((resolve, reject) => {

    window.addEventListener('load', function() {
        let web3 = window.web3;

        if (typeof web3 !== 'undefined') {
            web3 = new Web3(web3.currentProvider);
            let tokenContract = web3.eth.contract(ABI).at(address);

            resolve(tokenContract);
        }
    });
});

export default getTokenContract;
