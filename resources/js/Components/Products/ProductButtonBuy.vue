<script setup>
import { Button } from "@/components/ui/button";
import { useForm } from "@inertiajs/vue3";

defineProps(["product"]);

const form = useForm({
    product_id: null,
    quantity: 1,
});

const buyProduct = (productId) => {
    form.product_id = productId;
    form.post("/orders");
};
</script>

<template>
    <Button @click="buyProduct(product.id)" class="w-full"> Buy Now </Button>
</template>
