<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import TheNavbar from "@/Components/Navbar/TheNavbar.vue";

const page = usePage();
const isAuthenticated = computed(() => page.props.auth.user !== null);
</script>

<template>
    <div class="min-h-screen bg-gray-900 font-['Orbitron']">
        <TheNavbar />

        <!-- Flash Messages -->
        <div
            v-if="$page.props.flash?.message"
            class="fixed top-4 right-4 z-50 max-w-sm"
        >
            <div
                class="card-cyberpunk px-6 py-4 rounded-md shadow-[0_0_15px_rgba(250,204,21,0.3)] flex items-center space-x-3"
            >
                <svg
                    class="h-5 w-5 text-primary"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <span class="text-body">{{ $page.props.flash.message }}</span>
            </div>
        </div>

        <!-- Main Content -->
        <main class="container mx-auto">
            <slot />
        </main>

        <!-- Footer -->
        <footer
            class="mt-auto border-t border-yellow-400 bg-gray-800 py-6 text-center"
        >
            <div class="container mx-auto px-4">
                <p class="text-body text-sm">
                    © {{ new Date().getFullYear() }} CyberStore. All rights
                    reserved.
                </p>
                <div class="mt-2 flex justify-center space-x-4">
                    <a
                        href="#"
                        class="text-secondary hover:text-primary transition-colors"
                    >
                        Privacy Policy
                    </a>
                    <a
                        href="#"
                        class="text-secondary hover:text-primary transition-colors"
                    >
                        Terms of Service
                    </a>
                    <a
                        href="#"
                        class="text-secondary hover:text-primary transition-colors"
                    >
                        Contact
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
/* Global styles */
body {
    @apply bg-gray-900;
}

/* Scrollbar styling */
::-webkit-scrollbar {
    @apply w-2;
}

::-webkit-scrollbar-track {
    @apply bg-gray-800;
}

::-webkit-scrollbar-thumb {
    @apply bg-yellow-400 rounded-full hover:bg-yellow-300 transition-colors;
}

/* Firefox */
* {
    scrollbar-width: thin;
    scrollbar-color: #facc15 #1f2937;
}

/* Glitch effect for text with .glitch-text class */
.glitch-text {
    text-shadow: 0 0 10px rgba(255, 214, 0, 0.8),
        0 0 20px rgba(255, 214, 0, 0.5), 0 0 30px rgba(255, 214, 0, 0.3);
    animation: glitch 3s infinite;
}

@keyframes glitch {
    0% {
        transform: translate(0);
    }
    20% {
        transform: translate(-2px, 2px);
    }
    40% {
        transform: translate(-2px, -2px);
    }
    60% {
        transform: translate(2px, 2px);
    }
    80% {
        transform: translate(2px, -2px);
    }
    100% {
        transform: translate(0);
    }
}

/* Neon button effect */
.neon-button {
    @apply relative overflow-hidden transition-all duration-300;
    box-shadow: 0 0 10px rgba(250, 204, 21, 0.3);
}

.neon-button:hover {
    box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
}

.neon-button::before {
    content: "";
    @apply absolute inset-0 bg-yellow-400 opacity-0 transition-opacity duration-300;
}

.neon-button:hover::before {
    @apply opacity-20;
}

/* Page transitions */
.page-enter-active,
.page-leave-active {
    @apply transition-all duration-300;
}

.page-enter-from,
.page-leave-to {
    @apply opacity-0 transform scale-95;
}

.page-enter-to,
.page-leave-from {
    @apply opacity-100 transform scale-100;
}
</style>
