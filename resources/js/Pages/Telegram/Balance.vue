<script setup>
import {Head, Link} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome"/>
    <div class="w-full h-[100vh] flex justify-center items-center flex-col">
        <img class="max-w-[300px] mb-[20px]" src="/storage/system/logo.png" alt="LOGO">
        <h1 class="text-[28px] text-white px-[20px] text-center mb-4">Welcome to Shikisha Kakitu</h1>
        <Link class="btn btn-primary mb-4" :href="route('dashboard')">Account</Link>
        <Link class="btn btn-primary" :href="route('register')">Register</Link>
    </div>


</template>


<style lang="scss">
body {
    @apply bg-gray-900;
}

</style>
