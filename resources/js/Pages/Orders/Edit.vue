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
    <div class="p-4 bg-white shadow rounded">
        <h1 class="text-3xl font-bold mb-4">Edit Order #{{ order.id }}</h1>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label class="block mb-1">Amount</label>
                <input
                    v-model="form.amount"
                    type="number"
                    required
                    class="border rounded p-2 w-full"
                />
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select v-model="form.status" class="border rounded p-2 w-full">
                    <option>Pending</option>
                    <option>Completed</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white rounded p-2">
                Update
            </button>
        </form>
    </div>
</template>
