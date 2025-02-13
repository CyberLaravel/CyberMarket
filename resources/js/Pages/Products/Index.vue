<script setup>
import { Link, usePage } from "@inertiajs/vue3";

defineProps({
    products: Array,
});
console.log(usePage().props.products);
</script>

<template>
    <div>
        <h1>Products</h1>
        <Link href="/products/create" class="btn">Add Product</Link>

        <ul>
            <li v-for="product in products.data" :key="product.id">
                <Link :href="`/products/${product.id}`">{{
                    product.name
                }}</Link>
                <Link :href="`/products/${product.id}/edit`">Edit</Link>
                <form :action="`/products/${product.id}`" method="POST">
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit">Delete</button>
                </form>
            </li>
        </ul>
    </div>
</template>
