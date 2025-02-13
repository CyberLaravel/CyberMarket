<script setup>
defineProps({
    product: Object,
});
</script>

<template>
    <div>
        <h1>{{ product.data.name }}</h1>
        <p>{{ product.data.description }}</p>
        <p>Price: ${{ product.data.price }}</p>
        <img :src="product.data.image" alt="Product Image" />
    </div>
</template>
