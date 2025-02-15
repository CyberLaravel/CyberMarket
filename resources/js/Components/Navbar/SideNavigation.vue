<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    navigation: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div
        class="w-64 bg-gray-800 border-r border-yellow-400 min-h-[calc(100vh-4rem)] flex flex-col"
    >
        <nav class="flex-1 pt-6">
            <div class="space-y-1 px-2">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        route().current(item.href)
                            ? 'bg-gray-900 text-yellow-400 border-l-2 border-yellow-400 shadow-[0_0_10px_rgba(250,204,21,0.3)]'
                            : 'text-blue-300 hover:text-yellow-400 hover:bg-gray-900',
                        'group flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 rounded-r-lg',
                    ]"
                >
                    <span v-html="item.icon" class="mr-3"></span>
                    {{ item.name }}
                </Link>
            </div>
        </nav>
    </div>
</template>
