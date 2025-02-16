<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
    variant: {
        type: String,
        default: "primary",
        validator: (value) =>
            ["primary", "secondary", "destructive"].includes(value),
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    processing: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :type="type"
        :disabled="disabled || processing"
        class="font-bold py-2 px-6 rounded-lg border transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
        :class="{
            'bg-yellow-500 hover:bg-yellow-400 text-black border-yellow-400 hover:shadow-[0_0_15px_rgba(250,204,21,0.5)]':
                variant === 'primary',
            'bg-gray-800 hover:bg-gray-700 text-gray-100 border-gray-600':
                variant === 'secondary',
            'bg-red-500 hover:bg-red-400 text-white border-red-400 hover:shadow-[0_0_15px_rgba(239,68,68,0.5)]':
                variant === 'destructive',
        }"
    >
        <span v-if="processing" class="inline-block animate-pulse">
            Processing...
        </span>
        <slot v-else></slot>
    </button>
</template>
