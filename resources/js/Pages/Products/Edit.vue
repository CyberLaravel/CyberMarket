<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    product: Object,
});

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    image: props.product.image,
});

const submit = () => {
    form.put(`/products/${props.product.id}`);
};
</script>

<template>
    <div class="bg-gray-900 text-gray-100 p-6 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold text-yellow-400 mb-4 glitch">
            Edit Product
        </h1>
        <form @submit.prevent="submit" class="space-y-4 flex flex-col">
            <input
                v-model="form.name"
                placeholder="Name"
                class="border border-yellow-400 bg-gray-800 text-gray-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400"
            />
            <textarea
                v-model="form.description"
                placeholder="Description"
                class="border border-yellow-400 bg-gray-800 text-gray-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400"
            ></textarea>
            <input
                v-model="form.price"
                type="number"
                placeholder="Price"
                class="border border-yellow-400 bg-gray-800 text-gray-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400"
            />
            <input
                v-model="form.image"
                placeholder="Image URL"
                class="border border-yellow-400 bg-gray-800 text-gray-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400"
            />
            <button
                type="submit"
                class="bg-yellow-400 text-black p-2 rounded-md hover:bg-yellow-300 transition"
            >
                Update
            </button>
        </form>
    </div>
</template>
