<template>
    <div
        class="min-h-screen flex items-center justify-center bg-black text-green-500 font-mono"
    >
        <div class="w-full max-w-md p-8 space-y-8 border-2 border-green-500">
            <div class="text-center">
                <h2 class="text-4xl font-bold mb-2 glitch" data-text="LOGIN">
                    LOGIN
                </h2>
                <p class="text-green-400">SYSTEM ACCESS REQUIRED</p>
            </div>
            <form class="space-y-6" @submit.prevent="handleLogin">
                <div>
                    <label for="email" class="block mb-2 uppercase"
                        >Email</label
                    >
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        class="w-full px-4 py-2 bg-black border-2 border-green-500 text-green-500 placeholder-green-700 focus:outline-none focus:border-white"
                        placeholder="ENTER EMAIL"
                        v-model="email"
                    />
                </div>
                <div>
                    <label for="password" class="block mb-2 uppercase"
                        >Password</label
                    >
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full px-4 py-2 bg-black border-2 border-green-500 text-green-500 placeholder-green-700 focus:outline-none focus:border-white"
                        placeholder="ENTER PASSWORD"
                        v-model="password"
                    />
                </div>
                <div>
                    <button
                        type="submit"
                        class="w-full px-4 py-2 text-lg font-bold text-black bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 uppercase"
                    >
                        AUTHENTICATE
                    </button>
                </div>
            </form>
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
