<script setup>
import { Head } from "@inertiajs/vue3";
defineProps({ order: Object });
</script>

<template>
    <Head :title="`Order #${order.id}`" />
    <div>
        <h1 class="text-2xl font-bold">Order #{{ order.id }}</h1>
        <p>Amount: ${{ order.amount }}</p>
        <p>Status: {{ order.status }}</p>
    </div>
</template>
