<script setup>
defineProps({
    for: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <label
        :for="for"
        class="block text-yellow-400 font-orbitron font-medium mb-1 transition-colors duration-300 hover:text-yellow-300"
    >
        <slot></slot>
    </label>
</template>
