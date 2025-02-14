<!-- ProductList.vue -->
<script setup>
import ProductBox from "./ProductBox.vue";
import { Alert, AlertDescription } from "@/Components/ui/alert";

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div
        v-if="products.length"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
    >
        <ProductBox
            v-for="product in products"
            :key="product.id"
            :product="product"
        />
    </div>
    <Alert v-else class="my-8">
        <AlertDescription>
            No products found. Start by adding your first product.
        </AlertDescription>
    </Alert>
</template>
