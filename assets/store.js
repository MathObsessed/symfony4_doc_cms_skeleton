import Vue from 'vue';
import Vuex from 'vuex';

import api from './api';

Vue.use(Vuex);

const defaultErrorMessage = 'Unexpected error';

export default new Vuex.Store({
    state: {
        title: '',
        isLoading: false,
        errorMessage: null,
        errors: [],
        login: null,
        documents: [],
        selectedDocument: localStorage.selectedDocument || null
    },
    getters: {
        title (state) {
            return state.title;
        },
        isLoading (state) {
            return state.isLoading;
        },
        hasError (state) {
            return (state.errorMessage !== null);
        },
        errorMessage (state) {
            return state.errorMessage;
        },
        errors (state) {
            return state.errors;
        },
        isAuthenticated (state) {
            return !!state.login;
        },
        login (state) {
            return state.login;
        },
        documentsList (state) {
            if (state.selectedDocument === null) {
                return state.documents;
            }

            return state.documents.filter(name => name !== state.selectedDocument);
        },
        selectedDocument (state) {
            return state.selectedDocument;
        }
    },
    mutations: {
        ['INITIALIZATION'](state, data) {
            state.title = data.title;
            state.login = data.login;
        },
        ['AUTHENTICATION'](state) {
            state.isLoading = true;
            state.errorMessage = null;
            state.errors = [];
            state.login = null;
        },
        ['AUTHENTICATION_SUCCESS'](state, data) {
            state.isLoading = false;
            state.errorMessage = null;
            state.errors = [];
            state.login = data.login;
        },
        ['AUTHENTICATION_ERROR'](state, error) {
            state.isLoading = false;
            state.errorMessage = error.message || defaultErrorMessage;
            state.errors = error.errors || [];
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
            state.errorMessage = null;
            state.errors = [];
        },
        ['REGISTRATION_SUCCESS'](state) {
            state.isLoading = false;
            state.errorMessage = null;
            state.errors = [];
        },
        ['REGISTRATION_ERROR'](state, error) {
            state.isLoading = false;
            state.errorMessage = error.message || defaultErrorMessage;
            state.errors = error.errors || [];
        },
        ['CLEAR_ERRORS'](state) {
            state.errorMessage = null;
            state.errors = [];
        },
        ['LOAD_DOCUMENTS'](state, data) {
            state.documents = data;
        },
        ['SELECT_DOCUMENT'](state, data) {
            state.selectedDocument = data;
            localStorage.selectedDocument = data;
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
                .catch(error => commit('AUTHENTICATION_ERROR', error.response.data));
        },
        logout ({ commit }) {
            commit('LOGOUT');

            return api.logout()
                .then(() => commit('LOGOUT_COMPLETE'));
        },
        register ({ commit }, payload) {
            commit('REGISTRATION');

            return api.register(payload.login, payload.password)
                .then(() => commit('REGISTRATION_SUCCESS'))
                .catch(error => commit('REGISTRATION_ERROR', error.response.data));
        },
        clearErrors ({ commit }) {
            commit('CLEAR_ERRORS');
        },
        documents ({ commit }) {
            return api.documents()
                .then(response => commit('LOAD_DOCUMENTS', response.data))
                .catch(() => commit('LOAD_DOCUMENTS', []));
        },
        selectDocument ({ commit }, name) {
            commit('SELECT_DOCUMENT', name);
        }
    }
});
