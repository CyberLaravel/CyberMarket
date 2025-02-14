<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Pencil, ArrowLeft } from "lucide-vue-next";

defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <Head :title="product.data.name" />

        <template #headerTitle>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link :href="route('products.index')">
                        <Button
                            variant="outline"
                            class="flex items-center gap-2"
                        >
                            <ArrowLeft class="h-4 w-4" />
                            Back to Products
                        </Button>
                    </Link>
                    <h2 class="text-2xl font-bold">{{ product.data.name }}</h2>
                </div>

                <Link :href="route('products.edit', product.data.id)">
                    <Button variant="outline" class="flex items-center gap-2">
                        <Pencil class="h-4 w-4" />
                        Edit Product
                    </Button>
                </Link>
            </div>
        </template>

        <template #headerDescription>
            Product Details and Information
        </template>

        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Image -->
                <Card>
                    <CardContent class="pt-6">
                        <div
                            class="aspect-square w-full relative rounded-lg overflow-hidden"
                        >
                            <img
                                :src="product.data.image"
                                :alt="product.data.name"
                                class="object-cover w-full h-full"
                                @error="
                                    $event.target.src =
                                        'https://placehold.co/600x600?text=No+Image'
                                "
                            />
                        </div>
                    </CardContent>
                </Card>

                <!-- Product Details -->
                <Card>
                    <CardContent class="pt-6">
                        <div class="space-y-6">
                            <!-- Price -->
                            <div>
                                <h3
                                    class="text-lg font-medium text-muted-foreground"
                                >
                                    Price
                                </h3>
                                <p class="text-3xl font-bold">
                                    ${{
                                        parseFloat(product.data.price).toFixed(
                                            2
                                        )
                                    }}
                                </p>
                            </div>

                            <!-- Description -->
                            <div>
                                <h3
                                    class="text-lg font-medium text-muted-foreground"
                                >
                                    Description
                                </h3>
                                <p class="text-base">
                                    {{ product.data.description }}
                                </p>
                            </div>

                            <!-- Additional Details -->
                            <div class="pt-6 border-t">
                                <dl class="divide-y">
                                    <div class="py-3 flex justify-between">
                                        <dt
                                            class="text-sm font-medium text-muted-foreground"
                                        >
                                            Product ID
                                        </dt>
                                        <dd class="text-sm">
                                            #{{ product.data.id }}
                                        </dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt
                                            class="text-sm font-medium text-muted-foreground"
                                        >
                                            Created
                                        </dt>
                                        <dd class="text-sm">
                                            {{
                                                new Date(
                                                    product.data.created_at
                                                ).toLocaleDateString()
                                            }}
                                        </dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt
                                            class="text-sm font-medium text-muted-foreground"
                                        >
                                            Last Updated
                                        </dt>
                                        <dd class="text-sm">
                                            {{
                                                new Date(
                                                    product.data.updated_at
                                                ).toLocaleDateString()
                                            }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>

        <template #footerContent>
            <div class="flex justify-end">
                <Button
                    variant="destructive"
                    @click="
                        $inertia.delete(
                            route('products.destroy', product.data.id)
                        )
                    "
                    class="flex items-center gap-2"
                >
                    Delete Product
                </Button>
            </div>
        </template>
    </AppLayout>
</template>
