<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: "",
    },
    placeholder: {
        type: String,
        default: "Select an option",
    },
    error: {
        type: String,
        default: "",
    },
    label: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event) => {
    emit("update:modelValue", event.target.value);
};
</script>

<template>
    <div class="space-y-2">
        <label class="text-yellow-400 font-orbitron">{{ label }}</label>
        <div class="relative">
            <select
                :value="modelValue"
                @input="updateValue"
                class="w-full bg-gray-800 border-2 border-yellow-400 text-gray-100 rounded-lg px-4 py-2.5 appearance-none cursor-pointer hover:border-yellow-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition-all duration-300"
            >
                <option value="" disabled selected class="bg-gray-800">
                    {{ placeholder }}
                </option>
                <slot></slot>
            </select>
            <!-- Custom dropdown arrow -->
            <div
                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"
            >
                <svg
                    class="w-5 h-5 text-yellow-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </div>
        </div>
        <span v-if="error" class="text-red-400 text-sm">
            {{ error }}
        </span>
    </div>
</template>
