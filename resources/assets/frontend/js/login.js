// Include Axios
window.axios = require('axios');

// Set CSRF token for Axios requests
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Include web3 & web3 auth
window.Web3 = require('web3');
window.Web3Auth = require('../../js/web3/auth.js');

// Include Vue
window.Vue = require('vue');

import {mapState} from 'vuex'
import store from '../../js/store';
import monitorWeb3 from '../../js/utils/monitorWeb3';
import {ERRORS} from '../../js/utils/constants/errors';

const app = new Vue({
    el: '#app',
    store,
    data: {
        ERRORS: ERRORS,
    },
    computed: mapState({
        isInjected: state => state.web3.isInjected,
        error: state => state.web3.error,
    }),
    beforeCreate() {
        this.$store.dispatch('registerWeb3').then((result) => {
            monitorWeb3(result.state);
        });
    },
});
