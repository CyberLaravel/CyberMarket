<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
    as: String,
});
</script>

<template>
    <div>
        <Link
            v-if="as == 'button'"
            :href="href"
            class="block w-full px-4 py-2 text-left text-sm leading-5 text-blue-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out"
        >
            <slot />
        </Link>

        <a
            v-else-if="as == 'a'"
            :href="href"
            class="block px-4 py-2 text-sm leading-5 text-blue-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out"
        >
            <slot />
        </a>

        <button
            v-else
            type="submit"
            class="block w-full px-4 py-2 text-left text-sm leading-5 text-blue-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out"
        >
            <slot />
        </button>
    </div>
</template>
