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
import { getProductPrimaryImageUrl } from "@/utils/imageUtils";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
dayjs.extend(relativeTime);

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const getRelativeTime = (date) => {
    return dayjs(date).fromNow();
};
</script>

<template>
    <Card
        class="h-full flex flex-col bg-gray-800 border border-yellow-400 hover:shadow-neon transition-all duration-300"
    >
        <CardHeader>
            <div
                class="aspect-square w-full relative rounded-lg overflow-hidden mb-4 border border-yellow-400"
            >
                <div
                    v-if="$page.props.auth.user.id === product.seller.id"
                    class="absolute top-2 right-2 flex gap-2 z-10"
                >
                    <ProductButtonEdit :product="product" />
                    <ProductButtonDelete :product="product" />
                </div>

                <img
                    :src="getProductPrimaryImageUrl(product)"
                    :alt="product.name"
                    class="object-cover w-full h-full hover:scale-105 transition-transform duration-300"
                />
            </div>
            <div class="space-y-2">
                <CardTitle
                    class="line-clamp-1 text-yellow-400 font-orbitron glitch-text"
                >
                    {{ product.name }}
                </CardTitle>
                <Badge
                    variant="secondary"
                    class="bg-gray-900 text-blue-300 border border-yellow-400 font-orbitron hover:bg-gray-800 transition-colors duration-300"
                >
                    Sold by {{ product.seller.name }}
                </Badge>
                <p class="text-sm text-blue-300 font-orbitron opacity-75">
                    {{ getRelativeTime(product.created_at) }}
                </p>
                <CardDescription
                    class="line-clamp-2 text-blue-300 font-orbitron"
                >
                    {{ product.description }}
                </CardDescription>
            </div>
        </CardHeader>
        <CardContent class="flex-grow">
            <div class="flex items-center justify-end">
                <p class="text-2xl font-bold text-yellow-400 font-orbitron">
                    ${{ parseFloat(product.price).toFixed(2) }}
                </p>
            </div>
        </CardContent>

        <CardFooter class="grid grid-cols-2 gap-2 text-gray-100">
            <ProductButtonAddToCart :product="product" />
            <ProductButtonBuy :product="product" />
        </CardFooter>
    </Card>
</template>
