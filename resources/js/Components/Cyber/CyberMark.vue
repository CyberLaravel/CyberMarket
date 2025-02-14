<template>
    <div class="cyber-mark">
        <svg
            width="40"
            height="40"
            viewBox="0 0 40 40"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M20 5L5 20L20 35L35 20L20 5Z"
                stroke="#00FFFF"
                stroke-width="2"
            />
            <path d="M20 10L10 20L20 30L30 20L20 10Z" fill="#FF00FF" />
        </svg>
    </div>
</template>

<style scoped>
.cyber-mark {
    animation: neon-pulse 1.5s infinite alternate;
}

@keyframes neon-pulse {
    from {
        filter: drop-shadow(0 0 2px #00ffff) drop-shadow(0 0 4px #00ffff);
    }
    to {
        filter: drop-shadow(0 0 4px #00ffff) drop-shadow(0 0 8px #00ffff);
    }
}
</style>
