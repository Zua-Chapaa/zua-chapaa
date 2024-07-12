<script setup>
import {useForm} from "@inertiajs/vue3";
import {onMounted} from "vue";
import DashboardMenu from "@/Components/Appilcation/DashboardMenu.vue";

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const logUser = useForm({
    _token: csrfToken,
})

const currentUrl = window.location.href;

onMounted(() => {
})

</script>

<template>
    <DashboardMenu>
        <div class="flex mb-[20px] justify-between items-center text-white p-[10px]">
            <h2>Welcome, Username</h2>
            <div>
                <button @click.prevent.stop="logUser.post('logout')" class="btn btn-danger">Log Out</button>
            </div>
        </div>
        <div class="flex items-center text-white mb-[20px]">
            <div class="mx-[10px]">
                <label class="m-[10px]">From</label>
                <input class=" rounded text-gray-600" type="datetime-local">
            </div>
            <div>
                <label class="m-[10px]">To</label>
                <input class=" rounded text-gray-600" type="datetime-local">
            </div>
            <div class="px-[20px]">
                <button class="btn btn-primary">Apply Filter</button>
            </div>
        </div>

        <section class="flex mx-[10px] gap-3">
            <div class="bg-white w-[70%] h-[500px] rounded"></div>
            <div class="bg-white w-[30%] h-[200px] rounded"></div>
        </section>
    </DashboardMenu>
</template>

<style lang="scss">
body {
    background-color: #083E68;
}

ul {
    padding: 20px;

    li {
        color: white;
        @apply px-[15px] py-[10px] rounded mb-[10px];
        cursor: pointer;

        &:hover {
            background-color: #4c5ccd;
        }
    }

    .active_dashboard {
        background-color: #434FAC;
    }
}
</style>
