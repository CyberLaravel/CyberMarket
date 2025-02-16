<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Users, Package, ShoppingCart, DollarSign } from "lucide-vue-next";

const props = defineProps({
    stats: Object,
    topSellers: Array,
    recentOrders: Array,
    salesByDay: Array,
});

const stats = computed(() => [
    {
        title: "Total Users",
        value: props.stats.totalUsers,
        description: "Registered users",
        icon: Users,
    },
    {
        title: "Total Products",
        value: props.stats.totalProducts,
        description: "Listed products",
        icon: Package,
    },
    {
        title: "Total Sales",
        value: props.stats.totalSales,
        description: "Completed orders",
        icon: ShoppingCart,
    },
    {
        title: "Total Revenue",
        value: `$${props.stats.totalRevenue.toFixed(2)}`,
        description: "Platform revenue",
        icon: DollarSign,
    },
]);
</script>

<template>
    <AppLayout title="Admin Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1
                    class="text-2xl font-bold text-yellow-400 mb-8 font-orbitron glitch-text"
                >
                    Admin Dashboard
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
                    <!-- Top Sellers -->
                    <Card class="bg-gray-800 border-yellow-400">
                        <CardHeader>
                            <CardTitle class="text-yellow-400"
                                >Top Sellers</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div
                                    v-for="seller in topSellers"
                                    :key="seller.id"
                                    class="p-3 bg-gray-900 rounded-lg border border-yellow-400/30 hover:border-yellow-400 transition-colors"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <p
                                                class="text-yellow-400 font-medium"
                                            >
                                                {{ seller.name }}
                                            </p>
                                            <p class="text-sm text-blue-300">
                                                {{
                                                    seller.products_count
                                                }}
                                                products
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="text-yellow-400 font-medium"
                                            >
                                                ${{ seller.revenue }}
                                            </p>
                                            <p class="text-sm text-blue-300">
                                                {{ seller.orders_count }} orders
                                            </p>
                                        </div>
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
                                                route('orders.show', order.id)
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
                                            }"
                                            class="text-xs font-medium px-2 py-1 rounded-full bg-gray-800"
                                        >
                                            {{ order.status }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <p class="text-sm text-blue-300">
                                            {{ order.user.name }}
                                        </p>
                                        <p
                                            class="text-sm text-yellow-400 font-medium"
                                        >
                                            ${{ order.total }}
                                        </p>
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
