<script setup>
import { Head, Link } from "@inertiajs/vue3";
defineProps({ orders: Array });
</script>

<template>
    <Head title="My Orders" />
    <div class="p-4 bg-white shadow rounded">
        <h1 class="text-3xl font-bold mb-4">My Orders</h1>
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Product</th>
                    <th class="border p-2">Quantity</th>
                    <th class="border p-2">Amount</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="order in orders"
                    :key="order.id"
                    class="hover:bg-gray-100"
                >
                    <td class="border p-2">{{ order.product.name }}</td>
                    <td class="border p-2">{{ order.quantity }}</td>
                    <td class="border p-2">${{ order.amount }}</td>
                    <td class="border p-2">{{ order.status }}</td>
                    <td class="border p-2">
                        <Link
                            :href="`/orders/${order.id}`"
                            class="btn bg-blue-500 text-white rounded p-1"
                            >View</Link
                        >
                        <Link
                            :href="`/orders/${order.id}/edit`"
                            class="btn bg-yellow-500 text-white rounded p-1"
                            >Edit</Link
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
