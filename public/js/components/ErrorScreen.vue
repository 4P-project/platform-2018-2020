<template>
    <div class="container-fluid errorscreen text-center">
        <div class="row">
            <div class="col-sm-12 m-auto">
                <img :src="'../../img/4thpillar/Logo_Bar.png'" alt="Logo">
                <div class="errorcreen-container">
                    <div class="col-sm-12 m-t-15">
                        <h3 class="error-title" v-html="errorMsg"></h3>
                        <p class="error-body" v-html="errorBody"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {NETWORKS, APPROVED_NETWORK_ID} from '../utils/constants/networks';
    import {ERRORS, ERROR_MESSAGE} from '../utils/constants/errors';

    export default {
        props: ['errorCode'],
        data() {
            return {
                errorMsg: ERROR_MESSAGE[this.errorCode]
            }
        },
        computed: {
            errorBody() {
                let msg = '';

                if (this.errorCode === ERRORS.WRONG_NETWORK) {
                    msg = 'Please connect to the <strong><u>' + NETWORKS[APPROVED_NETWORK_ID] + '</u></strong>.';
                }

                return msg;
            }
        }
    }
</script>
<style type="text/css" scoped>
    .container-fluid.errorscreen {
        padding-top: 6.5%;
        position: fixed;
        width: 100%;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: radial-gradient(ellipse at center, #5A93AF 0%, #004E74 100%);
        overflow-y: auto;
        z-index: 9999;
    }

    .errorcreen-container {
        color: #fff;
        padding: 20px 0;
    }

    .error-body {
        font-size: 18px;
    }
</style>
