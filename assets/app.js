import Vue from 'vue';

import App from './components/App';

Vue.prototype.$config = APP_CONFIG;

new Vue({
    el: '#app',
    components: {
        App
    }
});
