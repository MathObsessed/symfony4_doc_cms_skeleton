import Vue from 'vue';

import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue);

import router from './router';
import store from './store';
import App from './components/App';

new Vue({ router, store, render: h => h(App) }).$mount('#app');
