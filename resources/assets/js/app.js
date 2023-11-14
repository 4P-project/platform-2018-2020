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

// Include Vue
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from './store';

Vue.component('personal-wallet', require('./components/wallet/PersonalWallet.vue'));
Vue.component('organizations-wallet', require('./components/wallet/OrganizationsWallet.vue'));
Vue.component('balance', require('./components/wallet/Balance.vue'));
Vue.component('document-send', require('./components/document/Send.vue'));
Vue.component('documents-view', require('./components/document/View.vue'));
Vue.component('passport-clients', require('./components/passport/Clients.vue'));

const app = new Vue({
    el: '#app',
    store
});
