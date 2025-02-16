<script setup>
import { XMarkIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    images: {
        type: Array,
        required: true,
    },
    primaryIndex: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(["update:primaryIndex", "removeImage"]);

const setPrimaryImage = (index) => {
    emit("update:primaryIndex", index);
};

const removeImage = (index) => {
    emit("removeImage", index);
};
</script>

<template>
    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
        <div
            v-for="(image, displayIndex) in images"
            :key="image.id"
            class="relative group border-2 rounded-lg overflow-hidden aspect-square transition-all duration-300"
            :class="[
                image.index === primaryIndex
                    ? 'border-blue-300 shadow-[0_0_15px_rgba(147,197,253,0.3)] scale-[1.02]'
                    : 'border-yellow-400 hover:border-yellow-300',
            ]"
        >
            <img
                :src="image.id"
                class="w-full h-full object-cover"
                :class="{
                    'scale-105 transition-transform duration-500':
                        image.index === primaryIndex,
                }"
            />
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"
            >
                <div
                    class="absolute top-2 right-2 flex gap-2 transform translate-y-[-10px] opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300"
                >
                    <button
                        v-if="image.index !== primaryIndex"
                        @click.prevent="setPrimaryImage(image.index)"
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
                        @click.prevent="removeImage(image.index)"
                        class="p-1.5 rounded-full bg-red-500/90 text-white hover:bg-red-400 hover:shadow-[0_0_10px_rgba(239,68,68,0.5)] transition-all duration-300"
                        title="Remove image"
                    >
                        <XMarkIcon class="w-4 h-4" />
                    </button>
                </div>

                <div
                    v-if="image.index === primaryIndex"
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
                            <path d="M5 8.5L12 15.5L19 8.5" />
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
                v-if="image.index === primaryIndex"
                class="absolute inset-0 bg-blue-300/10 pointer-events-none"
            ></div>
        </div>
    </div>
</template>
