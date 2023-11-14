export const NETWORKS = {
    '1': 'Main Net',
    '2': 'Deprecated Morden test network',
    '3': 'Ropsten test network',
    '4': 'Rinkeby test network',
    '42': 'Kovan test network',
    '4447': 'Truffle Develop Network',
    '5777': 'Ganache Blockchain',
    '666': 'Daniel Private Blockchain'
};

export const APPROVED_NETWORK_ID = process.env.NODE_ENV === 'development' ? '42' : '42';    // TODO: replace production network

export const ETHERSCAN_TX_URL = process.env.NODE_ENV === 'development' ? 'https://kovan.etherscan.io/tx/' : 'https://kovan.etherscan.io/tx/';   // TODO: replace production url
