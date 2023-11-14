let state = {
    web3: {
        isInjected: false,
        instance: null,
        networkId: null,
        gasPrice: null,
        blockNumber: null,
        coinbase: null,
        balance: null,
        error: false
    },
    token: {
        instance: null,
        totalSupply: null,
        decimals: null,
        name: null,
        symbol: null,
        accountBalance: null
    },
    document: {
        instance: null,
        documents: false,
    }
};

export default state;
