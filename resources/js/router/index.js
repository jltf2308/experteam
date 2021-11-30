import {createWebHistory, createRouter} from "vue-router";

import Dashboard from '../pages/Dashboard';
import Guides from '../components/Guides';
import Invoices from '../components/Invoices';

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
