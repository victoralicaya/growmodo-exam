import { createRouter, createWebHistory } from "vue-router";

import Homepage from './components/Homepage.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import WelcomePage from './components/WelcomePage.vue';
import UserList from './components/UserList.vue';

const routes = [
    {
        path: '/',
        name: 'Homepage',
        component: Homepage
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/welcome',
        name: 'Welcome',
        component: WelcomePage,
        props: true,
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/user-list',
        name: 'UserList',
        component: UserList,
        meta: {
            requiresAuth: true,
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token');
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!isAuthenticated) {
            next({ name: 'Login' });
        } else {
            next();
        }
    } else if (to.name === 'Login' && isAuthenticated) {
        next({ name: 'Welcome' })
    } else {
        next();
    }
});

export default router;
