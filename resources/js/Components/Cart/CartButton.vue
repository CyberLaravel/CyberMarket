<script setup>
import { Button } from "@/Components/ui/button";
import { ShoppingCart } from "lucide-vue-next";
import { useCartStore } from "@/Stores/useCartStore";
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/Components/ui/sheet";

const cart = useCartStore();
</script>

<template>
    <Sheet>
        <SheetTrigger asChild>
            <Button variant="ghost" class="relative">
                <ShoppingCart class="h-5 w-5 icon-primary" />
                <span
                    class="badge-primary absolute -top-1 -right-1 h-4 w-4 rounded-full text-xs flex items-center justify-center"
                >
                    {{ cart.cartCount }}
                </span>
            </Button>
        </SheetTrigger>
        <SheetContent class="sheet-content">
            <SheetHeader>
                <SheetTitle class="sheet-title">Shopping Cart</SheetTitle>
            </SheetHeader>
            <div class="mt-4 space-y-4">
                <div v-if="cart.items.length === 0" class="text-center py-6">
                    <p class="text-muted-foreground">Your cart is empty</p>
                </div>
                <div v-else>
                    <div
                        v-for="item in cart.items"
                        :key="item.id"
                        class="flex items-center gap-4 py-4 border-b"
                    >
                        <img
                            :src="item.image"
                            :alt="item.name"
                            class="w-16 h-16 object-cover rounded"
                        />
                        <div class="flex-1">
                            <h3 class="font-medium">{{ item.name }}</h3>
                            <p class="text-sm text-muted-foreground">
                                ${{ item.price }}
                            </p>
                            <div class="flex items-center gap-2 mt-2">
                                <Button
                                    variant="outline"
                                    size="icon"
                                    @click="
                                        cart.updateQuantity(
                                            item.id,
                                            item.quantity - 1
                                        )
                                    "
                                >
                                    -
                                </Button>
                                <span>{{ item.quantity }}</span>
                                <Button
                                    variant="outline"
                                    size="icon"
                                    @click="
                                        cart.updateQuantity(
                                            item.id,
                                            item.quantity + 1
                                        )
                                    "
                                >
                                    +
                                </Button>
                            </div>
                        </div>
                        <Button
                            variant="destructive"
                            size="icon"
                            @click="cart.removeFromCart(item.id)"
                        >
                            ×
                        </Button>
                    </div>
                    <div class="pt-4">
                        <div class="flex justify-between mb-4">
                            <span class="font-medium">Total:</span>
                            <span class="font-medium"
                                >${{ cart.cartTotal.toFixed(2) }}</span
                            >
                        </div>
                        <Button
                            class="w-full"
                            @click="
                                $inertia.post('/checkout', {
                                    items: cart.items,
                                })
                            "
                        >
                            Checkout
                        </Button>
                    </div>
                </div>
            </div>
        </SheetContent>
    </Sheet>
</template>
