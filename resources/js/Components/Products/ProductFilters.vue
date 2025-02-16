<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({
            minPrice: 0,
            maxPrice: 1000,
            category: null,
            condition: null,
        }),
    },
});

const currentFilters = ref({ ...props.filters });

// Debounced filter update
let timeout;
watch(
    currentFilters,
    (newFilters) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            router.get(route("products.index"), newFilters.value, {
                preserveState: true,
                preserveScroll: true,
            });
        }, 500);
    },
    { deep: true }
);
</script>

<template>
    <div
        class="bg-gray-800 border border-yellow-400 rounded-lg p-6 sticky top-4"
    >
        <!-- Header -->
        <h2 class="text-xl text-yellow-400 font-orbitron mb-6 glitch-text">
            Advanced Filters
        </h2>

        <div class="space-y-6">
            <!-- Price Range -->
            <div class="space-y-4">
                <h3 class="text-blue-300 font-orbitron text-sm">Price Range</h3>
                <div class="space-y-2">
                    <input
                        type="range"
                        v-model="currentFilters.minPrice"
                        min="0"
                        max="1000"
                        class="w-full h-2 bg-gray-900 rounded-lg appearance-none cursor-pointer accent-yellow-400"
                    />
                    <div
                        class="flex justify-between text-gray-100 font-orbitron text-sm"
                    >
                        <span>${{ currentFilters.minPrice }}</span>
                        <span>${{ currentFilters.maxPrice }}</span>
                    </div>
                </div>
            </div>

            <!-- Condition Filter -->
            <div class="space-y-2">
                <h3 class="text-blue-300 font-orbitron text-sm">Condition</h3>
                <select
                    v-model="currentFilters.condition"
                    class="w-full bg-gray-900 border border-yellow-400 text-gray-100 rounded-md p-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none font-orbitron"
                >
                    <option value="">All Conditions</option>
                    <option value="new">New</option>
                    <option value="used">Used</option>
                    <option value="refurbished">Refurbished</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div class="space-y-2">
                <h3 class="text-blue-300 font-orbitron text-sm">Category</h3>
                <select
                    v-model="currentFilters.category"
                    class="w-full bg-gray-900 border border-yellow-400 text-gray-100 rounded-md p-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none font-orbitron"
                >
                    <option value="">All Categories</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="books">Books</option>
                </select>
            </div>
        </div>
    </div>
</template>
