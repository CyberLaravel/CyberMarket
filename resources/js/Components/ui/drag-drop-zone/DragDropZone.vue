<script setup>
import { ref } from "vue";

const props = defineProps({
    accept: {
        type: String,
        default: "image/*",
    },
    multiple: {
        type: Boolean,
        default: true,
    },
    supportedFormats: {
        type: String,
        default: "JPG, PNG, GIF",
    },
});

const emit = defineEmits(["filesSelected"]);
const isDragging = ref(false);

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
    emit("filesSelected", files);
};

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    emit("filesSelected", files);
};

const triggerFileInput = () => {
    document.getElementById("file-input").click();
};
</script>

<template>
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
                        : "Drag and drop files here or click to select files"
                }}
            </p>
            <p class="text-gray-500 text-sm">
                Supported formats: {{ supportedFormats }}
            </p>
        </div>
        <input
            id="file-input"
            type="file"
            @change="handleFileChange"
            :accept="accept"
            :multiple="multiple"
            class="hidden"
        />
    </div>
</template>
