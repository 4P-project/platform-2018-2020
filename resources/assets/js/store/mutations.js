let mutations = {

    registerWeb3Instance(state, payload) {

        let result = payload.result;

        state.web3.instance = () => result.web3;
        state.web3.coinbase = result.coinbase ? result.coinbase.toString() : state.web3.coinbase;
        state.web3.balance = result.balance ? result.balance.toString() : state.web3.balance;
        state.web3.networkId = result.networkId ? result.networkId.toString() : state.web3.networkId;
        state.web3.gasPrice = result.gasPrice ? parseInt(result.gasPrice, 10) : state.web3.gasPrice;
        state.web3.error = result.web3Error ? result.web3Error : state.web3.error;
        state.web3.isInjected = result.hasInjectedWeb3 ? result.hasInjectedWeb3 : state.web3.isInjected;

        if (payload.callback) {
            payload.callback(state)
        }
    },

    registerTokenInstance(state, payload) {

        let result = payload.result;

        // Store token instance
        state.token.instance = () => result;

        // Store token decimals
        result.decimals((err, decimals) => {
            if (!err) {
                state.token.decimals = parseInt(decimals, 10);

                // Divisor
                let divisor = new web3.BigNumber(10).toPower(state.token.decimals);

                // Set token total supply
                result.totalSupply((err, totalSupply) => {
                    if (!err) {
                        state.token.totalSupply = parseInt(totalSupply.div(divisor), 10);

                        // Set the account holder balance
                        result.balanceOf(state.web3.coinbase, (err, balance) => {
                            if (!err) {
                                state.token.accountBalance = balance.div(divisor).toString();

                                // Store token name
                                result.name((err, name) => {
                                    if (!err) {
                                        state.token.name = name.toString();

                                        // Store token symbol
                                        result.symbol((err, symbol) => {
                                            if (!err) {
                                                state.token.symbol = symbol.toString();

                                                // Callback
                                                if (payload.callback) {
                                                    payload.callback(state)
                                                }
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },

    registerDocumentInstance(state, payload) {
        let document = payload.result;

        state.document.instance = document;

        document.getDocumentsInRange(this.coinbase, 0).then(res => {
            state.document.documents = res;
        });

        // Callback
        if (payload.callback) {
            payload.callback(state)
        }
    },

    setDocuments: (state, documents) => state.document.documents = documents,

    updateWeb3Properties(state, payload) {

        // Refresh given web3 properties
        for (let i = 0; i < payload.properties.length; i++) {

            state.web3[payload.properties[i]] = payload.values[i];
        }
    },

    updateTokenProperties(state, payload) {

        // Refresh given token properties
        for (let i = 0; i < payload.properties.length; i++) {

            state.token[payload.properties[i]] = payload.values[i];
        }
    }
};

export default mutations;
