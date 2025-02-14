<script setup>
import { Head } from "@inertiajs/vue3";
defineProps({ order: Object });
</script>

<template>
    <Head :title="`Order #${order.id}`" />
    <div class="p-4 bg-white shadow rounded">
        <h1 class="text-3xl font-bold mb-2">Order #{{ order.id }}</h1>
        <p class="text-lg">
            Amount: <span class="font-semibold">${{ order.amount }}</span>
        </p>
        <p class="text-lg">
            Status: <span class="font-semibold">{{ order.status }}</span>
        </p>
    </div>
</template>
