<script setup>
defineProps({
    modelValue: {
        type: String,
        default: "",
    },
    placeholder: {
        type: String,
        default: "",
    },
    error: {
        type: String,
        default: "",
    },
    required: {
        type: Boolean,
        default: false,
    },
    rows: {
        type: [String, Number],
        default: 4,
    },
    id: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="space-y-1">
        <textarea
            :id="id"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            :required="required"
            :rows="rows"
            class="w-full bg-gray-800 border-2 border-yellow-400 text-gray-100 rounded-lg px-4 py-2 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400 focus:outline-none hover:border-yellow-300 transition-all duration-300 resize-y"
            :class="{ 'border-red-400 focus:ring-red-400': error }"
        ></textarea>
        <span v-if="error" class="text-red-400 text-sm">{{ error }}</span>
    </div>
</template>
