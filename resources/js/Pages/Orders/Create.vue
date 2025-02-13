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
    <div>
        <h1 class="text-2xl font-bold">Create Order</h1>

        <form @submit.prevent="submit">
            <label>Amount</label>
            <input v-model="form.amount" type="number" required />

            <label>Status</label>
            <select v-model="form.status">
                <option>Pending</option>
                <option>Completed</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</template>
