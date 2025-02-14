<!-- ProductButtonBuy.vue -->
<script setup>
import { Button } from "@/Components/ui/button";
import { useForm } from "@inertiajs/vue3";
import { ShoppingCart } from "lucide-vue-next";
import { toast } from "@/Components/ui/toast";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    product_id: null,
    quantity: 1,
});

const buyProduct = (productId) => {
    form.product_id = productId;
    form.post("/orders", {
        onSuccess: () => {
            toast({
                title: "Success",
                description: "Product has been added to your orders",
            });
        },
        onError: () => {
            toast({
                title: "Error",
                description: "Failed to process order. Please try again.",
                variant: "destructive",
            });
        },
    });
};
</script>

<template>
    <Button
        @click="buyProduct(product.id)"
        class="w-full flex items-center justify-center gap-2"
        :disabled="form.processing"
    >
        <ShoppingCart class="h-4 w-4" />
        {{ form.processing ? "Processing..." : "Buy Now" }}
    </Button>
</template>
