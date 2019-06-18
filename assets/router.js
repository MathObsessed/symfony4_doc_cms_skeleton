import Vue from 'vue';
import Router from 'vue-router';

import store from './store';
import HomePage from './components/pages/HomePage';
import LoginPage from './components/pages/LoginPage';
import RegisterPage from './components/pages/RegisterPage';

Vue.use(Router);

const clearError = (to, from, next) => {
    store.dispatch('clearError');
    next();
};

const router = new Router({
    mode: 'history',
    routes: [
        { path: '/', name: 'app_homepage', component: HomePage, meta: { requiresAuth: true } },
        { path: '/login', name: 'app_login', component: LoginPage, beforeEnter: clearError },
        { path: '/register', name: 'app_register', component: RegisterPage , beforeEnter: clearError },
        { path: '*', redirect: { name: 'app_homepage' } }
    ],
    scrollBehavior: function (to, from, savedPosition) {
        return (savedPosition || { x: 0, y: 0 });
    }
});

router.beforeEach((to, from, next) => {
    let goto = undefined;

    if (to.matched.some(record => record.meta.requiresAuth) && !store.getters.isAuthenticated) {
        goto = { name: 'app_login' };
    }

    next(goto);
});

export default router;
