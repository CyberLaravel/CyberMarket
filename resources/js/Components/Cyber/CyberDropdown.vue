<script setup>
import { ref } from "vue";

const props = defineProps({
    align: {
        default: "right",
    },
    width: {
        default: "48",
    },
    contentClasses: {
        default: () => ["py-1", "bg-gray-800"],
    },
});

const open = ref(false);

const closeOnEscape = (e) => {
    if (open.value && e.key === "Escape") {
        open.value = false;
    }
};

defineExpose({ open });
</script>

<template>
    <div class="relative" @keydown="closeOnEscape">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <div
            v-show="open"
            class="fixed inset-0 z-40"
            @click="open = false"
        ></div>

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="absolute z-50 mt-2 rounded-md shadow-lg"
                :class="[
                    { 'origin-top-right right-0': align === 'right' },
                    { 'origin-top-left left-0': align === 'left' },
                ]"
                :style="{ width: width + 'px' }"
                @click="open = false"
            >
                <div
                    class="rounded-md ring-1 ring-yellow-400 ring-opacity-50"
                    :class="contentClasses"
                >
                    <slot name="content" />
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
/* Add any additional styles here */
</style>
