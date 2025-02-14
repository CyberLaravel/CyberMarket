<template>
    <div
        class="cyber-banner bg-gray-900 border-b border-yellow-400 p-4 text-center"
    >
        <slot>Cyberpunk Banner</slot>
    </div>
</template>

<style scoped>
.cyber-banner {
    font-family: "Orbitron", sans-serif;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #00ffff;
    text-shadow: 0 0 5px #00ffff, 0 0 10px #00ffff;
}
</style>
