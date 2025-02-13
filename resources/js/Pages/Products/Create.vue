<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
    price: "",
});

const submit = () => {
    form.post("/products");
};
</script>

<template>
    <
    <div class="bg-black text-green- neon-glow p-6 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold text-pink-500 mb-4">Add New Product</h1>
        <form @submit.prevent="submit" class="space-y-4">
            <input
                v-model="form.name"
                placeholder="Product Name"
                required
                class="border border-pink-500 bg-gray-800 text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-pink-500"
            />
            <textarea
                v-model="form.description"
                placeholder="Description"
                required
                class="border border-pink-500 bg-gray-800 text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-pink-500"
            ></textarea>
            <input
                v-model="form.price"
                type="number"
                placeholder="Price"
                required
                class="border border-pink-500 bg-gray-800 text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-pink-500"
            />
            <button
                type="submit"
                class="bg-pink-500 text-white p-2 rounded hover:bg-pink-600 transition"
            >
                Submit
            </button>
        </form>
    </div>
</template>
