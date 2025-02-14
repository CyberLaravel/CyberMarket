<script setup>
import { Button } from "@/Components/ui/button";
import { ShoppingBag } from "lucide-vue-next";
import { useCartStore } from "@/Stores/useCartStore";
import { toast } from "@/Components/ui/toast";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const cart = useCartStore();

const addToCart = () => {
    cart.addToCart(props.product);
    toast({
        title: "Added to cart",
        description: `${props.product.name} has been added to your cart`,
    });
};
</script>

<template>
    <Button
        @click="addToCart"
        variant="secondary"
        class="w-full flex items-center justify-center gap-2"
    >
        <ShoppingBag class="h-4 w-4" />
        Add to Cart
    </Button>
</template>
