<script setup>
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardTitle,
} from "@/components/ui/card";
import CardHeader from "@/components/ui/card/CardHeader.vue";
import ProductButtonDelete from "./ProductButtonDelete.vue";
import ProductButtonBuy from "./ProductButtonBuy.vue";
import ProductButtonEdit from "./ProductButtonEdit.vue";

const props = defineProps(["product"]);
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>
                {{ product.name }}
            </CardTitle>
            <CardDescription>
                {{ product.description }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <img :src="product.image" />
            <p>
                {{ product.price }}
            </p>
        </CardContent>
        <CardFooter class="flex justify-between gap-1">
            <ProductButtonBuy :product="product" />
            <ProductButtonEdit :product="product" />
            <ProductButtonDelete :product="product" />
        </CardFooter>
    </Card>
</template>
