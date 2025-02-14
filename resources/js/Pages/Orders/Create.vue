<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    amount: "",
    status: "Pending",
});

const submit = () => {
    form.post("/orders");
};
</script>

<template>
    <div class="p-4 bg-white shadow rounded">
        <h1 class="text-3xl font-bold mb-4">Create Order</h1>

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
                Submit
            </button>
        </form>
    </div>
</template>
