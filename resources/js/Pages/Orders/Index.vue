<script setup>
import { Head, Link } from "@inertiajs/vue3";
defineProps({ orders: Array });
</script>

<template>
    <Head title="My Orders" />
    <div>
        <h1 class="text-2xl font-bold">My Orders</h1>
        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in orders" :key="order.id">
                    <td>{{ order.product.name }}</td>
                    <td>{{ order.quantity }}</td>
                    <td>${{ order.amount }}</td>
                    <td>{{ order.status }}</td>
                    <td>
                        <Link :href="`/orders/${order.id}`" class="btn"
                            >View</Link
                        >
                        <Link :href="`/orders/${order.id}/edit`" class="btn"
                            >Edit</Link
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
