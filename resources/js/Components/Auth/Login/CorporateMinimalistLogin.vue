<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <svg
                            class="mx-auto h-12 w-auto text-indigo-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 48 48"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                        <h2 class="mt-4 text-3xl font-semibold text-gray-900">
                            Welcome Back
                        </h2>
                        <p class="mt-2 text-gray-600">
                            Please sign in to your account
                        </p>
                    </div>

                    <div
                        v-if="status"
                        class="mb-4 font-medium text-sm text-yellow-400"
                    >
                        {{ status }}
                    </div>

                    <form @submit.prevent="handleLogin" class="space-y-6">
                        <div>
                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                                >Email Address</label
                            >
                            <input
                                id="email"
                                type="email"
                                :value="email"
                                @input="
                                    $emit('update:email', $event.target.value)
                                "
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                                placeholder="you@example.com"
                            />
                            <div v-show="errors.email">
                                <p class="text-sm text-red-400">
                                    {{ errors.email }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700"
                                >Password</label
                            >
                            <input
                                id="password"
                                type="password"
                                v-model="password"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                                placeholder="••••••••"
                            />
                            <div v-show="errors.password">
                                <p class="text-sm text-red-400">
                                    {{ errors.password }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    id="remember-me"
                                    type="checkbox"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    v-model="rememberMe"
                                />
                                <label
                                    for="remember-me"
                                    class="ml-2 block text-sm text-gray-900"
                                    >Remember me</label
                                >
                                <div v-show="errors.rememberMe">
                                    <p class="text-sm text-red-400">
                                        {{ errors.rememberMe }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-sm">
                                <a
                                    href="#"
                                    class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out"
                                    >Forgot your password?</a
                                >
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
                            >
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

                <div
                    class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-center"
                >
                    <span class="text-sm text-gray-600"
                        >Don't have an account?</span
                    >
                    <Link
                        :href="route('register')"
                        class="ml-1 text-sm font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out"
                        >Sign up</Link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps(["canResetPassword", "status", "errors"]);
const emit = defineEmits(["submit"]);

const email = defineModel("email");
const password = defineModel("password");
const rememberMe = defineModel("rememberMe");

function handleLogin() {
    emit("submit", { email, password, rememberMe });
}
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    font-family: "Inter", sans-serif;
}
</style>
