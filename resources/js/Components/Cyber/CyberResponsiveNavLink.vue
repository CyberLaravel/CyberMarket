<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps(["href", "active"]);

const classes = computed(() => {
    return props.active
        ? "block w-full pl-3 pr-4 py-2 border-l-4 border-yellow-400 text-left text-base font-medium text-yellow-400 bg-gray-800 focus:outline-none focus:text-yellow-800 focus:bg-yellow-100 focus:border-yellow-700 transition duration-150 ease-in-out"
        : "block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-blue-300 hover:text-yellow-400 hover:bg-gray-700 hover:border-yellow-300 focus:outline-none focus:text-yellow-400 focus:bg-gray-700 focus:border-yellow-300 transition duration-150 ease-in-out";
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
