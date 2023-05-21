<template>
    <div class="container">
        <div class="alert alert-danger mt-4 unsubscribe-alert" v-if="unsubcribeMessage">
            {{ unsubcribeMessage }}
            <div v-if="isConfirmed" class="mt-2 d-grid">
                <button class="btn btn-danger btn-block" @click="unsubcribe">Yes</button>
            </div>
        </div>
        <div class="mt-4 p-5 bg-primary text-white rounded">
            <h1>Welcome <b>{{ userName }}</b></h1>
            <span v-if="user.role === 'admin'">
                <router-link to="/user-list" class="btn btn-info text-white mx-1">View Users</router-link>
            </span>
            <span v-else>
                <button class="btn btn-secondary mx-1" @click="unsubscribeConfirm">Unsubscribe</button>
            </span>
            <button class="btn btn-danger" @click="logout">Logout</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
export default {
    setup() {
        const user = JSON.parse(localStorage.getItem('user'));
        const token = localStorage.getItem('token');
        const router = useRouter();
        const unsubcribeMessage = ref('');
        const isConfirmed = ref(false);

        const userName = user.username.charAt(0).toUpperCase() + user.username.slice(1);

        const unsubscribeConfirm = () => {
            isConfirmed.value = true;
            unsubcribeMessage.value = 'Are you sure you want to subscribe? Your data will be deleted. Deleted data will not be recovered.';
        }

        const unsubcribe = async () => {
            try {
                await axios.post('/api/v1/unsubsribe', null,{
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                isConfirmed.value = false;
                unsubcribeMessage.value = 'You have unsubscribed. You will be logged out in a moment.';
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            } catch (error) {
                console.log(error);
            }
        }

        const logout = async () => {
            try {
                await axios.post('/api/v1/logout', null, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                router.push('/login');
            } catch (error) {
                console.log(error);
            }
        }

        return {
            user,
            userName,
            router,
            unsubcribeMessage,
            isConfirmed,
            unsubcribe,
            unsubscribeConfirm,
            logout
        }
    }
}
</script>

<style>
.unsubscribe-alert {
    width: 100% !important;
}
</style>
