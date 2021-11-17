import {createWebHistory, createRouter} from "vue-router";

import Dashboard from '../pages/Dashboard.vue';
import Guides from '../pages/Guides.vue';
import Invoices from '../pages/Invoices.vue';

export const routes = [
    {
        name: 'dashboard',
        path: '/',
        component: Dashboard
    },
    {
        name: 'guides',
        path: '/guides',
        component: Guides
    },
    {
        name: 'invoices',
        path: '/invoices',
        component: Invoices
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
