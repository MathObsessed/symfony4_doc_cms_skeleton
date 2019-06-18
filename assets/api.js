import axios from 'axios/index';

const prefix = '/api';

export default {
    login (login, password) {
        return axios.post(prefix + '/login', { login, password });
    },
    logout () {
        return axios.get(prefix + '/logout');
    },
    register (login, password) {
        return axios.post(prefix + '/register', { login, password });
    },
    documents () {
        return axios.get(prefix + '/documents');
    }
}
