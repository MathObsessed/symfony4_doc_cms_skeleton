import Vue from 'vue';

import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue);

import router from './router';
import App from './components/App';

Vue.prototype.$config = APP_CONFIG;

new Vue({
    el: '#app',
    router: router,
    components: {
        App
    }
});
