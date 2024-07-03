<script setup>
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome"/>
    <nav class="text-white flex items-center justify-content-between shadow-lg">
        <div class="">
            <img style="height: 30px" class="h-[60px]" src="/storage/system/logo.png" alt="Logo">
        </div>
        <!--        <button type="button">-->
        <!--            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"-->
        <!--                 class="bi bi-three-dots-vertical" viewBox="0 0 16 16">-->
        <!--                <path-->
        <!--                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>-->
        <!--            </svg>-->
        <!--        </button>-->
    </nav>
    <h1 class="px-[5px] text-[20px] text-white mb-[10px]">Account:</h1>
    <div class="text-white rounded-lg p-[5px] mx-[10px] mb-[30px]" style="background-color: rgba(125,178,243,0.27)">
        <h2 class="text-white text-[20px] mb-[20px]">Total Balance:</h2>
        <p class="text-white text-right text-[30px] font-bold">Ksh 4,000</p>
    </div>

    <div class="mx-[5px] p-[10px] rounded-lg">
        <h2 class="text-white text-[20px] mb-[20px]">Transactions:</h2>
        <ul>
            <li v-for="x in 5" class="transaction p-[5px] rounded text-xs text-gray-50 gap-2 pb-[5px] mb-[5px]"
                style="background-color: rgba(125,178,243,0.27)">
                <p class="mb-[5px]">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore eum ex iste maxime nesciunt omnis,
                    porro qui! Alias aut excepturi fuga, fugiat ipsa magnam molestiae odit porro quis quos
                    voluptates?
                </p>
                <span class="block text-right">10:30 PM</span>
            </li>
        </ul>
    </div>

</template>


<style lang="scss">
body {
    @apply bg-gray-600
}

nav {
    @apply bg-gray-900 h-12 px-2 mb-4
}

div {
    li {
    }
}
</style>
