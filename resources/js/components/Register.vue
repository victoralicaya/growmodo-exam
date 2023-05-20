<template>
    <div class="head-container">
        <div class="alert alert-success" v-if="successMessage">
            {{ successMessage }}
        </div>
        <div class="register-container">
            <div class="card">
                <div class="card-header text-center">
                    <h3>REGISTER</h3>
                </div>
                <div class="card-body">
                    <form @submit.prevent="register">
                        <div class="mt-3 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" v-model="form.username" class="form-control" placeholder="Username">
                            <span class="error-message">{{ errorMessage.username }}</span>
                        </div>

                        <div class="mt-3 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" v-model="form.email" class="form-control" placeholder="Email">
                            <span class="error-message">{{ errorMessage.email }}</span>
                        </div>

                        <div class="mt-3 mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" v-model="form.phone_number" class="form-control" placeholder="Phone Number">
                            <span class="error-message">{{ errorMessage.phone_number }}</span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                            <span class="error-message">{{ errorMessage.password }}</span>
                        </div>

                         <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" v-model="form.password_confirmation" class="form-control" placeholder="Confirm Password">
                            <span class="error-message">{{ errorMessage.password }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <router-link to="/">Login</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref, watch } from 'vue';
import axios from 'axios';
export default {
    setup() {
        const form = reactive({
            username: '',
            email: '',
            phone_number: '',
            password: '',
            password_confirmation: '',
        });
        const successMessage = ref('');
        const errorMessage = ref({
            username: '',
            email: '',
            password: '',
        });

        const register = async () => {
            try {
                const response = await axios.post('/api/v1/register', {
                    username: form.username,
                    email: form.email,
                    phone_number: form.phone_number,
                    password: form.password,
                    password_confirmation: form.password_confirmation
                })
                successMessage.value = response.data.message;
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;

                    errorMessage.value.username = errors.username ? errors.username[0] : '';
                    errorMessage.value.email = errors.email ? errors.email[0] : '';
                    errorMessage.value.phone_number = errors.phone_number ? errors.phone_number[0] : '';
                    errorMessage.value.password = errors.password ? errors.password[0] : '';
                } else {
                    console.log(error)
                }
            }
        }

        const clearErrorMessage = (field) =>  {
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
            successMessage,
            errorMessage,
            register
        }
    }
}
</script>

<style>
.head-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.register-container {
    width: 30%;
}

.error-message {
    color: red;
}

.alert {
    width: 30%;
}
</style>
