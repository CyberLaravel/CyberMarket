<script setup>
import { router, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Button } from "@/Components/ui/button";
import { toast } from "@/Components/ui/toast";
import { Link } from "@inertiajs/vue3";
import { ArrowLeft, X, Star } from "lucide-vue-next";
import { Card, CardContent } from "@/Components/ui/card";
import { computed, onBeforeUnmount, ref } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const HOST = import.meta.env.VITE_STORAGE_HOST || "http://localhost:9000";
const BUCKET = import.meta.env.VITE_STORAGE_BUCKET || "glitchmart";

const getImageUrl = (imagePath) => {
    if (imagePath) {
        const cleanPath = imagePath.replace(/^\/+/, "");
        return `${HOST}/${BUCKET}/${cleanPath}`;
    }
    return null;
};

const form = useForm({
    name: props.product.data.name,
    description: props.product.data.description,
    price: props.product.data.price,
    images: [],
    _method: "PUT",
});

const aaa = ref([]);

const handleImageUpload = (event) => {
    event.preventDefault();
    const files =
        event.type === "drop"
            ? Array.from(event.dataTransfer.files)
            : Array.from(event.target.files);

    // Filter for only image files
    const imageFiles = files.filter((file) => file.type.startsWith("image/"));

    // Add new files to existing form.images array
    form.images = [...form.images, ...imageFiles];
    aaa.value = form.images;

    // Reset the input value to allow selecting the same file again
    if (event.target.type === "file") {
        event.target.value = "";
    }
};

const deleteImage = (imageId) => {
    if (confirm("Are you sure you want to delete this image?")) {
        const isPrimaryImage = imageId === props.product.data.primary_image_id;
        const remainingImages = props.product.data.images.filter(
            (img) => img.id !== imageId
        );

        router.delete(route("product-images.destroy", imageId), {
            onSuccess: () => {
                toast({
                    title: "Success",
                    description: "Image deleted successfully",
                });

                // If we deleted the primary image and there are remaining images,
                // automatically set the first remaining image as primary
                if (isPrimaryImage && remainingImages.length > 0) {
                    setPrimaryImage(remainingImages[0].id);
                }
            },
            onError: () => {
                toast({
                    title: "Error",
                    description: "Failed to delete image",
                    variant: "destructive",
                });
            },
        });
    }
};

const setPrimaryImage = (imageId) => {
    router.patch(route("product-images.set-primary", imageId), {
        onSuccess: () => {
            toast({
                title: "Success",
                description: "Primary image updated successfully",
            });
        },
        onError: () => {
            toast({
                title: "Error",
                description: "Failed to update primary image",
                variant: "destructive",
            });
        },
    });
};

const submit = () => {
    // The form data will include:
    // - form.images: new images to be uploaded
    // - Existing images remain untouched in the database
    form.post(route("products.update", props.product.data.id), {
        onSuccess: () => {
            toast({
                title: "Success",
                description: "Product has been updated successfully",
            });
            // Clear the new uploads after successful submission
            form.images = [];
        },
        onError: () => {
            toast({
                title: "Error",
                description: "Failed to update product. Please try again.",
                variant: "destructive",
            });
        },
        preserveScroll: true,
    });
};

const sortedImages = computed(() => {
    if (!props.product.data.images) return [];
    return [...props.product.data.images].sort((a, b) => {
        if (a.id === props.product.data.primary_image_id) return -1;
        if (b.id === props.product.data.primary_image_id) return 1;
        return 0;
    });
});

const previewUrls = computed(() => {
    return form.images.map((file) => {
        try {
            return URL.createObjectURL(file);
        } catch (e) {
            return null;
        }
    });
});

// Cleanup object URLs when component is destroyed
onBeforeUnmount(() => {
    form.images.forEach((file) => {
        URL.revokeObjectURL(URL.createObjectURL(file));
    });
});
</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-6">
                    <Link :href="route('products.show', product.data.id)">
                        <Button
                            variant="outline"
                            class="flex items-center gap-3 bg-gray-900 border-yellow-400 text-yellow-400 hover:bg-gray-800 hover:text-blue-300 hover:border-blue-300 transition-all duration-300"
                        >
                            <ArrowLeft class="h-5 w-5" />
                            Back to Product
                        </Button>
                    </Link>
                    <h2
                        class="text-3xl font-bold text-yellow-400 font-orbitron glitch-text"
                    >
                        Edit Product
                    </h2>
                </div>
            </div>

            <p class="text-gray-100 font-orbitron mb-8">
                Update the details for "{{ product.data.name }}"
            </p>

            <div class="mb-8">
                <form @submit.prevent="submit" class="space-y-8">
                    <Card
                        class="bg-gray-900 border border-yellow-400 hover:shadow-neon transition-all duration-300"
                    >
                        <CardContent class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Product Name -->
                                <div class="space-y-2">
                                    <Label
                                        for="name"
                                        class="text-blue-300 font-orbitron"
                                        >Product Name</Label
                                    >
                                    <Input
                                        id="name"
                                        v-model="form.name"
                                        placeholder="Enter product name"
                                        :error="form.errors.name"
                                        required
                                        class="bg-gray-800 border-yellow-400 text-gray-100 placeholder:text-gray-500 focus:border-blue-300 focus:ring-blue-300"
                                    />
                                    <span
                                        v-if="form.errors.name"
                                        class="text-sm text-red-400"
                                    >
                                        {{ form.errors.name }}
                                    </span>
                                </div>

                                <!-- Price -->
                                <div class="space-y-2">
                                    <Label
                                        for="price"
                                        class="text-blue-300 font-orbitron"
                                        >Price</Label
                                    >
                                    <Input
                                        id="price"
                                        v-model="form.price"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        placeholder="Enter price"
                                        :error="form.errors.price"
                                        required
                                        class="bg-gray-800 border-yellow-400 text-gray-100 placeholder:text-gray-500 focus:border-blue-300 focus:ring-blue-300"
                                    />
                                    <span
                                        v-if="form.errors.price"
                                        class="text-sm text-red-400"
                                    >
                                        {{ form.errors.price }}
                                    </span>
                                </div>
                            </div>

                            <!-- Product Images Section -->
                            <div class="space-y-2 mt-8">
                                <!-- Existing Database Images -->
                                <div class="mb-4">
                                    <h3
                                        class="text-blue-300 font-orbitron mb-4"
                                    >
                                        Current Images
                                    </h3>
                                    <div
                                        class="grid grid-cols-3 md:grid-cols-6 gap-4"
                                    >
                                        <div
                                            v-for="image in sortedImages"
                                            :key="image.id"
                                            class="relative group"
                                        >
                                            <div
                                                v-if="
                                                    getImageUrl(
                                                        image.image_path
                                                    )
                                                "
                                                class="w-full aspect-square"
                                            >
                                                <img
                                                    :src="
                                                        getImageUrl(
                                                            image.image_path
                                                        )
                                                    "
                                                    :alt="product.data.name"
                                                    class="w-full h-full object-cover rounded-lg border border-yellow-400"
                                                />
                                            </div>
                                            <div
                                                v-else
                                                class="w-full aspect-square rounded-lg border border-yellow-400 bg-gray-800 flex items-center justify-center"
                                            >
                                                <span
                                                    class="text-yellow-400 text-sm font-orbitron"
                                                    >No Image</span
                                                >
                                            </div>

                                            <!-- Primary Badge -->
                                            <span
                                                v-if="
                                                    image.id ===
                                                    product.data
                                                        .primary_image_id
                                                "
                                                class="absolute top-2 left-2 px-2 py-1 bg-yellow-400 text-black text-xs rounded-md font-orbitron"
                                            >
                                                Primary
                                            </span>
                                            <div
                                                class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                            >
                                                <!-- Set as Primary button -->
                                                <button
                                                    type="button"
                                                    @click="
                                                        setPrimaryImage(
                                                            image.id
                                                        )
                                                    "
                                                    class="p-1 bg-gray-900 rounded-full border border-yellow-400 text-yellow-400 hover:border-blue-300 hover:text-blue-300 transition-colors duration-200"
                                                    :class="{
                                                        'opacity-50 cursor-not-allowed':
                                                            image.id ===
                                                            product.data
                                                                .primary_image_id,
                                                    }"
                                                    :disabled="
                                                        image.id ===
                                                        product.data
                                                            .primary_image_id
                                                    "
                                                    title="Set as primary"
                                                >
                                                    <Star class="h-4 w-4" />
                                                </button>
                                                <!-- Delete button -->
                                                <button
                                                    type="button"
                                                    @click="
                                                        deleteImage(image.id)
                                                    "
                                                    class="p-1 bg-gray-900 rounded-full border border-red-400 text-red-400 transition-colors duration-200"
                                                    title="Delete image"
                                                >
                                                    <X class="h-4 w-4" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- New Uploads Preview -->
                                <div v-if="form.images.length > 0" class="mb-4">
                                    <h3
                                        class="text-blue-300 font-orbitron mb-4"
                                    >
                                        New Uploads
                                    </h3>
                                    <div
                                        class="grid grid-cols-3 md:grid-cols-6 gap-4"
                                    >
                                        <div
                                            v-for="(file, index) in form.images"
                                            :key="index"
                                            class="relative group"
                                        >
                                            <div
                                                class="w-full aspect-square relative"
                                            >
                                                <img
                                                    v-if="previewUrls[index]"
                                                    :src="previewUrls[index]"
                                                    :alt="file.name"
                                                    class="w-full h-full object-cover rounded-lg border-2 border-blue-300"
                                                />
                                            </div>
                                            <button
                                                type="button"
                                                @click="
                                                    form.images =
                                                        form.images.filter(
                                                            (_, i) =>
                                                                i !== index
                                                        )
                                                "
                                                class="absolute top-2 right-2 p-1 bg-gray-900 rounded-full border border-red-400 text-red-400 hover:bg-red-400 hover:text-gray-900 transition-colors duration-200"
                                                title="Remove from upload"
                                            >
                                                <X class="h-4 w-4" />
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload Area -->
                                <div class="mt-4">
                                    <div
                                        class="border-2 border-dashed border-yellow-400 rounded-lg p-8 text-center hover:border-blue-300 transition-colors duration-300"
                                        @dragover.prevent
                                        @drop.prevent="handleImageUpload"
                                    >
                                        <input
                                            type="file"
                                            id="images"
                                            multiple
                                            class="hidden"
                                            @change="handleImageUpload"
                                            accept="image/*"
                                        />
                                        <label
                                            for="images"
                                            class="cursor-pointer flex flex-col items-center justify-center gap-2"
                                        >
                                            <div
                                                class="text-yellow-400 hover:text-blue-300 transition-colors duration-300"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-12 w-12"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-gray-100 font-orbitron"
                                            >
                                                Drag and drop your images here,
                                                or click to select files
                                            </span>
                                            <span
                                                class="text-sm text-gray-400 font-orbitron"
                                            >
                                                Upload new images. The first
                                                image will be set as primary if
                                                none exists.
                                            </span>
                                        </label>
                                    </div>
                                    <span
                                        v-if="form.errors.images"
                                        class="text-sm text-red-400 mt-2 block"
                                    >
                                        {{ form.errors.images }}
                                    </span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2 mt-8">
                                <Label
                                    for="description"
                                    class="text-blue-300 font-orbitron"
                                    >Description</Label
                                >
                                <Textarea
                                    id="description"
                                    v-model="form.description"
                                    placeholder="Enter product description"
                                    :error="form.errors.description"
                                    required
                                    rows="4"
                                    class="bg-gray-800 border-yellow-400 text-gray-100 placeholder:text-gray-500 focus:border-blue-300 focus:ring-blue-300"
                                />
                                <span
                                    v-if="form.errors.description"
                                    class="text-sm text-red-400"
                                >
                                    {{ form.errors.description }}
                                </span>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4">
                        <Button
                            type="button"
                            variant="outline"
                            @click="
                                $inertia.visit(
                                    route('products.show', product.data.id)
                                )
                            "
                            class="bg-gray-900 border-yellow-400 text-yellow-400 hover:bg-gray-800 hover:text-blue-300 hover:border-blue-300 transition-all duration-300"
                        >
                            Cancel
                        </Button>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-yellow-400 text-gray-900 hover:bg-yellow-300 transition-all duration-300 font-orbitron"
                        >
                            {{
                                form.processing
                                    ? "Updating..."
                                    : "Update Product"
                            }}
                        </Button>
                    </div>
                </form>
            </div>

            <p class="text-sm text-blue-300 font-orbitron pt-4 pb-8">
                Last updated:
                {{ new Date(product.data.updated_at).toLocaleDateString() }}
            </p>
        </div>
    </AppLayout>
</template>
