<script setup>
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome"/>
    <nav
        class="text-white bg-gray-800 py-[10px] px-[10px] mb-[10px] flex items-center justify-content-between shadow-lg">
        <img style="height: 45px" src="/storage/system/logo.png" alt="Logo">
        <!--        <button type="button">-->
        <!--            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"-->
        <!--                 class="bi bi-three-dots-vertical" viewBox="0 0 16 16">-->
        <!--                <path-->
        <!--                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>-->
        <!--            </svg>-->
        <!--        </button>-->
    </nav>
    <h1 class="px-[10px] text-[30px] text-white mb-[10px]">Account:</h1>
</template>


<style lang="scss">
body {
    @apply bg-gray-600
}
</style>
