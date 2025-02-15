<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ProductBox from "@/Components/Products/ProductBox.vue";
import ProductList from "@/Components/Products/ProductList.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button } from "@/Components/ui/button";
import { PlusIcon } from "lucide-vue-next";
import { ref, watch } from "vue";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { Input } from "@/Components/ui/input";
import { router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";

const props = defineProps({
    products: Array,
    filters: Object,
});

console.log({ products: props.products });

const search = ref("");
const sortBy = ref("newest");
const category = ref("all");

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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-yellow-400 glitch-text">
                    Products
                </h1>

                <Link :href="route('products.create')">
                    <Button
                        class="bg-yellow-400 hover:bg-yellow-300 text-black font-orbitron transition-all duration-300 shadow-neon"
                    >
                        <span class="flex items-center gap-2">
                            <PlusIcon class="w-5 h-5" />
                            Add Product
                        </span>
                    </Button>
                </Link>
            </div>

            <p class="text-blue-300 font-orbitron mb-8">
                Manage your product inventory
            </p>

            <div
                class="bg-gray-900 p-6 rounded-lg border border-yellow-400 shadow-neon mb-8"
            >
                <div class="mb-8 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <Input
                            v-model="search"
                            placeholder="Search products..."
                            class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                            @input="(e) => handleSearch(e.target.value)"
                        />

                        <Select v-model="sortBy">
                            <SelectTrigger
                                class="bg-gray-800 border-yellow-400 text-gray-100"
                            >
                                <SelectValue placeholder="Sort by" />
                            </SelectTrigger>
                            <SelectContent
                                class="bg-gray-800 border-yellow-400"
                            >
                                <SelectItem value="newest"
                                    >Newest First</SelectItem
                                >
                                <SelectItem value="oldest"
                                    >Oldest First</SelectItem
                                >
                                <SelectItem value="price_asc"
                                    >Price: Low to High</SelectItem
                                >
                                <SelectItem value="price_desc"
                                    >Price: High to Low</SelectItem
                                >
                                <SelectItem value="name_asc"
                                    >Name: A to Z</SelectItem
                                >
                                <SelectItem value="name_desc"
                                    >Name: Z to A</SelectItem
                                >
                            </SelectContent>
                        </Select>

                        <Select v-model="category">
                            <SelectTrigger
                                class="bg-gray-800 border-yellow-400 text-gray-100"
                            >
                                <SelectValue placeholder="Category" />
                            </SelectTrigger>
                            <SelectContent
                                class="bg-gray-800 border-yellow-400"
                            >
                                <SelectItem value="all"
                                    >All Categories</SelectItem
                                >
                                <SelectItem value="electronics"
                                    >Electronics</SelectItem
                                >
                                <SelectItem value="clothing"
                                    >Clothing</SelectItem
                                >
                                <SelectItem value="books">Books</SelectItem>
                                <!-- Add more categories as needed -->
                            </SelectContent>
                        </Select>
                    </div>
                </div>

                <ProductList :products="products.data" />
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
</style>
