<script setup>
import { useForm } from "@inertiajs/vue3";
import CorporateMinimalistRegister from "@/Components/Auth/Register/CorporateMinimalistRegister.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const handleRegister = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <CorporateMinimalistRegister
        v-model:name="form.name"
        v-model:email="form.email"
        v-model:password="form.password"
        v-model:password_confirmation="form.password_confirmation"
        v-model:terms="form.terms"
        :errors="form.errors"
        @submit="handleRegister"
    />
</template>
