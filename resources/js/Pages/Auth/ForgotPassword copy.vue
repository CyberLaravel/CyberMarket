<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import CyberAuthCard from "@/Components/CyberAuthCard.vue";
import CyberAuthLogo from "@/Components/CyberAuthLogo.vue";
import CyberButton from "@/Components/CyberButton.vue";
import CyberInput from "@/Components/CyberInput.vue";
import CyberInputError from "@/Components/CyberInputError.vue";
import CyberInputLabel from "@/Components/CyberInputLabel.vue";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <Head title="Forgot Password" />

    <CyberAuthCard>
        <template #logo>
            <CyberAuthLogo />
        </template>

        <div class="mb-4 text-sm text-blue-300">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-yellow-400">
            {{ status }}
        </div>

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

            <div class="flex items-center justify-end mt-4">
                <CyberButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </CyberButton>
            </div>
        </form>
    </CyberAuthCard>
</template>
