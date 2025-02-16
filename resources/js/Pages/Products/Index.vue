<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ProductBox from "@/Components/Products/ProductBox.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";

const props = defineProps({
    products: Array,
    filters: Object,
    categories: Array,
    price_ranges: {
        type: Array,
        default: () => [
            { id: "0-100", label: "$0 - $100" },
            { id: "100-500", label: "$100 - $500" },
            { id: "500-1000", label: "$500 - $1000" },
            { id: "1000+", label: "$1000+" },
        ],
    },
});

const search = ref("");
const sortBy = ref("newest");
const category = ref("all");

const selectedFilters = ref({
    price_range: [],
    categories: [],
    brands: [],
    ratings: [],
});

const minPrice = ref(0);
const maxPrice = ref(1000);
const priceRange = ref([0, 1000]);

const handleSearch = debounce((value) => {
    router.get(
        route("products.index"),
        {
            search: value,
            sort: sortBy.value,
            category: category.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
}, 300);

const handleFilterChange = () => {
    router.get(
        route("products.index"),
        {
            search: search.value,
            sort: sortBy.value,
            category: category.value,
            filters: selectedFilters.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const handlePriceRangeChange = () => {
    router.get(
        route("products.index"),
        {
            search: search.value,
            sort: sortBy.value,
            category: category.value,
            filters: {
                ...selectedFilters.value,
                price_min: priceRange.value[0],
                price_max: priceRange.value[1],
            },
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

watch([sortBy, category], ([newSort, newCategory]) => {
    router.get(
        route("products.index"),
        {
            search: search.value,
            sort: newSort,
            category: newCategory,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
});
</script>

<template>
    <AppLayout>
        <Head title="Products" />

        <div class="container mx-auto px-4 py-8">
            <!-- Search and Sort Controls -->
            <div class="mb-8 flex flex-wrap gap-4">
                <input
                    v-model="search"
                    @input="handleSearch($event.target.value)"
                    type="text"
                    placeholder="Search products..."
                    class="bg-gray-800 border border-yellow-400 text-gray-100 rounded-md p-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none font-orbitron flex-grow"
                />

                <select
                    v-model="sortBy"
                    class="bg-gray-800 border border-yellow-400 text-gray-100 rounded-md p-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none font-orbitron"
                >
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="name_asc">Name: A to Z</option>
                    <option value="name_desc">Name: Z to A</option>
                    <option value="popularity">Most Popular</option>
                    <option value="rating">Highest Rated</option>
                </select>
            </div>

            <!-- Enhanced Results Information -->
            <div class="mb-6 space-y-2">
                <div class="flex justify-between items-center">
                    <p class="font-orbitron text-gray-100">
                        Showing {{ products.from }}-{{ products.to }} of
                        {{ products.total }} results
                    </p>
                    <p class="font-orbitron text-blue-300">
                        Page {{ products.current_page }} of
                        {{ products.last_page }}
                    </p>
                </div>
                <div class="flex gap-4 text-sm">
                    <span
                        v-if="search"
                        class="px-3 py-1 rounded-md bg-gray-800 border border-yellow-400 text-gray-100"
                    >
                        Search: "{{ search }}"
                    </span>
                    <span
                        v-if="sortBy"
                        class="px-3 py-1 rounded-md bg-gray-800 border border-yellow-400 text-gray-100"
                    >
                        Sort:
                        {{
                            sortBy.replace("_", " ").charAt(0).toUpperCase() +
                            sortBy.slice(1)
                        }}
                    </span>
                    <span
                        v-if="selectedFilters.categories.length"
                        class="px-3 py-1 rounded-md bg-gray-800 border border-yellow-400 text-gray-100"
                    >
                        Categories:
                        {{ selectedFilters.categories.length }} selected
                    </span>
                    <span
                        v-if="selectedFilters.price_range.length"
                        class="px-3 py-1 rounded-md bg-gray-800 border border-yellow-400 text-gray-100"
                    >
                        Price Filters:
                        {{ selectedFilters.price_range.length }} selected
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <!-- Side Navigation -->
                <div class="col-span-3 space-y-6">
                    <!-- Price Range Filter -->
                    <div
                        class="bg-gray-800 p-4 rounded-lg border border-yellow-400"
                    >
                        <h3 class="text-yellow-400 font-bold mb-4 text-lg">
                            Price Range
                        </h3>

                        <!-- Price Range Slider -->
                        <div class="mb-6 space-y-6">
                            <!-- Price Display -->
                            <div
                                class="bg-gray-900 p-3 rounded-md border border-yellow-400/30 flex justify-between items-center"
                            >
                                <div class="text-center">
                                    <span
                                        class="text-xs text-gray-400 block mb-1"
                                        >From</span
                                    >
                                    <span
                                        class="text-yellow-400 text-lg font-bold"
                                        >${{ priceRange[0] }}</span
                                    >
                                </div>
                                <div class="h-8 w-px bg-yellow-400/20"></div>
                                <div class="text-center">
                                    <span
                                        class="text-xs text-gray-400 block mb-1"
                                        >To</span
                                    >
                                    <span
                                        class="text-yellow-400 text-lg font-bold"
                                        >${{ priceRange[1] }}</span
                                    >
                                </div>
                            </div>

                            <!-- Slider -->
                            <div class="relative py-4">
                                <div
                                    class="absolute h-1 bg-yellow-400/20 rounded-lg w-full"
                                ></div>
                                <input
                                    type="range"
                                    v-model="priceRange[0]"
                                    :min="minPrice"
                                    :max="maxPrice"
                                    @change="handlePriceRangeChange"
                                    class="absolute w-full h-1 rounded-lg appearance-none cursor-pointer range-slider"
                                />
                                <input
                                    type="range"
                                    v-model="priceRange[1]"
                                    :min="minPrice"
                                    :max="maxPrice"
                                    @change="handlePriceRangeChange"
                                    class="absolute w-full h-1 rounded-lg appearance-none cursor-pointer range-slider"
                                />
                            </div>

                            <!-- Manual Input -->
                            <div class="flex items-center gap-4">
                                <div class="flex-1">
                                    <label
                                        class="block text-xs text-gray-400 mb-1"
                                        >Min Price</label
                                    >
                                    <input
                                        type="number"
                                        v-model.number="priceRange[0]"
                                        :min="minPrice"
                                        :max="priceRange[1]"
                                        @change="handlePriceRangeChange"
                                        class="w-full bg-gray-900 border border-yellow-400/30 text-yellow-400 rounded-md p-2 text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent focus:outline-none transition-all duration-200"
                                    />
                                </div>
                                <div class="flex-1">
                                    <label
                                        class="block text-xs text-gray-400 mb-1"
                                        >Max Price</label
                                    >
                                    <input
                                        type="number"
                                        v-model.number="priceRange[1]"
                                        :min="priceRange[0]"
                                        :max="maxPrice"
                                        @change="handlePriceRangeChange"
                                        class="w-full bg-gray-900 border border-yellow-400/30 text-yellow-400 rounded-md p-2 text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent focus:outline-none transition-all duration-200"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-yellow-400/20 pt-4">
                            <p class="text-gray-400 text-sm mb-3">
                                Quick Ranges:
                            </p>
                            <div class="space-y-2">
                                <label
                                    v-for="range in price_ranges"
                                    :key="range.id"
                                    class="flex items-center space-x-2 hover:bg-gray-700/50 p-1 rounded-md transition-colors duration-200"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="selectedFilters.price_range"
                                        :value="range.id"
                                        @change="handleFilterChange"
                                        class="form-checkbox bg-gray-900 border-yellow-400 text-yellow-400 rounded"
                                    />
                                    <span class="text-gray-100">{{
                                        range.label
                                    }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Filter -->
                    <div
                        class="bg-gray-800 p-4 rounded-lg border border-yellow-400"
                    >
                        <h3 class="text-yellow-400 font-bold mb-4 text-lg">
                            Categories
                        </h3>
                        <div class="space-y-2">
                            <label
                                v-for="cat in categories"
                                :key="cat.id"
                                class="flex items-center space-x-2"
                            >
                                <input
                                    type="checkbox"
                                    v-model="selectedFilters.categories"
                                    :value="cat.id"
                                    @change="handleFilterChange"
                                    class="form-checkbox bg-gray-700 border-yellow-400 text-yellow-400 rounded"
                                />
                                <span class="text-gray-100">{{
                                    cat.name
                                }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Brands Filter -->
                    <div
                        class="bg-gray-800 p-4 rounded-lg border border-yellow-400"
                    >
                        <h3 class="text-yellow-400 font-bold mb-4 text-lg">
                            Brands
                        </h3>
                        <div class="space-y-2">
                            <label
                                v-for="brand in filters.brands"
                                :key="brand.id"
                                class="flex items-center space-x-2"
                            >
                                <input
                                    type="checkbox"
                                    v-model="selectedFilters.brands"
                                    :value="brand.id"
                                    @change="handleFilterChange"
                                    class="form-checkbox bg-gray-700 border-yellow-400 text-yellow-400 rounded"
                                />
                                <span class="text-gray-100">{{
                                    brand.name
                                }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Ratings Filter -->
                    <div
                        class="bg-gray-800 p-4 rounded-lg border border-yellow-400"
                    >
                        <h3 class="text-yellow-400 font-bold mb-4 text-lg">
                            Ratings
                        </h3>
                        <div class="space-y-2">
                            <label
                                v-for="rating in filters.ratings"
                                :key="rating.value"
                                class="flex items-center space-x-2"
                            >
                                <input
                                    type="checkbox"
                                    v-model="selectedFilters.ratings"
                                    :value="rating.value"
                                    @change="handleFilterChange"
                                    class="form-checkbox bg-gray-700 border-yellow-400 text-yellow-400 rounded"
                                />
                                <span class="text-gray-100">{{
                                    rating.label
                                }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="col-span-9">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <ProductBox
                            v-for="product in products.data"
                            :key="product.id"
                            :product="product"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.shadow-neon {
    box-shadow: 0 0 10px rgba(250, 204, 21, 0.5);
}

.glitch-text {
    text-shadow: 2px 2px #00fffc, -2px -2px #fc00ff;
    animation: glitch 1s infinite;
}

@keyframes glitch {
    0% {
        text-shadow: 2px 2px #00fffc, -2px -2px #fc00ff;
    }
    25% {
        text-shadow: -2px 2px #00fffc, 2px -2px #fc00ff;
    }
    50% {
        text-shadow: 2px -2px #00fffc, -2px 2px #fc00ff;
    }
    75% {
        text-shadow: -2px -2px #00fffc, 2px 2px #fc00ff;
    }
    100% {
        text-shadow: 2px 2px #00fffc, -2px -2px #fc00ff;
    }
}

.range-slider {
    -webkit-appearance: none;
    pointer-events: none;
    background: transparent;
}

.range-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    pointer-events: auto;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #facc15;
    cursor: pointer;
    border: 2px solid #1f2937;
    box-shadow: 0 0 10px rgba(250, 204, 21, 0.5),
        0 0 20px rgba(250, 204, 21, 0.3);
    transition: all 0.2s ease;
}

.range-slider::-webkit-slider-thumb:hover {
    box-shadow: 0 0 15px rgba(250, 204, 21, 0.7),
        0 0 25px rgba(250, 204, 21, 0.5);
}

.range-slider::-moz-range-thumb {
    pointer-events: auto;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #facc15;
    cursor: pointer;
    border: 2px solid #1f2937;
    box-shadow: 0 0 10px rgba(250, 204, 21, 0.5),
        0 0 20px rgba(250, 204, 21, 0.3);
    transition: all 0.2s ease;
}

.range-slider::-moz-range-thumb:hover {
    box-shadow: 0 0 15px rgba(250, 204, 21, 0.7),
        0 0 25px rgba(250, 204, 21, 0.5);
}

.range-slider:focus {
    outline: none;
}
</style>
