<script setup>
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome"/>
    <nav
        class="text-white bg-gray-800 py-[10px] px-[10px] mb-[10px] flex items-center justify-content-between shadow-lg">
        <img style="height: 45px" src="/storage/system/logo.png" alt="Logo">
    </nav>
    <h1 class="px-[10px] text-[30px] text-white mb-[10px]">Balance:</h1>
    <div class="text-white rounded-lg p-[5px] mx-[10px] mb-[5px]" style="background-color: rgba(125,178,243,0.27)">
        <h2 class="text-white text-[20px] mb-[20px]">Total Balance:</h2>
        <p class="text-white text-right text-[30px] font-bold ">Ksh 4,000</p>
    </div>
    <div class="text-white rounded-lg  mx-[10px] mb-[30px]">
        <button type="button" class="block w-full rounded bg-blue-400 py-[6px]">Withdraw</button>
    </div>
    <div class="mx-[5px] p-[10px] rounded-lg">
        <h2 class="text-white text-[20px] mb-[20px]">Transactions:</h2>
        <ul>
            <li v-for="x in 5" class="transaction p-[10px] rounded text-xs text-gray-50 gap-2 pb-[5px] mb-[5px]"
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
</style>
