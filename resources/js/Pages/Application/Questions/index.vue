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
        <h1>Questions</h1>
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
