<script setup>
import {Head, useForm} from '@inertiajs/vue3';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const userFrom = useForm({
    _token: csrfToken,
    username: "mwaura",
    email: "kimmwaus@gmail.com",
    phone: "0719445697",
    password: "password",
    password_confirmation: "password",
})
</script>

<template>
    <Head title="Welcome"/>
    <div class="w-full h-[100vh] flex justify-center items-center">
        <div class="w-[600px] bg-white rounded">
            <h1 class="p-[20px] text-[30px]">User Registration</h1>
            <form class="px-[30px]" @submit.prevent="userFrom.post(route('adminRegistrationPost'))">
                <input type="text" class="form-control rounded block" placeholder="Username" aria-label="Username"
                       aria-describedby="basic-addon1" v-model="userFrom.username" required>
                <span class="text-red-500 px-[10px] pb-[10px]">{{ userFrom.errors.username }}</span>

                <input type="email" class="form-control rounded block" placeholder="Email" aria-label="Email"
                       aria-describedby="basic-addon1" v-model="userFrom.email" required>
                <span class="text-red-500 px-[10px] pb-[10px]">{{ userFrom.errors.email }}</span>

                <input type="tel" class="form-control rounded block" placeholder="Phone" aria-label="Email"
                       aria-describedby="basic-addon1" v-model="userFrom.phone" required>
                <span class="text-red-500 px-[10px] pb-[10px]">{{ userFrom.errors.phone }}</span>

                <input type="password" class="form-control rounded block" placeholder="Password" aria-label="Email"
                       aria-describedby="basic-addon1" v-model="userFrom.password" required>
                <span class="text-red-500 px-[10px] pb-[10px]">{{ userFrom.errors.password }}</span>

                <input type="password" class="form-control rounded block" placeholder="Confirm Password"
                       aria-label="Email" aria-describedby="basic-addon1" required
                       v-model="userFrom.password_confirmation ">
                <span class="text-red-500 px-[10px] pb-[10px]">{{ userFrom.errors.password_confirmation }}</span>

                <div class="py-[20px]">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</template>


<style lang="scss">
body {
    @apply bg-gray-600


}
</style>


<style lang="scss" scoped>
input {
    @apply mb-2;
}
</style>
