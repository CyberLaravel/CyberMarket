<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({ products: Array });

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
    <Head title="Products" />
    <div>
        <h1 class="text-2xl font-bold">Products</h1>
        <Link href="/products/create" class="btn">Add Product</Link>

        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products.data" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>${{ product.price }}</td>
                    <td>
                        <button @click="buyProduct(product.id)" class="btn">
                            Buy Now
                        </button>
                        <form :action="`/products/${product.id}`" method="POST">
                            <input
                                type="hidden"
                                name="_method"
                                value="DELETE"
                            />
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
