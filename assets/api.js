import axios from 'axios/index';

export default {
    login (login, password) {
        return axios.post('/api/login', { login, password });
    },
    logout () {
        return axios.get('/api/logout');
    }
}
