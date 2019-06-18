import Vue from 'vue';
import Vuex from 'vuex';

import api from './api';

Vue.use(Vuex);

const defaultErrorMessage = 'Unexpected error';

export default new Vuex.Store({
    state: {
        title: '',
        isLoading: false,
        error: null,
        login: null
    },
    getters: {
        title (state) {
            return state.title;
        },
        isLoading (state) {
            return state.isLoading;
        },
        hasError (state) {
            return (state.error !== null);
        },
        error (state) {
            return state.error;
        },
        isAuthenticated (state) {
            return !!state.login;
        },
        login (state) {
            return state.login;
        }
    },
    mutations: {
        ['INITIALIZATION'](state, data) {
            state.title = data.title;
            state.login = data.login;
        },
        ['AUTHENTICATION'](state) {
            state.isLoading = true;
            state.error = null;
            state.login = null;
        },
        ['AUTHENTICATION_SUCCESS'](state, data) {
            state.isLoading = false;
            state.error = null;
            state.login = data.login;
        },
        ['AUTHENTICATION_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.data.message || defaultErrorMessage;
            state.login = null;
        },
        ['LOGOUT'](state) {
            state.isLoading = true;
        },
        ['LOGOUT_COMPLETE'](state) {
            state.isLoading = false;
            state.login = null;
        },
        ['REGISTRATION'](state) {
            state.isLoading = true;
            state.error = null;
        },
        ['REGISTRATION_SUCCESS'](state) {
            state.isLoading = false;
            state.error = null;
        },
        ['REGISTRATION_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.data.message || defaultErrorMessage;
        },
        ['CLEAR_ERROR'](state) {
            state.error = null;
        }
    },
    actions: {
        init ({ commit }, payload) {
            commit('INITIALIZATION', payload);
        },
        login ({ commit }, payload) {
            commit('AUTHENTICATION');

            return api.login(payload.login, payload.password)
                .then(result => commit('AUTHENTICATION_SUCCESS', result.data))
                .catch(error => commit('AUTHENTICATION_ERROR', error.response));
        },
        logout ({ commit }) {
            commit('LOGOUT');

            return api.logout()
                .then(() => commit('LOGOUT_COMPLETE'));
        },
        register ({ commit }, payload) {
            commit('REGISTRATION');

            return api.register(payload.login, payload.password)
                .then((response) =>
                    typeof response.data.message !== 'undefined' ?
                    commit('REGISTRATION_ERROR', response) :
                    commit('REGISTRATION_SUCCESS')
                )
                .catch(error => commit('REGISTRATION_ERROR', error.response));
        },
        clearError ({ commit }) {
            commit('CLEAR_ERROR');
        }
    }
});
