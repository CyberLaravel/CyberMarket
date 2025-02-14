<!-- ProductBox.vue -->
<script setup>
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Badge } from "@/Components/ui/badge";
import ProductButtonDelete from "./ProductButtonDelete.vue";
import ProductButtonBuy from "./ProductButtonBuy.vue";
import ProductButtonEdit from "./ProductButtonEdit.vue";
import ProductButtonAddToCart from "./ProductButtonAddToCart.vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Card class="h-full flex flex-col">
        <CardHeader>
            <div
                class="aspect-square w-full relative rounded-lg overflow-hidden mb-4"
            >
                <img
                    :src="product.image"
                    :alt="product.name"
                    class="object-cover w-full h-full"
                    @error="
                        $event.target.src =
                            'https://placehold.co/600x600?text=No+Image'
                    "
                />
            </div>
            <CardTitle class="line-clamp-1">
                {{ product.name }}
            </CardTitle>
            <CardDescription class="line-clamp-2">
                {{ product.description }}
            </CardDescription>
        </CardHeader>
        <CardContent class="flex-grow">
            <div class="flex items-center justify-between">
                <p class="text-2xl font-bold">
                    ${{ parseFloat(product.price).toFixed(2) }}
                </p>
                <Badge variant="secondary">
                    {{ product.seller.name }}
                </Badge>
            </div>
        </CardContent>
        <!-- <CardFooter class="grid grid-cols-2 gap-2">
            <ProductButtonBuy :product="product" />
            <div
                class="grid grid-cols-2 gap-2"
                v-if="$page.props.auth.user.id === product.seller.id"
            >
                <ProductButtonEdit :product="product" />
                <ProductButtonDelete :product="product" />
            </div>
        </CardFooter> -->

        <CardFooter class="grid grid-cols-2 gap-2">
            <ProductButtonAddToCart :product="product" />
            <ProductButtonBuy :product="product" />
            <div
                class="grid grid-cols-2 gap-2"
                v-if="$page.props.auth.user.id === product.seller.id"
            >
                <ProductButtonEdit :product="product" />
                <ProductButtonDelete :product="product" />
            </div>
        </CardFooter>
    </Card>
</template>
