<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import CyberAuthCard from "@/Components/CyberAuthCard.vue";
import CyberAuthLogo from "@/Components/CyberAuthLogo.vue";
import CyberButton from "@/Components/CyberButton.vue";
import CyberInput from "@/Components/CyberInput.vue";
import CyberInputError from "@/Components/CyberInputError.vue";
import CyberInputLabel from "@/Components/CyberInputLabel.vue";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <CyberAuthCard>
        <template #logo>
            <CyberAuthLogo />
        </template>

        <form @submit.prevent="submit">
            <div>
                <CyberInputLabel for="email" value="Email" />
                <CyberInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <CyberInputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <CyberInputLabel for="password" value="Password" />
                <CyberInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <CyberInputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <CyberInputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />
                <CyberInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <CyberInputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <CyberButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </CyberButton>
            </div>
        </form>
    </CyberAuthCard>
</template>
