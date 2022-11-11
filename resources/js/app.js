import './bootstrap';
import Vue from 'vue';

import VueRouter from 'vue-router'
import Vuetify from 'vuetify';
import Vuex from 'vuex';
import VueI18n from 'vue-i18n';
import Notifications from 'vue-notification';
import 'vuetify/dist/vuetify.min.css';
Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(VueI18n);
Vue.use(Notifications)

const messages = require('./languages.json');
const i18n = new VueI18n({    locale: window.user!=null ? window.user.language:'en', fallbackLocale: 'en',   messages, });

import App from './pages/App';
import Dashboard from './pages/Dashboard.vue';
import Profile from './pages/Profile.vue';
import NotificationsPage from './pages/Notifications.vue';
import PageNotFound from './pages/PageNotFound.vue';
const store = new Vuex.Store({
    state: {
        user: window.user,
        notifications: [],
        account_activities: [],
        market: null
    },
    mutations: {
        SET_MARKET: (state, market) => {
            state.market = market;
        },
        SET_ACCOUNT_ACTIVITIES: (state, account_activities) => {
            state.account_activities = account_activities;
        },
        SET_USER: (state, user) => {
            state.user = user;
        },
        SET_NOTIFICATIONS: (state, notifications) => {
            state.notifications = notifications;
        },
        ADD_NOTIFICATION: (state, notification) => {
            notification.new = true;
            state.notifications.unshift(notification);
        },
        REMOVE_NOTIFICATION: (state, notification) => {
            let index = state.notifications.findIndex(item => item.id === notification.id)
            state.notification.splice(index, 1)
        },
        
    }
})

const router = new VueRouter({
    mode: 'history',
    base: '/dashboard',
    routes: [
          {path: '/' , component: Dashboard },
          {path: '/profile' , component: Profile },
          {path: '/notifications' , component: NotificationsPage },
        {path: "*", name: 'PageNotFound' ,component: PageNotFound }
    ],
});



const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    components: { App },
    router: router,
    store,i18n,
    methods: {
        sendnotification(group,type,title,text,duration){
            this.$notify({
                group:group,
                type: type,
                title: title,
                text: text,
                duration:duration,
              });
          },
    },
}).$mount('#app');
