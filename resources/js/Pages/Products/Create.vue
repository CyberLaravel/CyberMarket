<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Button } from "@/Components/ui/button";
import { toast } from "@/Components/ui/toast";
import { XMarkIcon } from "@heroicons/vue/24/solid";
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from "@/Components/ui/select";

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
});

const isDragging = ref(false);

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
    });
};

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    form.images.push(...files);
};

const handleDragOver = (event) => {
    event.preventDefault();
    isDragging.value = true;
};

const handleDragLeave = (event) => {
    event.preventDefault();
    if (event.target.classList.contains("dropzone")) {
        isDragging.value = false;
    }
};

const handleDrop = (event) => {
    event.preventDefault();
    isDragging.value = false;
    const files = Array.from(event.dataTransfer.files);
    form.images.push(...files);
};

const triggerFileInput = () => {
    document.getElementById("images").click();
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

const setPrimaryImage = (index) => {
    form.primary_image_index = index;
};

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
                <div
                    class="bg-gray-900 p-6 rounded-lg border-2 border-yellow-400 shadow-[0_0_15px_rgba(250,204,21,0.3)] transition-all duration-300 hover:shadow-[0_0_25px_rgba(250,204,21,0.4)]"
                >
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label
                                for="name"
                                class="text-yellow-400 font-orbitron"
                                >Product Name</Label
                            >
                            <Input
                                id="name"
                                v-model="form.name"
                                placeholder="Enter product name"
                                :error="form.errors.name"
                                required
                                class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                            />
                            <span
                                v-if="form.errors.name"
                                class="text-red-400 text-sm"
                            >
                                {{ form.errors.name }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            <Label
                                for="price"
                                class="text-yellow-400 font-orbitron"
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
                                class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                            />
                            <span
                                v-if="form.errors.price"
                                class="text-red-400 text-sm"
                            >
                                {{ form.errors.price }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 mt-6">
                        <Label
                            for="description"
                            class="text-yellow-400 font-orbitron"
                            >Description</Label
                        >
                        <Textarea
                            id="description"
                            v-model="form.description"
                            placeholder="Enter product description"
                            :error="form.errors.description"
                            required
                            rows="4"
                            class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400 w-full"
                        />
                        <span
                            v-if="form.errors.description"
                            class="text-red-400 text-sm"
                        >
                            {{ form.errors.description }}
                        </span>
                    </div>

                    <div class="space-y-2 mt-6">
                        <Label
                            for="category_id"
                            class="text-yellow-400 font-orbitron"
                            >Category</Label
                        >
                        <Select
                            v-model="form.category_id"
                            :error="form.errors.category_id"
                        >
                            <SelectTrigger
                                class="bg-gray-800 border-yellow-400 text-gray-100"
                            >
                                <SelectValue placeholder="Select Category" />
                            </SelectTrigger>
                            <SelectContent
                                class="bg-gray-800 border-yellow-400 text-gray-100 shadow-neon"
                            >
                                <SelectItem
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                    class="hover:bg-gray-700 hover:text-yellow-400 focus:bg-gray-700 focus:text-yellow-400"
                                >
                                    {{ category.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div class="space-y-2 mt-6">
                        <Label
                            for="images"
                            class="text-yellow-400 font-orbitron"
                            >Product Images</Label
                        >
                        <div
                            class="dropzone border-2 border-dashed border-yellow-400 p-6 rounded-lg bg-gray-800 text-center cursor-pointer transition-all duration-300 group"
                            :class="{
                                'border-blue-300 bg-gray-700 shadow-[0_0_15px_rgba(147,197,253,0.3)]':
                                    isDragging,
                            }"
                            @drop="handleDrop"
                            @dragover="handleDragOver"
                            @dragleave="handleDragLeave"
                            @click="triggerFileInput"
                        >
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <svg
                                        class="w-12 h-12"
                                        :class="
                                            isDragging
                                                ? 'text-blue-300'
                                                : 'text-yellow-400 group-hover:text-yellow-300'
                                        "
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                        />
                                    </svg>
                                </div>
                                <p
                                    :class="
                                        isDragging
                                            ? 'text-blue-300'
                                            : 'text-blue-300 group-hover:text-blue-200'
                                    "
                                >
                                    {{
                                        isDragging
                                            ? "Drop files here"
                                            : "Drag and drop images here or click to select files"
                                    }}
                                </p>
                                <p class="text-gray-500 text-sm">
                                    Supported formats: JPG, PNG, GIF
                                </p>
                            </div>
                            <Input
                                id="images"
                                type="file"
                                @change="handleFileChange"
                                accept="image/*"
                                multiple
                                class="hidden"
                            />
                        </div>

                        <div
                            class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 mt-4"
                        >
                            <div
                                v-for="(image, displayIndex) in previewImages"
                                :key="image.id"
                                class="relative group border-2 rounded-lg overflow-hidden aspect-square transition-all duration-300"
                                :class="[
                                    image.index === form.primary_image_index
                                        ? 'border-blue-300 shadow-[0_0_15px_rgba(147,197,253,0.3)] scale-[1.02]'
                                        : 'border-yellow-400 hover:border-yellow-300',
                                ]"
                            >
                                <img
                                    :src="image.id"
                                    class="w-full h-full object-cover"
                                    :class="{
                                        'scale-105 transition-transform duration-500':
                                            image.index ===
                                            form.primary_image_index,
                                    }"
                                />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"
                                >
                                    <div
                                        class="absolute top-2 right-2 flex gap-2 transform translate-y-[-10px] opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300"
                                    >
                                        <button
                                            v-if="
                                                image.index !==
                                                form.primary_image_index
                                            "
                                            @click.prevent="
                                                setPrimaryImage(image.index)
                                            "
                                            class="p-1.5 rounded-full bg-blue-500/90 text-white hover:bg-blue-400 hover:shadow-[0_0_10px_rgba(147,197,253,0.5)] transition-all duration-300"
                                            title="Set as primary image"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                        </button>
                                        <button
                                            @click.prevent="
                                                removeImage(image.index)
                                            "
                                            class="p-1.5 rounded-full bg-red-500/90 text-white hover:bg-red-400 hover:shadow-[0_0_10px_rgba(239,68,68,0.5)] transition-all duration-300"
                                            title="Remove image"
                                        >
                                            <XMarkIcon class="w-4 h-4" />
                                        </button>
                                    </div>

                                    <div
                                        v-if="
                                            image.index ===
                                            form.primary_image_index
                                        "
                                        class="absolute bottom-0 inset-x-0 p-2"
                                    >
                                        <div
                                            class="flex items-center justify-center gap-1.5 text-blue-300"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    d="M5 8.5L12 15.5L19 8.5"
                                                />
                                            </svg>
                                            <span
                                                class="text-xs font-medium tracking-wider uppercase"
                                            >
                                                Primary
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-if="
                                        image.index === form.primary_image_index
                                    "
                                    class="absolute inset-0 bg-blue-300/10 pointer-events-none"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 space-x-4">
                        <Button
                            type="button"
                            @click="$inertia.get('/products')"
                            class="bg-gray-800 hover:bg-gray-700 text-gray-100 font-bold py-2 px-6 rounded-lg border border-gray-600 transition-all duration-300"
                        >
                            Cancel
                        </Button>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-6 rounded-lg border border-yellow-400 hover:shadow-[0_0_15px_rgba(250,204,21,0.5)] disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300"
                        >
                            <span
                                v-if="form.processing"
                                class="inline-block animate-pulse"
                            >
                                Processing...
                            </span>
                            <span v-else>Add Product</span>
                        </Button>
                    </div>
                </div>
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
