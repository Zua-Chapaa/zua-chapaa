<script setup>
import {useForm} from "@inertiajs/vue3";
import DashboardMenu from "@/Components/Appilcation/DashboardMenu.vue";

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const logUser = useForm({
    _token: csrfToken,
})

const props = defineProps(['questions'])

const currentUrl = window.location.href;

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
                    <th scope="col">Question</th>
                    <th scope="col">Choices</th>
                    <th scope="col">Answer</th>
                    <th scope="col">Curated</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody class="text-white">
                <tr v-for="question in questions">
                    <td>{{ question }}</td>
                    <td>{{ question.question }}</td>
                    <td>
                        <ul>
                            <li>{{ question.Choice_1 }}</li>
                            <li>{{ question.Choice_2 }}</li>
                            <li>{{ question.Choice_3 }}</li>
                            <li>{{ question.Choice_4 }}</li>
                        </ul>
                    </td>
                    <td>{{ question.ans }}</td>
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
