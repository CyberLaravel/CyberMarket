<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ProductBox from "@/Components/Products/ProductBox.vue";
import ProductList from "@/Components/Products/ProductList.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button } from "@/Components/ui/button";

defineProps({ products: Array });
</script>

<template>
    <AppLayout>
        <Head title="Products" />

        <template #headerTitle>
            <div class="flex justify-between">
                Add Product

                <Link :href="route('products.create')">
                    <Button>Add Product</Button>
                </Link>
            </div>
        </template>
        <template #headerDescription> Add Product </template>

        <ProductList :products="products.data" />
    </AppLayout>
</template>
