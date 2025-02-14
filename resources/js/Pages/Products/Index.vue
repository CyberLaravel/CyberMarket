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
    <div class="bg-gray-900 text-gray-100 p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-yellow-400 mb-4 glitch">Products</h1>
        <Link
            href="/products/create"
            class="bg-yellow-400 text-black p-2 rounded-md hover:bg-yellow-300 transition"
            >Add Product</Link
        >

        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th class="text-yellow-400">Name</th>
                    <th class="text-yellow-400">Price</th>
                    <th class="text-yellow-400">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products.data" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td class="text-yellow-400">${{ product.price }}</td>
                    <td class="flex space-x-2">
                        <button
                            @click="buyProduct(product.id)"
                            class="bg-yellow-400 text-black p-2 rounded-md hover:bg-yellow-300 transition"
                        >
                            Buy Now
                        </button>
                        <form
                            :action="`/products/${product.id}`"
                            method="POST"
                            class="inline"
                        >
                            <input
                                type="hidden"
                                name="_method"
                                value="DELETE"
                            />
                            <button
                                type="submit"
                                class="bg-red-500 text-white p-2 rounded-md hover:bg-red-400 transition"
                            >
                                Delete
                            </button>
                        </form>
                        <button
                            @click="
                                () =>
                                    $inertia.visit(
                                        `/products/${product.id}/edit`
                                    )
                            "
                            class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-400 transition"
                        >
                            Edit
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
