<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { BarChart, Users, Package, ShoppingCart } from "lucide-vue-next";

const props = defineProps({
    stats: Object,
    recentProducts: Array,
    recentOrders: Array,
});

console.log(props);

const stats = computed(() => [
    {
        title: "Total Products",
        value: props.stats.totalProducts,
        description: "Products in marketplace",
        icon: Package,
    },
    {
        title: "Total Users",
        value: props.stats.totalUsers,
        description: "Registered users",
        icon: Users,
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
        description: "Total earnings",
        icon: BarChart,
    },
]);
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats Grid -->
                <div
                    class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-8"
                >
                    <div
                        v-for="stat in stats"
                        :key="stat.title"
                        class="bg-gray-800 border border-yellow-400 rounded-lg p-4 hover:shadow-neon transition-all duration-300"
                    >
                        <div
                            class="flex flex-row items-center justify-between pb-2"
                        >
                            <h3 class="text-yellow-400 text-sm font-medium">
                                {{ stat.title }}
                            </h3>
                            <component
                                :is="stat.icon"
                                class="h-4 w-4 text-blue-300"
                            />
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-yellow-400">
                                {{ stat.value }}
                            </div>
                            <p class="text-xs text-blue-300">
                                {{ stat.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Recent Products and Orders Grid -->
                <div class="grid gap-6 grid-cols-1 lg:grid-cols-2 mb-8">
                    <!-- Recent Products -->
                    <div
                        class="bg-gray-800 border border-yellow-400 rounded-lg"
                    >
                        <div class="p-4 border-b border-yellow-400">
                            <h3 class="text-yellow-400 text-lg font-bold">
                                Recent Products
                            </h3>
                        </div>
                        <div class="p-4">
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
                                        <p
                                            class="text-sm text-blue-300 truncate"
                                        >
                                            {{ product.description }}
                                        </p>
                                        <p
                                            class="text-sm text-yellow-400 font-medium"
                                        >
                                            ${{ product.price }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div
                        class="bg-gray-800 border border-yellow-400 rounded-lg"
                    >
                        <div class="p-4 border-b border-yellow-400">
                            <h3 class="text-yellow-400 text-lg font-bold">
                                Recent Orders
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="space-y-4">
                                <div
                                    v-for="order in recentOrders"
                                    :key="order.id"
                                    class="flex items-center gap-4 p-3 bg-gray-900 rounded-lg border border-yellow-400/30 hover:border-yellow-400 transition-colors"
                                >
                                    <div class="flex-1 min-w-0">
                                        <Link
                                            :href="
                                                route('orders.show', order.id)
                                            "
                                            class="text-yellow-400 font-medium hover:text-yellow-300 transition-colors"
                                        >
                                            Order #{{ order.id }}
                                        </Link>
                                        <p class="text-sm text-blue-300">
                                            {{ order.product.name }}
                                        </p>
                                        <p
                                            class="text-sm text-yellow-400 font-medium"
                                        >
                                            ${{ order.total }}
                                        </p>
                                        <span
                                            :class="{
                                                'text-green-400':
                                                    order.status ===
                                                    'completed',
                                                'text-yellow-400':
                                                    order.status === 'pending',
                                            }"
                                            class="text-xs font-medium"
                                        >
                                            {{ order.status }}
                                        </span>
                                    </div>
                                </div>
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
