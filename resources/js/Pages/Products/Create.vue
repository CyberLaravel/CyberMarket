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
    <div class="bg-gray-900 text-gray-100 p-6 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold text-yellow-400 mb-4 glitch">
            Add New Product
        </h1>
        <form @submit.prevent="submit" class="space-y-4 flex flex-col">
            <div class="flex flex-col md:flex-row md:space-x-4">
                <input
                    v-model="form.name"
                    placeholder="Product Name"
                    required
                    class="border border-yellow-400 bg-gray-800 text-gray-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400 flex-1"
                />
                <textarea
                    v-model="form.description"
                    placeholder="Description"
                    required
                    class="border border-yellow-400 bg-gray-800 text-gray-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400 flex-1"
                ></textarea>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-4">
                <input
                    v-model="form.price"
                    type="number"
                    placeholder="Price"
                    required
                    class="border border-yellow-400 bg-gray-800 text-gray-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400 flex-1"
                />
                <button
                    type="submit"
                    class="bg-yellow-400 text-black p-2 rounded-md hover:bg-yellow-300 transition flex-1"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>
