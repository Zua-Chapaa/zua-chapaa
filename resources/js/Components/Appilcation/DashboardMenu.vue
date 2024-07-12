<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import {onMounted} from "vue";

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const logUser = useForm({
    _token: csrfToken,
})

const currentUrl = window.location.href;

onMounted(() => {
})

</script>

<template>
    <div class="w-full flex h-[100vh]">
        <div class="w-[250px] h-[100%]" style="background-color: #2E3463">
            <div class="flex p-[20px]">
                <img class="p-[10px]" src="/storage/system/logo.png">
            </div>
            <ul>
                <Link :href="route('dashboard')" as="li"
                      :class="[currentUrl.includes('dashboard')?'active_dashboard':'']">Dashboard
                </Link>
                <Link :href="route('users.index')" as="li"
                      :class="[currentUrl.includes('users')?'active_dashboard':'']">Users
                </Link>
                <Link :href="route('transactions.index')" as="li"
                      :class="[currentUrl.includes('transactions')?'active_dashboard':'']">Transactions
                </Link>
                <Link :href="route('questions.index')" as="li"
                      :class="[currentUrl.includes('questions')?'active_dashboard':'']">Question
                </Link>
            </ul>
        </div>
        <div style="width: calc(100% - 250px)" class="h-[100%]">
            <div class="flex mb-[20px] justify-between items-center text-white p-[10px]">
                <h2>Welcome, Username</h2>
                <div>
                    <button @click.prevent.stop="logUser.post('logout')" class="btn btn-danger">Log Out</button>
                </div>
            </div>
            <slot></slot>
        </div>
    </div>
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
