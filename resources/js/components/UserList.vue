<template>
    <div class="container">
        <router-link to="/welcome" class="btn btn-outline-primary mt-5">Go Back</router-link>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mt-2">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.phone_number }}</td>
                        <td>{{ user.role }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <div class="btn-group">
                <button type="button" @click="previousPage" :disabled="page === 1" class="btn btn-outline-primary">Prev</button>
                <button type="button" v-for="pageNumber in totalPages" :key="pageNumber" @click="goToPage(pageNumber)" :class="pageNumber === page ? 'btn btn-outline-primary active' : 'btn btn-outline-primary' ">
                    {{ pageNumber }}
                </button>
                <button type="button" @click="nextPage" :disabled="page === totalPages" class="btn btn-outline-primary">Next</button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import router from '../router';
export default {
    setup() {
        const token = localStorage.getItem('token');
        const users = ref([]);
        const page = ref(1);
        const totalPages = ref(0);

        const userList = async (pageNumber) => {
            try {
                const response = await axios.get(`/api/v1/users?page=${pageNumber}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                console.log(response.data.data);
                users.value = response.data.data;
                totalPages.value = response.data.data.last_page;
            } catch (error) {
                if (error.response && error.response.status === 401) {
                    router.push({ name: 'Welcome' });
                }
                console.log(error);
            }
        }

        const previousPage = () => {
            if (page.value > 1) {
                page.value--;
                userList(page.value);
            }
        };

        const nextPage = () => {
            if (page.value < totalPages.value) {
                page.value++;
                userList(page.value);
            }
        };

        const goToPage = (pageNumber) => {
            if (pageNumber >= 1 && pageNumber <= totalPages.value) {
                page.value = pageNumber;
                userList(pageNumber);
            }
        };

        onMounted(userList(page.value));

        return {
            users,
            page,
            totalPages,
            userList,
            previousPage,
            nextPage,
            goToPage
        }
    }
}
</script>
