import getWeb3 from '../utils/getWeb3';
import getTokenContract from '../utils/getTokenContract';
import DocumentContract from '../utils/DocumentContract';
import {APPROVED_NETWORK_ID} from '../utils/constants/networks';
import {ERRORS} from '../utils/constants/errors';

let actions = {

    registerWeb3({state, commit}) {

        return new Promise((resolve, reject) => {

            getWeb3.then((result) => {

                commit('registerWeb3Instance', {
                    result,
                    callback: (state) => {
                        resolve({state})
                    }
                })

            }).catch((error) => {

                if (!(state && state.web3 && state.web3.instance)) {

                    const result = error.result;
                    commit('registerWeb3Instance', {
                        result: {
                            web3: (result && result.hasInjectedWeb3 ? result.web3 : null),
                            hasInjectedWeb3: (result && result.hasInjectedWeb3 ? result.hasInjectedWeb3 : false),
                            web3Error: error.error
                        },
                        callback: (state) => {
                            reject({state, error});
                        }
                    })
                }
            })
        })
    },

    registerToken({state, commit}) {

        return new Promise((resolve, reject) => {

            // Check for correct network
            if (state.web3.networkId !== APPROVED_NETWORK_ID) {

                commit('updateWeb3Properties', {
                    properties: ['error'],
                    values: [ERRORS.WRONG_NETWORK]
                });

                return;
            }

            getTokenContract.then((result) => {

                commit('registerTokenInstance', {
                    result,
                    callback: (state) => {
                        resolve({state})
                    }
                });

            }).catch((error) => {

                if (!(state && state.token && state.token.instance)) {

                    commit('registerTokenInstance', {
                        error,
                        callback: (state) => {
                            reject({state, error});
                        }
                    })
                }
            });


        });
    },

    registerDocument({state, commit}) {
        return new Promise((resolve, reject) => {
            // Check for correct network
            if (state.web3.networkId !== APPROVED_NETWORK_ID) {
                commit('updateWeb3Properties', {
                    properties: ['error'],
                    values: [ERRORS.WRONG_NETWORK]
                });
                return;
            }

            DocumentContract.getDocumentContract().then(result => {
                const contract = new DocumentContract(result);

                contract.getDocumentsInRange(state.web3.coinbase, 0).then(documents => {
                    commit('setDocuments', documents.reverse());
                });

                commit('registerDocumentInstance', {
                    result,
                    callback: (state) => {
                        resolve({state})
                    }
                });
            }).catch((error) => {
                if (!(state && state.document && state.document.instance)) {
                    commit('registerDocumentInstance', {
                        error,
                        callback: (state) => {
                            reject({state, error});
                        }
                    })
                }
            });
        });
    },

    updateWeb3Properties({commit}, payload) {
        commit('updateWeb3Properties', payload);
    },

    updateTokenProperties({commit}, payload) {
        commit('updateTokenProperties', payload);
    }
};

export default actions;
