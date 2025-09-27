import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';

import router from './router';
import store from './store';

import axios from 'axios';
const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

const app = createApp(App);

app.use(store);
app.use(router);

// Navigation guard
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.getters['auth/isAuthenticated']) {
        next('/login');
    } else {
        next();
    }
});

app.mount('#app');
