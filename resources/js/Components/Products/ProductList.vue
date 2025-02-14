<script setup>
import ProductBox from "./ProductBox.vue";

const props = defineProps(["products"]);
</script>

<template>
    <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
    >
        <ProductBox
            :product="product"
            v-for="product in products"
            :key="product.id"
        />
    </div>
</template>
