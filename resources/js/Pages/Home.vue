<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    products: {
        type: Array,
        required: true,
    },
    featuredProducts: {
        type: Array,
        default: () => [],
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
    <AppLayout>
        <Head title="GlitchMart - Product Listing" />
        <div class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
            <header
                class="bg-gray-800 border-b border-yellow-400 sticky top-0 z-10"
            >
                <div
                    class="max-w-7xl mx-auto flex justify-between items-center p-4"
                >
                    <h1
                        class="text-2xl font-bold text-yellow-400 glitch-effect"
                    >
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

            <main class="flex-grow">
                <!-- Hero Section -->
                <div class="relative bg-gray-800 py-16 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-blue-300/10"
                    ></div>
                    <div class="max-w-7xl mx-auto px-6">
                        <div class="text-center">
                            <h1
                                class="text-5xl font-bold text-yellow-400 glitch-effect mb-6"
                            >
                                Welcome to GlitchMart
                            </h1>
                            <p class="text-xl text-gray-100 mb-8">
                                Your Gateway to Digital Excellence
                            </p>
                            <Link
                                :href="route('products.index')"
                                class="bg-yellow-400 text-black px-8 py-3 rounded-md hover:bg-yellow-300 transition-all duration-300 inline-flex items-center space-x-2"
                            >
                                <span>Explore Products</span>
                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Featured Products Section -->
                <div class="max-w-7xl mx-auto px-6 py-12">
                    <h2
                        class="text-3xl font-bold text-yellow-400 glitch-effect mb-8"
                    >
                        Featured Products
                    </h2>
                    <div class="grid gap-8 lg:grid-cols-3">
                        <div
                            v-for="product in products"
                            :key="product.id"
                            class="bg-gray-800 rounded-lg shadow-lg transition-all duration-300 hover:shadow-[0_0_15px_rgba(250,204,21,0.3)] hover:-translate-y-1"
                        >
                            <div class="relative">
                                <img
                                    :src="product.image"
                                    :alt="product.name"
                                    class="w-full h-56 object-cover rounded-t-lg"
                                />
                                <div class="absolute top-3 right-3">
                                    <span
                                        class="bg-yellow-400 text-black px-3 py-1 rounded-full text-sm font-bold"
                                    >
                                        ${{ product.price }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3
                                    class="text-xl font-semibold text-yellow-400 mb-2"
                                >
                                    {{ product.name }}
                                </h3>
                                <p class="text-gray-100 mb-4">
                                    {{ product.description }}
                                </p>
                                <Link
                                    :href="`/products/${product.id}`"
                                    class="w-full bg-yellow-400 text-black rounded-md px-4 py-2 transition duration-300 hover:bg-yellow-300 inline-block text-center"
                                >
                                    View Details
                                </Link>
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
    </AppLayout>
</template>
