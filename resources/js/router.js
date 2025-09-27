import { createRouter, createWebHistory } from 'vue-router';

import Login from './views/Login.vue';
import ListStock from './views/ListStock.vue';
import BulkStock from './views/BulkStock.vue';

const routes = [
    { path: '/', redirect: '/login' },
    { path: '/login', name: 'login', component: Login },
    { path: '/list', name: 'list', component: ListStock, meta: { requiresAuth: true } },
    { path: '/bulk', name: 'bulk', component: BulkStock, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;