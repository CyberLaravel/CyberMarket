<script setup>
import { ShoppingCart } from "lucide-vue-next";
import { useCartStore } from "@/Stores/useCartStore";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const cart = useCartStore();
const isOpen = ref(false);

const toggleCart = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <div class="relative">
        <!-- Cart Button -->
        <button
            @click="toggleCart"
            class="p-2 relative hover:bg-gray-800 rounded-md transition-colors"
        >
            <ShoppingCart
                class="h-5 w-5 text-yellow-400 hover:text-blue-300 transition-colors"
            />
            <span
                class="absolute -top-1 -right-1 h-4 w-4 rounded-full text-xs flex items-center justify-center bg-yellow-400 text-gray-900 border border-yellow-400 shadow-glow"
            >
                {{ cart.cartCount }}
            </span>
        </button>

        <!-- Cart Drawer -->
        <div
            v-if="isOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-50"
            @click="toggleCart"
        ></div>

        <div
            v-if="isOpen"
            class="fixed right-0 top-0 h-full w-96 bg-gray-800 border-l border-yellow-400 shadow-lg z-50 transform transition-transform duration-300"
        >
            <!-- Header -->
            <div class="p-6 border-b border-yellow-400/30">
                <h2 class="text-yellow-400 font-orbitron text-xl glitch-text">
                    Shopping Cart
                </h2>
            </div>

            <!-- Content -->
            <div class="mt-4 p-6 space-y-4">
                <div v-if="cart.items.length === 0" class="text-center py-6">
                    <p class="text-gray-400">Your cart is empty</p>
                </div>
                <div v-else>
                    <div
                        v-for="item in cart.items"
                        :key="item.id"
                        class="flex items-center gap-4 py-4 border-b border-yellow-400/30"
                    >
                        <img
                            :src="item.image"
                            :alt="item.name"
                            class="w-16 h-16 object-cover rounded border border-yellow-400/50"
                        />
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-100">
                                {{ item.name }}
                            </h3>
                            <p class="text-sm text-blue-300">
                                ${{ item.price }}
                            </p>
                            <div class="flex items-center gap-2 mt-2">
                                <button
                                    class="w-8 h-8 flex items-center justify-center border border-yellow-400 text-yellow-400 rounded-md hover:bg-yellow-400 hover:text-gray-900 transition-colors"
                                    @click="
                                        cart.updateQuantity(
                                            item.id,
                                            item.quantity - 1
                                        )
                                    "
                                >
                                    -
                                </button>
                                <span class="text-gray-100">{{
                                    item.quantity
                                }}</span>
                                <button
                                    class="w-8 h-8 flex items-center justify-center border border-yellow-400 text-yellow-400 rounded-md hover:bg-yellow-400 hover:text-gray-900 transition-colors"
                                    @click="
                                        cart.updateQuantity(
                                            item.id,
                                            item.quantity + 1
                                        )
                                    "
                                >
                                    +
                                </button>
                            </div>
                        </div>
                        <button
                            class="w-8 h-8 flex items-center justify-center bg-red-500 hover:bg-red-600 text-gray-100 rounded-md transition-colors"
                            @click="cart.removeFromCart(item.id)"
                        >
                            ×
                        </button>
                    </div>

                    <!-- Total and Checkout -->
                    <div class="pt-4">
                        <div class="flex justify-between mb-4">
                            <span class="font-medium text-gray-100"
                                >Total:</span
                            >
                            <span class="font-medium text-yellow-400"
                                >${{ cart.cartTotal.toFixed(2) }}</span
                            >
                        </div>
                        <Link
                            :href="route('checkout.index')"
                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium h-10 px-4 py-2 bg-yellow-400 text-gray-900 hover:bg-yellow-300 transition-colors shadow-glow"
                        >
                            Checkout
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
