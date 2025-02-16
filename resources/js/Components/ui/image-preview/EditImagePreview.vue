<script setup>
import { X, Star } from "lucide-vue-next";

const props = defineProps({
    existingImages: {
        type: Array,
        required: true,
    },
    newImages: {
        type: Array,
        default: () => [],
    },
    primaryImageId: {
        type: [Number, String],
        required: true,
    },
    getImageUrl: {
        type: Function,
        required: true,
    },
});

const emit = defineEmits(["deleteImage", "setPrimaryImage", "removeNewImage"]);

const handleDeleteImage = (imageId) => {
    emit("deleteImage", imageId);
};

const handleSetPrimaryImage = (imageId) => {
    emit("setPrimaryImage", imageId);
};

const handleRemoveNewImage = (index) => {
    emit("removeNewImage", index);
};
</script>

<template>
    <!-- Existing Database Images -->
    <div v-if="existingImages.length" class="mb-4">
        <h3 class="text-blue-300 font-orbitron mb-4">Current Images</h3>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
            <div
                v-for="image in existingImages"
                :key="image.id"
                class="relative group"
            >
                <div
                    v-if="getImageUrl(image.image_path)"
                    class="w-full aspect-square"
                >
                    <img
                        :src="getImageUrl(image.image_path)"
                        :alt="image.id"
                        class="w-full h-full object-cover rounded-lg border border-yellow-400"
                    />
                </div>
                <div
                    v-else
                    class="w-full aspect-square rounded-lg border border-yellow-400 bg-gray-800 flex items-center justify-center"
                >
                    <span class="text-yellow-400 text-sm font-orbitron"
                        >No Image</span
                    >
                </div>

                <!-- Primary Badge -->
                <span
                    v-if="image.id === primaryImageId"
                    class="absolute top-2 left-2 px-2 py-1 bg-yellow-400 text-black text-xs rounded-md font-orbitron"
                >
                    Primary
                </span>

                <!-- Action Buttons -->
                <div
                    class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                >
                    <!-- Set as Primary button -->
                    <button
                        type="button"
                        @click="handleSetPrimaryImage(image.id)"
                        class="p-1 bg-gray-900 rounded-full border border-yellow-400 text-yellow-400 hover:border-blue-300 hover:text-blue-300 transition-colors duration-200"
                        :class="{
                            'opacity-50 cursor-not-allowed':
                                image.id === primaryImageId,
                        }"
                        :disabled="image.id === primaryImageId"
                        title="Set as primary"
                    >
                        <Star class="h-4 w-4" />
                    </button>
                    <!-- Delete button -->
                    <button
                        type="button"
                        @click="handleDeleteImage(image.id)"
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
    <div v-if="newImages.length" class="mb-4">
        <h3 class="text-blue-300 font-orbitron mb-4">New Uploads</h3>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
            <div
                v-for="(preview, index) in newImages"
                :key="index"
                class="relative group"
            >
                <div class="w-full aspect-square relative">
                    <img
                        :src="preview"
                        :alt="`New upload ${index + 1}`"
                        class="w-full h-full object-cover rounded-lg border-2 border-blue-300"
                    />
                </div>
                <button
                    type="button"
                    @click="handleRemoveNewImage(index)"
                    class="absolute top-2 right-2 p-1 bg-gray-900 rounded-full border border-red-400 text-red-400 hover:bg-red-400 hover:text-gray-900 transition-colors duration-200"
                    title="Remove from upload"
                >
                    <X class="h-4 w-4" />
                </button>
            </div>
        </div>
    </div>
</template>
