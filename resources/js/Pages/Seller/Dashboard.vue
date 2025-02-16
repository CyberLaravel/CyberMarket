<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Package, DollarSign, ShoppingCart, TrendingUp } from "lucide-vue-next";

const props = defineProps({
    stats: Object,
    recentProducts: Array,
    recentOrders: Array,
});

const stats = computed(() => [
    {
        title: "Total Products",
        value: props.stats.totalProducts,
        description: "Your listed products",
        icon: Package,
    },
    {
        title: "Total Orders",
        value: props.stats.totalOrders,
        description: "Orders with your products",
        icon: ShoppingCart,
    },
    {
        title: "Total Revenue",
        value: `$${props.stats.totalRevenue.toFixed(2)}`,
        description: "From all orders",
        icon: DollarSign,
    },
    {
        title: "Average Order Value",
        value: `$${props.stats.averageOrderValue.toFixed(2)}`,
        description: "Per order with your products",
        icon: TrendingUp,
    },
]);
</script>

<template>
    <AppLayout title="Seller Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1
                    class="text-2xl font-bold text-yellow-400 mb-8 font-orbitron glitch-text"
                >
                    Seller Dashboard
                </h1>

                <!-- Stats Grid -->
                <div
                    class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-8"
                >
                    <Card
                        v-for="stat in stats"
                        :key="stat.title"
                        class="bg-gray-800 border-yellow-400 hover:shadow-neon transition-all duration-300"
                    >
                        <CardHeader
                            class="flex flex-row items-center justify-between pb-2"
                        >
                            <CardTitle
                                class="text-yellow-400 text-sm font-medium"
                            >
                                {{ stat.title }}
                            </CardTitle>
                            <component
                                :is="stat.icon"
                                class="h-4 w-4 text-blue-300"
                            />
                        </CardHeader>
                        <CardContent>
                            <div class="text-2xl font-bold text-yellow-400">
                                {{ stat.value }}
                            </div>
                            <p class="text-xs text-blue-300">
                                {{ stat.description }}
                            </p>
                        </CardContent>
                    </Card>
                </div>

                <div class="grid gap-6 grid-cols-1 lg:grid-cols-2">
                    <!-- Recent Products -->
                    <Card class="bg-gray-800 border-yellow-400">
                        <CardHeader class="flex justify-between items-center">
                            <CardTitle class="text-yellow-400"
                                >Your Products</CardTitle
                            >
                            <Link
                                :href="route('products.create')"
                                class="text-sm text-blue-300 hover:text-yellow-400 transition-colors"
                            >
                                Add New
                            </Link>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div
                                    v-for="product in recentProducts"
                                    :key="product.id"
                                    class="flex items-center gap-4 p-3 bg-gray-900 rounded-lg border border-yellow-400/30 hover:border-yellow-400 transition-colors"
                                >
                                    <img
                                        :src="
                                            product.image_url ||
                                            'https://dummyimage.com/100x100'
                                        "
                                        :alt="product.name"
                                        class="w-16 h-16 object-cover rounded-lg border border-yellow-400"
                                    />
                                    <div class="flex-1 min-w-0">
                                        <Link
                                            :href="
                                                route(
                                                    'products.show',
                                                    product.id
                                                )
                                            "
                                            class="text-yellow-400 font-medium hover:text-yellow-300 transition-colors"
                                        >
                                            {{ product.name }}
                                        </Link>
                                        <p class="text-sm text-blue-300">
                                            ${{ product.price }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Recent Orders -->
                    <Card class="bg-gray-800 border-yellow-400">
                        <CardHeader>
                            <CardTitle class="text-yellow-400"
                                >Recent Orders</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div
                                    v-for="order in recentOrders"
                                    :key="order.id"
                                    class="p-3 bg-gray-900 rounded-lg border border-yellow-400/30 hover:border-yellow-400 transition-colors"
                                >
                                    <div
                                        class="flex justify-between items-start mb-2"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'seller.orders.show',
                                                    order.id
                                                )
                                            "
                                            class="text-yellow-400 font-medium hover:text-yellow-300 transition-colors"
                                        >
                                            Order #{{ order.id }}
                                        </Link>
                                        <span
                                            :class="{
                                                'text-green-400':
                                                    order.status ===
                                                    'completed',
                                                'text-yellow-400':
                                                    order.status === 'pending',
                                                'text-blue-300':
                                                    order.status ===
                                                    'processing',
                                            }"
                                            class="text-xs font-medium px-2 py-1 rounded-full bg-gray-800"
                                        >
                                            {{ order.status }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-blue-300">
                                        {{ order.user.name }}
                                    </p>
                                    <div
                                        class="text-sm text-yellow-400 font-medium flex justify-between"
                                    >
                                        <span>${{ order.seller_total }}</span>
                                        <span class="text-blue-300">{{
                                            order.created_at
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
