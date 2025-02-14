<script setup>
import { computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useCartStore } from "@/Stores/useCartStore";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Button } from "@/Components/ui/button";
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardFooter,
} from "@/Components/ui/card";
import { toast } from "@/Components/ui/toast";
import { Trash2, Minus, Plus, ArrowLeft } from "lucide-vue-next";

const cart = useCartStore();

const subtotal = computed(() => cart.cartTotal);
const tax = computed(() => subtotal.value * 0.1); // 10% tax
const total = computed(() => subtotal.value + tax.value);

const form = useForm({
    shipping_details: {
        full_name: "",
        email: "",
        phone: "",
        address: "",
        city: "",
        state: "",
        postal_code: "",
        country: "",
    },
    cart_items: cart.items,
    subtotal: subtotal.value,
    tax: tax.value,
    total: total.value,
});

const updateQuantity = (productId, newQuantity) => {
    cart.updateQuantity(productId, newQuantity);
};

const removeItem = (productId) => {
    cart.removeFromCart(productId);
};

const handleCheckout = () => {
    form.post(route("checkout.process"), {
        onSuccess: () => {
            cart.clearCart();
            toast({
                title: "Success",
                description: "Your order has been placed successfully!",
            });
        },
        onError: () => {
            toast({
                title: "Error",
                description:
                    "There was an error processing your order. Please try again.",
                variant: "destructive",
            });
        },
    });
};
</script>

<template>
    <AppLayout>
        <template #headerTitle>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Button
                        variant="outline"
                        @click="$inertia.visit(route('products.index'))"
                        class="flex items-center gap-2"
                    >
                        <ArrowLeft class="h-4 w-4" />
                        Continue Shopping
                    </Button>
                    <h2 class="text-2xl font-bold">Checkout</h2>
                </div>
            </div>
        </template>

        <template #headerDescription> Complete your purchase </template>

        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Summary -->
                <div class="lg:col-span-2 space-y-4">
                    <Card v-if="cart.items.length">
                        <CardHeader>
                            <CardTitle>Shopping Cart</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div
                                v-for="item in cart.items"
                                :key="item.id"
                                class="flex items-center gap-4 py-4 border-b last:border-0"
                            >
                                <div
                                    class="h-20 w-20 relative rounded overflow-hidden flex-shrink-0"
                                >
                                    <img
                                        :src="item.image"
                                        :alt="item.name"
                                        class="object-cover w-full h-full"
                                        @error="
                                            $event.target.src =
                                                'https://placehold.co/600x600?text=No+Image'
                                        "
                                    />
                                </div>
                                <div class="flex-grow">
                                    <h3 class="font-medium">{{ item.name }}</h3>
                                    <p class="text-muted-foreground">
                                        ${{ parseFloat(item.price).toFixed(2) }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        @click="
                                            updateQuantity(
                                                item.id,
                                                item.quantity - 1
                                            )
                                        "
                                    >
                                        <Minus class="h-4 w-4" />
                                    </Button>
                                    <span class="w-8 text-center">{{
                                        item.quantity
                                    }}</span>
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        @click="
                                            updateQuantity(
                                                item.id,
                                                item.quantity + 1
                                            )
                                        "
                                    >
                                        <Plus class="h-4 w-4" />
                                    </Button>
                                    <Button
                                        variant="destructive"
                                        size="icon"
                                        @click="removeItem(item.id)"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                    <Card v-else>
                        <CardContent class="p-6 text-center">
                            <p class="text-muted-foreground">
                                Your cart is empty
                            </p>
                            <Button
                                variant="outline"
                                class="mt-4"
                                @click="$inertia.visit(route('products.index'))"
                            >
                                Continue Shopping
                            </Button>
                        </CardContent>
                    </Card>
                </div>

                <!-- Order Summary and Shipping Form -->
                <div class="space-y-4">
                    <Card>
                        <CardHeader>
                            <CardTitle>Order Summary</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-muted-foreground"
                                    >Subtotal</span
                                >
                                <span>${{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-muted-foreground"
                                    >Tax (10%)</span
                                >
                                <span>${{ tax.toFixed(2) }}</span>
                            </div>
                            <div
                                class="flex justify-between font-bold border-t pt-4"
                            >
                                <span>Total</span>
                                <span>${{ total.toFixed(2) }}</span>
                            </div>
                        </CardContent>
                    </Card>

                    <Card v-if="cart.items.length">
                        <CardHeader>
                            <CardTitle>Shipping Information</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <form
                                @submit.prevent="handleCheckout"
                                class="space-y-4"
                            >
                                <div class="space-y-2">
                                    <Label for="full_name">Full Name</Label>
                                    <Input
                                        id="full_name"
                                        v-model="
                                            form.shipping_details.full_name
                                        "
                                        required
                                    />
                                </div>

                                <div class="space-y-2">
                                    <Label for="email">Email</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        v-model="form.shipping_details.email"
                                        required
                                    />
                                </div>

                                <div class="space-y-2">
                                    <Label for="phone">Phone</Label>
                                    <Input
                                        id="phone"
                                        v-model="form.shipping_details.phone"
                                        required
                                    />
                                </div>

                                <div class="space-y-2">
                                    <Label for="address">Address</Label>
                                    <Input
                                        id="address"
                                        v-model="form.shipping_details.address"
                                        required
                                    />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <Label for="city">City</Label>
                                        <Input
                                            id="city"
                                            v-model="form.shipping_details.city"
                                            required
                                        />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="state">State</Label>
                                        <Input
                                            id="state"
                                            v-model="
                                                form.shipping_details.state
                                            "
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <Label for="postal_code"
                                            >Postal Code</Label
                                        >
                                        <Input
                                            id="postal_code"
                                            v-model="
                                                form.shipping_details
                                                    .postal_code
                                            "
                                            required
                                        />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="country">Country</Label>
                                        <Input
                                            id="country"
                                            v-model="
                                                form.shipping_details.country
                                            "
                                            required
                                        />
                                    </div>
                                </div>

                                <Button
                                    type="submit"
                                    class="w-full"
                                    :disabled="form.processing"
                                >
                                    {{
                                        form.processing
                                            ? "Processing..."
                                            : "Place Order"
                                    }}
                                </Button>
                            </form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
