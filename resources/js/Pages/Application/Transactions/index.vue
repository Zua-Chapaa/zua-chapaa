<script setup>
import {useForm} from "@inertiajs/vue3";
import {onMounted} from "vue";
import DashboardMenu from "@/Components/Appilcation/DashboardMenu.vue";

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const logUser = useForm({
    _token: csrfToken,
})

const props = defineProps(['users'])

const currentUrl = window.location.href;

onMounted(() => {
})

</script>

<template>
    <DashboardMenu>
        <div class="flex justify-between mx-[10px] mb-[20px]">
            <h1 class="text-[30px] mx-[10px] text-white">Users</h1>
            <div class="flex ">
                <input type="text" placeholder="Search..." class="text-[20px] rounded">
            </div>
        </div>
        <div class="mx-[10px] p-[20px] shadow-md bg-[#144D87] rounded !text-white">
            <table class="table">
                <thead>
                <tr class="text-white">
                    <th scope="col">id</th>
                    <th scope="col">Username</th>
                    <th scope="col">Mode</th>
                    <th scope="col">Subscription</th>
                    <th scope="col">Balance (Ksh)</th>
                </tr>
                </thead>
                <tbody class="text-white">
                <tr v-for="user in users">
                    <th scope="row">{{ user.id }}</th>
                    <td>{{ user.username ?? 'N/A' }}</td>
                    <td>{{ user.mode }}</td>
                    <td>{{ user.subscription }}</td>
                    <td>{{ user.Balance }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </DashboardMenu>
</template>

<style lang="scss">
tbody {
    tr {
        cursor: pointer;

        &:hover {
            background-color: dodgerblue;
        }
    }
}
</style>
