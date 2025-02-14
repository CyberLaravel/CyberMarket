<script setup>
import { useForm } from "@inertiajs/vue3";
import DefaultLogin from "@/Components/Auth/Login/DefaultLogin.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    rememberMe: false,
});

const handleLogin = () => {
    console.log("Login fired");
    form.transform((data) => ({
        ...data,
        rememberMe: form.rememberMe ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <DefaultLogin
        :can-reset-password="canResetPassword"
        :status="status"
        v-model:email="form.email"
        v-model:password="form.password"
        v-model:rememberMe="form.rememberMe"
        :errors="form.errors"
        @submit="handleLogin"
    />
</template>
