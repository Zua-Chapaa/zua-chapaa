<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";

const props = defineProps(['user'])

const accountForm = useForm({
    user: props.user,
    code: "",
    password: "",
    password_confirmation: ""
})

const errors = ref({});

function setupAccount() {
    errors.value = {}
    axios.post(route('setupAccount'), accountForm)
        .then(res => {
            window.location.reload()
        }).catch(err => {
        console.log(err)
            switch (err.response.status) {
                case 422:
                    errors.value = (err.response.data.errors)
                    break;
                case 400:
                case 404:
                    errors.value.push = [err.response.data.error]
                    break;
                default:
                    break
            }
        })
}
</script>

<template>
    <Head title="Welcome"/>
    <nav
        class="text-white bg-gray-800 py-[10px] px-[10px] mb-[10px] flex items-center justify-content-between shadow-lg">
        <img style="height: 45px" src="/storage/system/logo.png" alt="Logo">
    </nav>
    <h1 class="px-[10px] text-[30px] text-white mb-[10px]">Account Setup:</h1>
    <p class="px-[10px] mb-[10px] text-white">Please Enter the code sent to your private chat</p>
    <form @submit.prevent=setupAccount class="mx-[10px]">
        <ul class="pb-[20px]">
            <li v-for="item in errors" class="px-[20px] text-sm alert-danger rounded-sm mb-[2px]">{{ item[0] }}</li>
        </ul>
        <ul>
            <li style="background-color: rgba(125,178,243,0.27)" class="p-[10px] rounded mb-[5px]">
                <label class="block text-sm text-white mb-[5px]">Code</label>
                <TextInput type="text" class="w-full p-[5px]" v-model="accountForm.code"></TextInput>
            </li>
            <li style="background-color: rgba(125,178,243,0.27)" class="p-[10px] rounded mb-[5px] ">
                <label class="block text-sm text-white mb-[5px]">New Password</label>
                <TextInput type="password" class="w-full p-[5px]" v-model="accountForm.password"></TextInput>
            </li>
            <li style="background-color: rgba(125,178,243,0.27)" class="p-[10px] rounded mb-[5px] ">
                <label class="block text-sm text-white mb-[5px]">Confirm Password</label>
                <TextInput type="password" class="w-full p-[5px]"
                           v-model="accountForm.password_confirmation"></TextInput>
            </li>
        </ul>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary btn w-full">Update</button>
        </div>
    </form>
</template>


<style lang="scss">
body {
    @apply bg-gray-600
}
</style>
