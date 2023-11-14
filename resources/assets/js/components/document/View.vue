<template>
    <div>
        <div v-if="!error" class="row">
            <!-- Info alert -->
            <div class="col-sm-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
                    Here you can view all of your received documents.
                </div>
            </div>
            <!-- Received document -->
            <div v-if="documents.length" class="col-md-12">
                <card v-for="document in documents" :key="document.index" :title="document.name" :disableToggling="true">
                    Sender: {{ document.sender }}<br/>
                    Description: {{ document.description }}<br/>
                    Doc Type: {{ document.docType.valueOf() }}<br/>
                    Opened At: {{ document.openedAt }}<br/>
                    <a :href="document.link">{{ document.name }}</a>
                </card>
            </div>
            <div v-else-if="documents === false" class="col-md-12">
                Retrieving documents...
            </div>
            <div v-else class="col-md-12">
                You have no documents yet
            </div>
        </div>
        <div v-else>
            <error-screen v-bind:error-code="error"/>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import Card from '../card/Card';
    import ErrorScreen from '../ErrorScreen';
    import monitorWeb3 from '../../utils/monitorWeb3';

    export default {
        data() {
            return {
                errors: [],
            }
        },
        computed: mapState({
            isInjected: state => state.web3.isInjected,
            error: state => state.web3.error,
            documents: state => state.document.documents,
        }),
        beforeCreate() {
            this.$store.dispatch('registerWeb3').then((result) => {
                this.$store.dispatch('registerDocument').then(result => {
                    monitorWeb3(result.state);
                });
            });
        },
        methods: {
            decryptFile() {
                // TODO:: connect with browser extension to decrypt file
            },
        },
        components: {
            'card': Card,
            'error-screen': ErrorScreen,
        }
    }
</script>
