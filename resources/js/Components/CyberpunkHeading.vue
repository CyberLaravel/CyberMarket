<script setup>
defineProps({
    level: {
        type: Number,
        default: 3,
    },
});
</script>

<template>
    <component
        :is="`h${level}`"
        class="font-['Orbitron'] text-yellow-400 text-2xl font-bold neon-text glitch-text"
    >
        <slot />
    </component>
</template>
