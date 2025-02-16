<script setup>
defineProps({
    value: {
        type: [String, Number],
        required: true,
    },
});
</script>

<template>
    <option
        :value="value"
        class="py-2 px-4 bg-gray-800 hover:bg-gray-700 hover:text-yellow-400"
    >
        <slot></slot>
    </option>
</template>
