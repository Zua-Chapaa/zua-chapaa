<script>

import {defineComponent} from "vue";
import TextInput from "@/Components/TextInput.vue";
import {Head, Link} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import {route} from "../../../../vendor/tightenco/ziggy/src/js/index.js";

export default defineComponent({
    methods: {route},
    components: {
        AuthenticationCardLogo,
        Head,
        Checkbox,
        InputError,
        AuthenticationCard,
        PrimaryButton,
        InputLabel,
        Link,
        TextInput
    }
})
</script>
<template>
    <Head title="Log in"/>
    <AuthenticationCard class="bg-gray-900 px-2 rounded overflow-auto">
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div>
            <a class="text-blue-800 text-decoration-underline" href="https://t.me/ZuaChapaaBot">Register via
                Telegram</a>
        </div>
    </AuthenticationCard>
</template>

<style lang="scss">
body {
    @apply bg-gray-900;
}
</style>
