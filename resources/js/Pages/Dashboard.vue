<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const products = ref([
    {
        id: 1,
        name: "Neon Keyboard",
        description: "A mechanical keyboard with customizable RGB lighting.",
        price: 99.99,
        image: "https://dummyimage.com/300x250.png&text=Neon+Keyboard",
    },
    {
        id: 2,
        name: "Cyberpunk Headset",
        description: "High-quality headset with immersive sound.",
        price: 149.99,
        image: "https://dummyimage.com/300x250.png&text=Cyberpunk+Headset",
    },
    {
        id: 3,
        name: "Glitch Mouse",
        description: "Ergonomic mouse with programmable buttons.",
        price: 59.99,
        image: "https://dummyimage.com/300x250.png&text=Glitch+Mouse",
    },
    {
        id: 4,
        name: "Holo Display",
        description: "A futuristic display with holographic capabilities.",
        price: 299.99,
        image: "https://dummyimage.com/300x250.png&text=Holo+Display",
    },
    {
        id: 5,
        name: "VR Headset",
        description: "Immersive virtual reality headset for gaming.",
        price: 399.99,
        image: "https://dummyimage.com/300x250.png&text=VR+Headset",
    },
    {
        id: 6,
        name: "Gaming Chair",
        description: "Comfortable chair designed for long gaming sessions.",
        price: 199.99,
        image: "https://dummyimage.com/300x250.png&text=Gaming+Chair",
    },
]);
</script>

<template>
    <AppLayout title="Dashboard">
        <template #headerTitle> Product Dashboard </template>
        <template #headerDescription> Product Dashboard dsecription</template>
        <template #headerContent> Product Dashboard </template>
        <template #headerFooter> Product Dashboard </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="bg-gray-800 rounded-lg shadow-lg transition duration-300 hover:shadow-xl"
                    >
                        <img
                            :src="product.image"
                            alt="Product Image"
                            class="w-full h-48 object-cover rounded-t-lg"
                        />
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-yellow-400">
                                {{ product.name }}
                            </h3>
                            <p class="text-gray-100 mb-2">
                                {{ product.description }}
                            </p>
                            <span class="text-lg font-bold text-yellow-400"
                                >${{ product.price }}</span
                            >
                            <div class="mt-4">
                                <Link
                                    :href="`/products/${product.id}`"
                                    class="bg-yellow-400 text-black rounded-md px-4 py-2 transition duration-300 hover:bg-yellow-300"
                                    >View Details</Link
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template #footerTitle> Product Dashboard </template>
        <template #footerDescription> Product Dashboard dsecription</template>
        <template #footerContent> Product Dashboard </template>
        <template #footerFooter> Product Dashboard </template>
    </AppLayout>
</template>
