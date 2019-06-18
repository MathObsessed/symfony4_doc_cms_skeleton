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
        ['INITIALIZING_DATA'](state, data) {
            state.title = data.title;
            state.login = data.login;
        },
        ['AUTHENTICATING'](state) {
            state.isLoading = true;
            state.error = null;
            state.login = null;
        },
        ['AUTHENTICATING_SUCCESS'](state, data) {
            state.isLoading = false;
            state.error = null;
            state.login = data.login;
        },
        ['AUTHENTICATING_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.data.message || defaultErrorMessage;
            state.login = null;
        },
        ['LOGGING_OUT'](state) {
            state.isLoading = true;
        },
        ['LOGGING_OUT_SUCCESS'](state) {
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
        }
    },
    actions: {
        init ({ commit }, payload) {
            commit('INITIALIZING_DATA', payload);
        },
        login ({ commit }, payload) {
            commit('AUTHENTICATING');

            return api.login(payload.login, payload.password)
                .then(result => commit('AUTHENTICATING_SUCCESS', result.data))
                .catch(error => commit('AUTHENTICATING_ERROR', error.response));
        },
        logout ({ commit }) {
            commit('LOGGING_OUT');

            return api.logout()
                .then(() => commit('LOGGING_OUT_SUCCESS'));
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
        }
    }
});
