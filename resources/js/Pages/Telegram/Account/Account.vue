<script setup>
import {Head} from '@inertiajs/vue3';

console.log("hi")

///test
</script>

<template>
    <Head title="Welcome"/>
    <nav
        class="text-white bg-gray-800 py-[10px] px-[10px] mb-[10px] flex items-center justify-content-between shadow-lg">
        <img style="height: 45px" src="/storage/system/logo.png" alt="Logo">
    </nav>
    <h1 class="px-[10px] text-[30px] text-white mb-[10px]">Account:</h1>
</template>


<style lang="scss">
body {
    @apply bg-gray-600
}
</style>
