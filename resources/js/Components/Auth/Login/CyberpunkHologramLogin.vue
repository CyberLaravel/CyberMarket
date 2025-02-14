<template>
    <div
        class="min-h-screen flex items-center justify-center bg-black overflow-hidden"
    >
        <div class="relative w-full max-w-md">
            <!-- Holographic effect -->
            <div
                class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-purple-500 opacity-30 blur-3xl animate-pulse"
            ></div>

            <div
                class="relative bg-black bg-opacity-50 p-8 rounded-lg border border-cyan-500 shadow-2xl backdrop-blur-sm"
            >
                <div class="text-center mb-8">
                    <h2
                        class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-600 animate-text-shimmer"
                    >
                        NEURAL LINK
                    </h2>
                    <p class="text-cyan-300 mt-2 text-sm">
                        Establish Connection
                    </p>
                </div>

                <form @submit.prevent="handleLogin" class="space-y-6">
                    <div class="group">
                        <input
                            type="email"
                            v-model="email"
                            required
                            class="w-full bg-transparent border-b-2 border-cyan-500 px-4 py-2 text-cyan-300 placeholder-cyan-700 focus:outline-none focus:border-purple-500 transition-colors"
                            placeholder="Identity Code"
                        />
                        <div
                            class="h-0.5 w-0 group-focus-within:w-full bg-gradient-to-r from-cyan-500 to-purple-500 transition-all duration-300"
                        ></div>
                    </div>

                    <div class="group">
                        <input
                            type="password"
                            v-model="password"
                            required
                            class="w-full bg-transparent border-b-2 border-cyan-500 px-4 py-2 text-cyan-300 placeholder-cyan-700 focus:outline-none focus:border-purple-500 transition-colors"
                            placeholder="Neural Key"
                        />
                        <div
                            class="h-0.5 w-0 group-focus-within:w-full bg-gradient-to-r from-cyan-500 to-purple-500 transition-all duration-300"
                        ></div>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2 px-4 bg-gradient-to-r from-cyan-500 to-purple-500 text-black font-bold rounded hover:from-cyan-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300 transform hover:scale-105"
                    >
                        INITIATE UPLINK
                    </button>
                </form>

                <!-- Decorative elements -->
                <div
                    class="absolute top-0 left-0 w-16 h-16 border-t-2 border-l-2 border-cyan-500 -mt-2 -ml-2"
                ></div>
                <div
                    class="absolute bottom-0 right-0 w-16 h-16 border-b-2 border-r-2 border-purple-500 -mb-2 -mr-2"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import CyberAuthCard from "@/Components/CyberAuthCard.vue";
import CyberAuthLogo from "@/Components/CyberAuthLogo.vue";
import CyberButton from "@/Components/CyberButton.vue";
import CyberInput from "@/Components/CyberInput.vue";
import CyberInputError from "@/Components/CyberInputError.vue";
import CyberInputLabel from "@/Components/CyberInputLabel.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const handleLogin = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap");

body {
    font-family: "Orbitron", sans-serif;
}

.animate-text-shimmer {
    background-size: 200% auto;
    animation: textShimmer 2s linear infinite;
}

@keyframes textShimmer {
    to {
        background-position: 200% center;
    }
}
</style>
