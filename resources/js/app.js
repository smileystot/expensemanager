require('./bootstrap');
import Vue from 'vue'
import Vuetify from 'vuetify'
import VueApexCharts from 'vue-apexcharts'
import store from './store'
import router from './router'
import LoginApp from './components/LoginApp.vue';
import AppComponent from './components/AppComponent.vue';

Vue.use(Vuetify)
Vue.use(VueApexCharts)
const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
        LoginApp,
        AppComponent
    },
    vuetify: new Vuetify()
})
