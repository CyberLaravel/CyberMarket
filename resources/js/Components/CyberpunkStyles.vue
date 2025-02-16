<template>
    <div class="cyberpunk-theme">
        <slot />
    </div>
</template>

<style scoped>
/* Base Theme Styles */
.cyberpunk-theme {
    --neon-yellow: #fbbf24;
    --neon-blue: #60a5fa;
    --dark-bg: rgba(31, 41, 55, 0.8);
    --darker-bg: rgba(17, 24, 39, 0.95);
}

/* Input Styling */
:deep(.cyberpunk-input) {
    background-color: var(--dark-bg) !important;
    border: none !important;
    color: rgb(229, 231, 235) !important;
    box-shadow: 0 0 5px var(--neon-yellow),
        inset 0 0 10px rgba(251, 191, 36, 0.1);
    border-radius: 0.375rem;
    transition: all 0.3s ease;
}

:deep(.cyberpunk-input:focus) {
    box-shadow: 0 0 15px var(--neon-yellow),
        inset 0 0 10px rgba(251, 191, 36, 0.2);
    outline: none;
    background-color: var(--darker-bg) !important;
}

/* Text Effects */
:deep(.neon-text) {
    text-shadow: 0 0 10px var(--neon-yellow), 0 0 20px var(--neon-yellow);
}

:deep(.glitch-text) {
    position: relative;
    animation: glitch 3s infinite;
}

/* Container Styling */
:deep(.space-y-6 > div) {
    background-color: var(--dark-bg);
    box-shadow: 0 0 15px rgba(251, 191, 36, 0.1);
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

:deep(.space-y-6 > div:hover) {
    box-shadow: 0 0 20px rgba(251, 191, 36, 0.2);
}

/* Text Colors */
:deep(.text-gray-600),
:deep(.dark\:text-gray-400),
:deep(.text-gray-900),
:deep(.dark\:text-white),
:deep(.text-gray-700),
:deep(.dark\:text-gray-300) {
    color: rgb(229, 231, 235) !important;
}

/* Button Styling */
:deep(button.cyberpunk-button) {
    background-color: var(--dark-bg);
    color: var(--neon-yellow);
    border: none;
    box-shadow: 0 0 5px var(--neon-yellow);
    transition: all 0.3s ease;
}

:deep(button.cyberpunk-button:hover) {
    box-shadow: 0 0 15px var(--neon-yellow);
    background-color: rgba(251, 191, 36, 0.2);
}

/* Modal Styling */
:deep(.modal-content) {
    background-color: var(--darker-bg) !important;
    box-shadow: 0 0 20px rgba(251, 191, 36, 0.1);
}

/* Animations */
@keyframes glitch {
    0% {
        text-shadow: 0 0 10px var(--neon-yellow), 0 0 20px var(--neon-yellow);
    }
    50% {
        text-shadow: 0 0 5px var(--neon-yellow), 0 0 15px var(--neon-yellow);
    }
    100% {
        text-shadow: 0 0 10px var(--neon-yellow), 0 0 20px var(--neon-yellow);
    }
}

/* Form Section Styling */
:deep(.form-section) {
    background-color: var(--dark-bg);
    box-shadow: 0 0 15px rgba(251, 191, 36, 0.1);
    border-radius: 0.5rem;
}

/* Label Styling */
:deep(label) {
    color: var(--neon-yellow);
    font-family: "Orbitron", sans-serif;
}

/* Description Text */
:deep(.description) {
    color: var(--neon-blue);
    background-color: rgba(31, 41, 55, 0.5);
    padding: 1rem;
    border-radius: 0.5rem;
}

/* Error Messages */
:deep(.error-message) {
    color: #ef4444;
    text-shadow: 0 0 5px rgba(239, 68, 68, 0.5);
}

/* Success Messages */
:deep(.success-message) {
    color: var(--neon-yellow);
    text-shadow: 0 0 5px rgba(251, 191, 36, 0.5);
}

/* Hover Effects */
:deep(.hover-glow:hover) {
    box-shadow: 0 0 15px var(--neon-yellow);
}

/* Section Borders */
:deep(.section-border) {
    border-color: rgba(251, 191, 36, 0.2);
}

/* List Items */
:deep(.list-item) {
    background-color: var(--dark-bg);
    transition: all 0.3s ease;
}

:deep(.list-item:hover) {
    background-color: rgba(251, 191, 36, 0.1);
}
</style>
