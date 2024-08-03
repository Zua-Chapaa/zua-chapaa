<script setup>
import {Head} from '@inertiajs/vue3';


const props = defineProps(['user'])

</script>

<template>
    <Head title="Welcome"/>
    <nav
        class="text-white bg-gray-800 py-[10px] px-[10px] mb-[10px] flex items-center justify-content-between shadow-lg">
        <img style="height: 35px" src="/storage/system/logo.png" alt="Logo">
    </nav>
    <h1 class="my-[10px] text-[25px] text-white px-[10px]">Account Details</h1>
    <ul class="px-[20px] text-white details mb-[30px]">
        <li class="flex justify-between px-[10px]"><label class="mr-[20px]">Username :</label>
            <p>{{ user.name ?? "N/A" }}</p></li>
        <li class="flex justify-between px-[10px]"><label class="mr-[20px]">Plan :</label>
            <p>{{ user.active_subscription ?? "N/A" }}</p></li>
        <li class="flex justify-between px-[10px]"><label class="mr-[20px]">Balance :</label>
            <p>{{
                    user.balance ? new Intl.NumberFormat('en-KE', {
                        style: 'currency',
                        currency: 'KES'
                    }).format(user.balance) : 0
                }}</p></li>
    </ul>
    <h1 class="my-[10px] text-[25px] text-white px-[10px]">Session Scores</h1>
    <ul class="px-[20px] text-white details mb-[30px] text-sm">
        <li v-for="item in 5" class="flex flex-col px-[10px] mb-[10px]">
            <div class="mb-[10px]">
                <p>Session ID: 8493759834579384</p>
            </div>
            <hr class="mb-[10px]">
            <div class="flex justify-between flex-col w-full">
                <section class="flex justify-between py-[5px]"><label class="mr-[20px]">Questions Answered :</label>
                    <p>30</p></section>
                <section class="flex justify-between py-[5px]"><label class="mr-[20px]">Correct Answers :</label>
                    <p>20</p></section>
                <section class="flex justify-between py-[5px]"><label class="mr-[20px]">Average Time :</label>
                    <p>3s</p></section>
                <section class="flex justify-between py-[5px]"><label class="mr-[20px]">Position :</label>
                    <p>20</p></section>
            </div>
        </li>
    </ul>

</template>


<style lang="scss">
body {
    @apply bg-gray-600
}
</style>

<style lang="scss" scoped>
.details {
    & > li {
        @apply py-[10px] bg-gray-500 rounded mb-[10px];
    }
}
</style>
