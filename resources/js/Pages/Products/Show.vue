<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button } from "@/Components/ui/button";
import { Card, CardContent } from "@/Components/ui/card";
import { Pencil, ArrowLeft, Trash2 } from "lucide-vue-next";
import { ref } from "vue";
import { getImageUrl } from "@/utils/imageUtils";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    isSeller: {
        type: Boolean,
        default: false,
    },
});

const selectedImage = ref(props.product.data.primary_image);
</script>

<template>
    <AppLayout>
        <Head :title="product.data.name" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <Link :href="route('products.index')">
                        <Button
                            variant="outline"
                            class="flex items-center gap-2 bg-gray-900 border-yellow-400 text-yellow-400 hover:bg-gray-800 hover:text-blue-300 hover:border-blue-300 transition-all duration-300"
                        >
                            <ArrowLeft class="h-5 w-5" />
                            Back to Products
                        </Button>
                    </Link>
                    <h2
                        class="text-3xl font-bold text-yellow-400 font-orbitron glitch-text"
                    >
                        {{ product.data.name }}
                    </h2>
                </div>

                <div v-if="isSeller" class="flex items-center gap-3">
                    <Link :href="route('products.edit', product.data.id)">
                        <Button
                            variant="outline"
                            class="flex items-center gap-2 bg-gray-900 border-yellow-400 text-yellow-400 hover:bg-gray-800 hover:text-blue-300 hover:border-blue-300 transition-all duration-300"
                        >
                            <Pencil class="h-5 w-5" />
                            Edit Product
                        </Button>
                    </Link>
                    <Button
                        variant="destructive"
                        @click="
                            $inertia.delete(
                                route('products.destroy', product.data.id)
                            )
                        "
                        class="flex items-center gap-2 bg-gray-900 border-red-400 text-red-400 hover:bg-gray-800 hover:text-red-300 hover:border-red-300 transition-all duration-300 shadow-neon-red"
                    >
                        <Trash2 class="h-5 w-5" />
                        Delete Product
                    </Button>
                </div>
            </div>

            <p class="text-gray-100 font-orbitron mb-4">
                Product Details and Information
            </p>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl mx-auto"
            >
                <!-- Product Images -->
                <Card
                    class="bg-gray-900 border border-yellow-400 hover:shadow-neon transition-all duration-300"
                >
                    <CardContent class="p-6 space-y-4">
                        <!-- Main Image Display -->
                        <div
                            class="aspect-square w-full relative rounded-lg overflow-hidden border border-yellow-400"
                        >
                            <img
                                :src="getImageUrl(selectedImage)"
                                :alt="product.data.name"
                                class="object-cover w-full h-full"
                            />
                        </div>

                        <!-- Thumbnail Gallery -->
                        <div class="grid grid-cols-6 gap-3">
                            <!-- Primary Image Thumbnail -->

                            <div
                                @click="
                                    selectedImage = product.data.primary_image
                                "
                                class="aspect-square cursor-pointer relative rounded-lg overflow-hidden border-2 transition-all duration-300"
                                :class="[
                                    selectedImage === product.data.primary_image
                                        ? 'border-blue-300 shadow-neon-blue ring-2 ring-blue-300 ring-offset-2 ring-offset-gray-900'
                                        : 'border-yellow-400 hover:border-blue-300 hover:shadow-neon-blue',
                                ]"
                            >
                                <img
                                    :src="
                                        getImageUrl(product.data.primary_image)
                                    "
                                    :alt="product.data.name"
                                    class="object-cover w-full h-full hover:scale-110 transition-transform duration-300"
                                />
                                <span
                                    class="absolute top-1 left-1 px-1.5 py-0.5 bg-yellow-400 text-black text-xs rounded font-orbitron"
                                >
                                    Primary
                                </span>
                            </div>

                            <!-- Other Images Thumbnails -->
                            <div
                                v-for="image in product.data.images.filter(
                                    (img) =>
                                        img.image_path !==
                                        product.data.primary_image
                                )"
                                :key="image.id"
                                @click="selectedImage = image.image_path"
                                class="aspect-square cursor-pointer rounded-lg overflow-hidden border-2 transition-all duration-300"
                                :class="[
                                    selectedImage === image.image_path
                                        ? 'border-blue-300 shadow-neon-blue ring-2 ring-blue-300 ring-offset-2 ring-offset-gray-900'
                                        : 'border-yellow-400 hover:border-blue-300 hover:shadow-neon-blue',
                                ]"
                            >
                                <img
                                    :src="getImageUrl(image.image_path)"
                                    :alt="product.data.name"
                                    class="object-cover w-full h-full hover:scale-110 transition-transform duration-300"
                                />
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Product Details -->
                <Card
                    class="bg-gray-900 border border-yellow-400 hover:shadow-neon transition-all duration-300 h-fit"
                >
                    <CardContent class="p-6">
                        <div class="space-y-6">
                            <!-- Price -->
                            <div class="space-y-2">
                                <h3
                                    class="text-lg font-medium text-blue-300 font-orbitron"
                                >
                                    Price
                                </h3>
                                <p
                                    class="text-4xl font-bold text-yellow-400 font-orbitron"
                                >
                                    ${{
                                        parseFloat(product.data.price).toFixed(
                                            2
                                        )
                                    }}
                                </p>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <h3
                                    class="text-lg font-medium text-blue-300 font-orbitron"
                                >
                                    Description
                                </h3>
                                <p
                                    class="text-gray-100 text-base font-orbitron leading-relaxed"
                                >
                                    {{ product.data.description }}
                                </p>
                            </div>

                            <!-- Additional Details -->
                            <div class="pt-6 border-t border-yellow-400">
                                <dl class="divide-y divide-yellow-400/30">
                                    <div class="py-4 flex justify-between">
                                        <dt
                                            class="text-sm font-medium text-blue-300 font-orbitron"
                                        >
                                            Product ID
                                        </dt>
                                        <dd
                                            class="text-sm text-yellow-400 font-orbitron"
                                        >
                                            #{{ product.data.id }}
                                        </dd>
                                    </div>
                                    <div class="py-4 flex justify-between">
                                        <dt
                                            class="text-sm font-medium text-blue-300 font-orbitron"
                                        >
                                            Created
                                        </dt>
                                        <dd
                                            class="text-sm text-yellow-400 font-orbitron"
                                        >
                                            {{
                                                new Date(
                                                    product.data.created_at
                                                ).toLocaleDateString()
                                            }}
                                        </dd>
                                    </div>
                                    <div class="py-4 flex justify-between">
                                        <dt
                                            class="text-sm font-medium text-blue-300 font-orbitron"
                                        >
                                            Last Updated
                                        </dt>
                                        <dd
                                            class="text-sm text-yellow-400 font-orbitron"
                                        >
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
    </AppLayout>
</template>

<style scoped>
.shadow-neon-blue {
    box-shadow: 0 0 15px rgba(147, 197, 253, 0.5);
}

.ring-offset-gray-900 {
    --tw-ring-offset-color: #111827;
}
</style>
