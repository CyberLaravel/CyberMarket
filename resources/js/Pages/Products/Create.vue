<script setup>
import { ref, computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { toast } from "@/Components/ui/toast";
import { XIcon, PencilIcon } from "lucide-vue-next";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Button } from "@/Components/ui/button";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { Card, CardContent } from "@/Components/ui/card";
import DragDropZone from "@/Components/ui/drag-drop-zone/DragDropZone.vue";
import ImagePreview from "@/Components/ui/image-preview/ImagePreview.vue";

const props = defineProps({
    categories: Array,
});

const form = useForm({
    name: "",
    description: "",
    price: "",
    images: [],
    primary_image_index: 0,
    category_id: "",
    slug: "",
});

const isEditingSlug = ref(false);

const toggleSlugEdit = () => {
    isEditingSlug.value = !isEditingSlug.value;
};

const generateSlug = (value) => {
    return value
        .toLowerCase()
        .replace(/[^\w\s-]/g, "")
        .replace(/\s+/g, "-")
        .replace(/-+/g, "-")
        .trim();
};

watch(
    () => form.name,
    (newValue) => {
        if (!isEditingSlug.value) {
            form.slug = generateSlug(newValue);
        }
    }
);

const submit = () => {
    form.post("/products", {
        onSuccess: () => {
            form.reset();
            form.images = [];
            toast({
                title: "Success",
                description: "Product has been added successfully",
            });
        },
        onError: () => {
            toast({
                title: "Error",
                description: "Failed to add product. Please try again.",
                variant: "destructive",
            });
        },
        preserveScroll: true,
        preserveState: true,
    });
};

const previewImages = computed(() => {
    const images = form.images.map((image, index) => ({
        id: URL.createObjectURL(image),
        file: image,
        index,
    }));

    return images.sort((a, b) => {
        if (a.index === form.primary_image_index) return -1;
        if (b.index === form.primary_image_index) return 1;
        return a.index - b.index;
    });
});

const removeImage = (index) => {
    form.images.splice(index, 1);
    if (index === form.primary_image_index) {
        form.primary_image_index = 0;
    } else if (index < form.primary_image_index) {
        form.primary_image_index--;
    }
};
</script>

<template>
    <AppLayout title="Create Product">
        <!-- Header Content -->
        <div class="mt-6 mb-8 space-y-2">
            <h1
                class="text-yellow-400 text-2xl font-bold font-orbitron text-center"
            >
                Create New Product
            </h1>
            <p class="text-blue-300 text-center">
                Add a new product to your inventory
            </p>
        </div>

        <!-- Main Content -->
        <div class="py-4 px-4 sm:px-6 lg:px-8">
            <form @submit.prevent="submit" class="space-y-8 max-w-4xl mx-auto">
                <Card
                    class="bg-gray-900 border-2 border-yellow-400 shadow-[0_0_15px_rgba(250,204,21,0.3)] transition-all duration-300 hover:shadow-[0_0_25px_rgba(250,204,21,0.4)]"
                >
                    <CardContent class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <Label for="name" class="text-blue-300"
                                    >Product Name</Label
                                >
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    placeholder="Enter product name"
                                    :error="form.errors.name"
                                    class="bg-gray-800 border-yellow-400 text-gray-100 placeholder:text-gray-500 focus:border-blue-300 focus:ring-blue-300"
                                />
                            </div>

                            <div class="space-y-2">
                                <Label for="slug" class="text-blue-300"
                                    >URL Slug</Label
                                >
                                <div class="relative">
                                    <Input
                                        id="slug"
                                        v-model="form.slug"
                                        placeholder="product-url-slug"
                                        :error="form.errors.slug"
                                        required
                                        :disabled="!isEditingSlug"
                                        class="pr-12 bg-gray-800 border-yellow-400 text-gray-100 placeholder:text-gray-500 focus:border-blue-300 focus:ring-blue-300"
                                    />
                                    <Button
                                        type="button"
                                        @click="toggleSlugEdit"
                                        variant="ghost"
                                        class="absolute right-2 top-1/2 -translate-y-1/2"
                                        :class="
                                            isEditingSlug
                                                ? 'text-yellow-400'
                                                : 'text-blue-300'
                                        "
                                    >
                                        <span v-if="isEditingSlug">Done</span>
                                        <PencilIcon v-else class="w-4 h-4" />
                                    </Button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <Label for="price" class="text-blue-300"
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
                                    class="bg-gray-800 border-yellow-400 text-gray-100 placeholder:text-gray-500 focus:border-blue-300 focus:ring-blue-300"
                                />
                            </div>
                        </div>

                        <div class="space-y-2 mt-6">
                            <Label for="description" class="text-blue-300"
                                >Description</Label
                            >
                            <Textarea
                                id="description"
                                v-model="form.description"
                                placeholder="Enter product description"
                                :error="form.errors.description"
                                rows="4"
                                class="bg-gray-800 border-yellow-400 text-gray-100 placeholder:text-gray-500 focus:border-blue-300 focus:ring-blue-300"
                            />
                        </div>

                        <div class="space-y-2 mt-6">
                            <Label for="category" class="text-blue-300"
                                >Category</Label
                            >
                            <Select
                                v-model="form.category_id"
                                :error="form.errors.category_id"
                            >
                                <SelectTrigger
                                    class="w-full bg-gray-800 border-yellow-400 text-gray-100 placeholder:text-gray-500 focus:border-blue-300 focus:ring-blue-300"
                                >
                                    <SelectValue
                                        placeholder="Select Category"
                                    />
                                </SelectTrigger>
                                <SelectContent
                                    class="bg-gray-800 border border-yellow-400"
                                >
                                    <SelectItem
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                        class="text-gray-100 hover:bg-gray-700 hover:text-blue-300 focus:bg-gray-700 focus:text-blue-300"
                                    >
                                        {{ category.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <div class="space-y-2 mt-6">
                            <Label for="images" class="text-blue-300"
                                >Product Images</Label
                            >
                            <DragDropZone
                                @filesSelected="
                                    (files) => form.images.push(...files)
                                "
                                accept="image/*"
                                multiple
                                supportedFormats="JPG, PNG, GIF"
                                :error="form.errors.images"
                            />
                            <p
                                v-if="form.errors.images"
                                class="text-red-400 text-sm mt-1"
                            >
                                {{ form.errors.images }}
                            </p>
                        </div>

                        <div class="mt-4">
                            <ImagePreview
                                v-if="previewImages.length"
                                :images="previewImages"
                                v-model:primaryIndex="form.primary_image_index"
                                @removeImage="removeImage"
                            />
                        </div>

                        <div class="flex justify-end mt-8 space-x-4">
                            <Button
                                @click="$inertia.get('/products')"
                                variant="outline"
                                class="border-yellow-400 text-blue-300 hover:bg-gray-800 hover:text-yellow-400"
                            >
                                Cancel
                            </Button>
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                :class="{ 'opacity-50': form.processing }"
                                class="bg-yellow-400 text-black hover:bg-yellow-300"
                            >
                                {{
                                    form.processing
                                        ? "Adding..."
                                        : "Add Product"
                                }}
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </form>
        </div>

        <!-- Footer Content -->
        <div class="mt-8 mb-6">
            <p class="text-blue-300 text-sm text-center">
                All products will be reviewed before being published.
            </p>
        </div>
    </AppLayout>
</template>

<style scoped>
.primary-image-indicator {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0));
    backdrop-filter: blur(2px);
}
</style>
