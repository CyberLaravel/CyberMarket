<script setup>
import { onMounted, ref } from "vue";

defineProps(["modelValue"]);
defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="border-yellow-400 focus:border-yellow-500 focus:ring focus:ring-yellow-300 focus:ring-opacity-50 rounded-md shadow-sm bg-gray-700 text-gray-100"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>
