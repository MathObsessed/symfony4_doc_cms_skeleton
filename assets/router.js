import Vue from 'vue';
import Router from 'vue-router';

import store from './store';
import Home from './components/Home';
import Login from './components/Login';
import Register from './components/Register';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [
        { path: '/', name: 'app_homepage', component: Home, meta: { requiresAuth: true } },
        { path: '/login', name: 'app_login', component: Login },
        { path: '/register', name: 'app_register', component: Register },
        { path: '*', redirect: '/' }
    ],
    scrollBehavior: function (to, from, savedPosition) {
        return (savedPosition || { x: 0, y: 0 });
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.isAuthenticated) {
            next('/login');
        }
        else {
            next();
        }
    }
    else {
        next();
    }
});

export default router;
