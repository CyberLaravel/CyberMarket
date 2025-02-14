<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    products: {
        type: Array,
        required: true,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <Head title="GlitchMart - Product Listing" />
    <div class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
        <header
            class="bg-gray-800 border-b border-yellow-400 sticky top-0 z-10"
        >
            <div
                class="max-w-7xl mx-auto flex justify-between items-center p-4"
            >
                <h1 class="text-2xl font-bold text-yellow-400 glitch-effect">
                    GlitchMart
                </h1>
                <nav class="flex space-x-4">
                    <Link
                        :href="route('home')"
                        class="text-blue-300 hover:text-yellow-400 transition"
                        >Home</Link
                    >
                    <Link
                        :href="route('about')"
                        class="text-blue-300 hover:text-yellow-400 transition"
                        >About</Link
                    >
                    <Link
                        :href="route('contact')"
                        class="text-blue-300 hover:text-yellow-400 transition"
                        >Contact</Link
                    >
                </nav>
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center">
            <div class="max-w-6xl w-full p-6">
                <h2
                    class="text-3xl font-bold text-yellow-400 glitch-effect mb-6"
                >
                    Featured Products
                </h2>
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
        </main>

        <footer
            class="bg-gray-800 border-t border-yellow-400 text-center text-sm text-blue-300 py-4"
        >
            Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
        </footer>
    </div>
</template>
