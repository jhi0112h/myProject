
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// vendor
require('../bootstrap');
window.Vue = require('vue');

// 3rd party
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

// loader
import MoonLoader from 'vue-spinner/src/MoonLoader.vue';

// search
import Search from './search/Search.vue';

// app
import router from './router';
import store from '../common/Store';
import eventBus from '../common/Event';
import formatters from '../common/Formatters';
import InstantSearch from 'vue-instantsearch';
import anime from 'animejs';

Vue.use(formatters);
Vue.use(eventBus);
Vue.use(InstantSearch);

const admin = new Vue({
    el: '#admin',
    eventBus,
    store,
    router,
    components: { MoonLoader: MoonLoader, Search: Search },
    data: () => ({
        drawer: true,
        navigatorAnimation: {},
    }),
    computed: {
        showLoader() {
            return store.getters.showLoader;
        },
        showSnackbar: {
            get() {
                return store.getters.showSnackbar;
            },
            set(val) {
                if(!val) store.commit('hideSnackbar');
            }
        },
        snackbarMessage() {
            return store.getters.snackbarMessage;
        },
        snackbarColor() {
            return store.getters.snackbarColor;
        },
        snackbarDuration() {
            return store.getters.snackbarDuration;
        },

        // dialog
        showDialog: {
            get() {
                return store.getters.showDialog;
            },
            set(val) {
                if(!val) store.commit('hideDialog');
            }
        },
        dialogType() {
            return store.getters.dialogType
        },
        dialogTitle() {
            return store.getters.dialogTitle
        },
        dialogMessage() {
            return store.getters.dialogMessage
        },
        dialogIcon() {
            return store.getters.dialogIcon
        },

    },
    methods: {
        menuClick(routeName, routeType) {

            let rn = routeType || 'vue';

            if(rn==='vue') {

                this.$router.push({name: routeName});
            }
            if(rn==='full_load') {

                window.location.href = routeName;
            }
        },
        clickLogout(logoutUrl,afterLogoutRedirectUrl) {
            axios.post(logoutUrl).then((r)=>{
                window.location.href = afterLogoutRedirectUrl;
            });
        },
        dialogOk() {
            store.commit('dialogOk');
        },
        dialogCancel() {
            store.commit('dialogCancel');
        },
        ListItemMouseOver(event) {
            anime({
                targets: event.currentTarget.querySelector('.v-avatar'),
                borderRadius: '15px',
            })
        },
        ListItemMouseOut(event) {
            anime({
                targets: event.currentTarget.querySelector('.v-avatar'),
                borderRadius: '50%',
            })
        },
    }
});