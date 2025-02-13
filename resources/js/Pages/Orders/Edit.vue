<script setup>
import { useForm } from "@inertiajs/vue3";
defineProps({ order: Object });

const form = useForm({
    amount: order.amount,
    status: order.status,
});

const submit = () => {
    form.put(`/orders/${order.id}`);
};
</script>

<template>
    <div>
        <h1 class="text-2xl font-bold">Edit Order #{{ order.id }}</h1>

        <form @submit.prevent="submit">
            <label>Amount</label>
            <input v-model="form.amount" type="number" required />

            <label>Status</label>
            <select v-model="form.status">
                <option>Pending</option>
                <option>Completed</option>
            </select>

            <button type="submit">Update</button>
        </form>
    </div>
</template>
