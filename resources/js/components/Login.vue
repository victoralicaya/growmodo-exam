<template>
    <div class="head-container">
        <div class="alert alert-danger" v-if="invalidCred">
            {{ invalidCred }}
        </div>
        <div class="form-container">
            <a href="/" class="btn btn-secondary mb-2">Go Back</a>
            <div class="card">
                <div class="card-header text-center">
                    <h3>LOGIN</h3>
                </div>
                <div class="card-body">
                    <form @submit.prevent="userLogin">
                        <div class="mt-3 mb-3">
                            <label for="username" class="form-label">Email/Username</label>
                            <input type="text" v-model="form.login" class="form-control" placeholder="Email/Username">
                            <span class="error-message">{{ errorMessage.login }}</span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                            <span class="error-message">{{ errorMessage.password }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <router-link to="/register">Register</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, reactive, watch } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
export default {
    setup() {
        const router = useRouter();
        const form = reactive({
            login: '',
            password: '',
        });
        const errorMessage = ref({
            login: '',
            password: '',
        });
        const invalidCred = ref('');

        const userLogin = async () => {
            try {
                const response = await axios.post('/api/v1/login', {
                    login: form.login,
                    password: form.password
                })
                const data = response.data;

                localStorage.setItem('token', data.token);
                localStorage.setItem('user', JSON.stringify(data.data));

                router.push({ name: 'Welcome' });

            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;

                    invalidCred.value = '';
                    errorMessage.value.login = errors.login ? errors.login[0] : '';
                    errorMessage.value.password = errors.password ? errors.password[0] : '';1
                } else {
                    invalidCred.value = error.response.data.message;
                    console.log(error);
                }
            }
        }

        const clearErrorMessage = (field) => {
            errorMessage.value[field] = '';
        }

        const watchForm = () => {
            for (const field in form) {
                watch(() => form[field], () => clearErrorMessage(field));
            }
        };

        watchForm();

        return {
            form,
            errorMessage,
            invalidCred,
            userLogin
        }
    }
}
</script>
