<script setup>
import {Head} from '@inertiajs/vue3';

const props = defineProps(['top'])

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
    <h1 class="px-[10px] text-[30px] text-white mb-[10px]">Leaders Board:</h1>
    <ul class="flex px-[10px] mb-[20px]">
        <li class="active">Hourly</li>
    </ul>
    <div class="flex items-center justify-center text-white">
        <div>
            <div class="w-[100px] h-[100px] rounded overflow-auto" style="background-color: #6799c8">
                <img src="/storage/system/icons8-user-50.png">
            </div>
            <p class="text-center my-[5px]">{{ top[0].name }}</p>
            <p class="text-center my-[5px]">Ksh 500</p>
        </div>
    </div>
    <ul>
        <li v-for="(item, index)  in top" class="mx-[10px] flex mb-[20px]">
            <div class="w-[40px] h-[40px] overflow-auto icon_number mr-[20px]">
                {{ index + 1 }}
            </div>
            <div class="flex w-[100%] items-center">
                <div class="w-[45px] h-[45px] p-[5px] rounded-[50%] bg-blue-300">
                    <img src="/storage/system/icons8-user-50.png">
                </div>
                <div class="score-holder flex justify-between rounded px-[30px] bg-blue-400">
                    <p class="text-white">{{ item.name }}</p>
                    <p class="text-white">{{ item.total }}</p>
                </div>
            </div>
        </li>
    </ul>
</template>


<style lang="scss">
body {
    @apply bg-gray-600;

    li {
        @apply mx-[8px] px-[3px] py-[5px] rounded text-white;
    }

    .active {
        background-color: dodgerblue;
        color: whitesmoke;
    }
}

.icon_number {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid whitesmoke;
    border-radius: 0 8px;
    background-color: transparent;
}

.score-holder {
    position: relative;
    left: -20px;
    z-index: -10;
    width: calc(100% - 40px);
    height: 30px;
}
</style>
