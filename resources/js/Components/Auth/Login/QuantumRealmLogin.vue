<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gray-900 overflow-hidden"
    >
        <div class="relative w-full max-w-md">
            <!-- LaraMart particle effect -->
            <div class="absolute inset-0">
                <div
                    v-for="n in 50"
                    :key="n"
                    class="absolute w-1 h-1 bg-blue-500 rounded-full"
                    :style="{
                        left: `${Math.random() * 100}%`,
                        top: `${Math.random() * 100}%`,
                        animation: `laraMart-float ${
                            5 + Math.random() * 10
                        }s infinite`,
                    }"
                ></div>
            </div>

            <div
                class="relative bg-gray-800 bg-opacity-50 p-8 rounded-lg border border-blue-500 shadow-2xl backdrop-blur-sm z-10"
            >
                <div class="text-center mb-8">
                    <h2
                        class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600 animate-text-shimmer"
                    >
                        LARA MART
                    </h2>
                    <p class="text-blue-300 mt-2 text-sm">
                        Connect Your Account
                    </p>
                </div>

                <form @submit.prevent="handleLogin" class="space-y-6">
                    <div class="relative">
                        <input
                            type="email"
                            v-model="email"
                            required
                            class="w-full bg-gray-700 border-2 border-blue-500 rounded-lg px-4 py-2 text-blue-300 placeholder-blue-500 focus:outline-none focus:border-blue-400 transition-colors"
                            placeholder="LaraMart ID"
                        />
                        <div class="absolute right-3 top-2">
                            <svg
                                class="w-6 h-6 text-blue-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"
                                ></path>
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <input
                            type="password"
                            v-model="password"
                            required
                            class="w-full bg-gray-700 border-2 border-blue-500 rounded-lg px-4 py-2 text-blue-300 placeholder-blue-500 focus:outline-none focus:border-blue-400 transition-colors"
                            placeholder="LaraMart Key"
                        />
                        <div class="absolute right-3 top-2">
                            <svg
                                class="w-6 h-6 text-blue-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                                ></path>
                            </svg>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2 px-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 transform hover:scale-105"
                    >
                        INITIATE LARA MART CONNECTION
                    </button>
                </form>

                <!-- Decorative laraMart circuit -->
                <div
                    class="absolute -bottom-4 left-0 right-0 h-8 flex justify-around"
                >
                    <div
                        v-for="n in 5"
                        :key="n"
                        class="w-0.5 h-full bg-blue-500"
                    ></div>
                </div>
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
@import url("https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap");

body {
    font-family: "Space Mono", monospace;
}

@keyframes laraMart-float {
    0%,
    100% {
        transform: translateY(0) scale(1);
        opacity: 0.5;
    }
    50% {
        transform: translateY(-20px) scale(1.5);
        opacity: 1;
    }
}
</style>
