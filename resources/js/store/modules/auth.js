import axios from 'axios';

const state = {
    token: localStorage.getItem('token') || null,
    user: JSON.parse(localStorage.getItem('user')) || null,
};

const getters = {
    isAuthenticated: (state) => !!state.token,
    user: (state) => state.user,
};

const actions = {
    async login({ commit }, credentials) {
        try {
            const response = await axios.post('/api/login', credentials);
            const { access_token, user } = response.data;

            localStorage.setItem('token', access_token);
            localStorage.setItem('user', JSON.stringify(user));

            axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
            commit('setAuth', { token: access_token, user });
        } catch (error) {
            throw error.response?.data || error;
        }
    },
    logout({ commit }) {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        delete axios.defaults.headers.common['Authorization'];
        commit('clearAuth');
    },
};

const mutations = {
    setAuth(state, { token, user }) {
        state.token = token;
        state.user = user;
    },
    clearAuth(state) {
        state.token = null;
        state.user = null;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
