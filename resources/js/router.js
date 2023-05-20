import { createRouter, createWebHistory } from "vue-router";

import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Admin from './components/Admin.vue';
import User from './components/User.vue';

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/admin',
        name: 'Admin',
        component: Admin,
        meta: {
            requiresAuth: true,
            requiresAdmin: true,
        }
    },
    {
        path: '/user',
        name: 'User',
        component: User,
        meta: {
            requiresAuth: true,
            requiresUser: true,
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token');
    const isRole = localStorage.getItem('role');
    if (to.name === 'Login' && isAuthenticated) {
        if (isRole === 'admin') {
            next({ name: 'Admin' });
        } else if (isRole === 'user') {
            next({ name: 'User' });
        }
    } else if (to.matched.some(record => record.meta.requiresAuth) && to.matched.some(record => record.meta.requiresAdmin)) {
        if (!isAuthenticated) {
            next({ name: 'Login' });
        } else if (isAuthenticated && isRole !== 'admin') {
            next({ name: 'User' });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.requiresAuth) && to.matched.some(record => record.meta.requiresUser)) {
        if (!isAuthenticated) {
            next({ name: 'Login' });
        } else if (isAuthenticated && isRole !== 'user') {
            next({ name: 'Admin' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
