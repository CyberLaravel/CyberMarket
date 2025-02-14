<script setup>
defineProps({
    product: Object,
});
</script>

<template>
    <div
        class="bg-gray-800 text-gray-200 p-8 rounded-lg shadow-lg transition-transform transform hover:scale-105"
    >
        <h1 class="text-5xl font-extrabold text-yellow-500 mb-6 glitch">
            {{ product.data.name }}
        </h1>
        <p class="text-lg mb-4">{{ product.data.description }}</p>
        <p class="text-xl font-semibold">
            Price:
            <span class="text-yellow-500">${{ product.data.price }}</span>
        </p>
        <img
            :src="product.data.image"
            alt="Product Image"
            class="border-2 border-yellow-500 rounded-lg mt-4"
        />
    </div>
</template>
