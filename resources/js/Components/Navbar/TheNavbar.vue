<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import AuthNav from "./AuthNav.vue";
import GuestNav from "./GuestNav.vue";

const page = usePage();
const isAuthenticated = computed(() => page.props.auth.user !== null);
</script>

<template>
    <AuthNav v-if="isAuthenticated" />
    <GuestNav v-else />
</template>
