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

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=VT323&display=swap");

body {
    font-family: "VT323", monospace;
    background-color: black;
    color: #00ff00;
}

.glitch {
    position: relative;
}

.glitch::before,
.glitch::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.glitch::before {
    left: 2px;
    text-shadow: -2px 0 #ff00ff;
    clip: rect(24px, 550px, 90px, 0);
    animation: glitch-anim-2 3s infinite linear alternate-reverse;
}

.glitch::after {
    left: -2px;
    text-shadow: -2px 0 #00ffff;
    clip: rect(85px, 550px, 140px, 0);
    animation: glitch-anim 2.5s infinite linear alternate-reverse;
}

@keyframes glitch-anim {
    0% {
        clip: rect(51px, 9999px, 28px, 0);
    }
    10% {
        clip: rect(33px, 9999px, 144px, 0);
    }
    20% {
        clip: rect(141px, 9999px, 3px, 0);
    }
    30% {
        clip: rect(53px, 9999px, 109px, 0);
    }
    40% {
        clip: rect(133px, 9999px, 39px, 0);
    }
    50% {
        clip: rect(58px, 9999px, 140px, 0);
    }
    60% {
        clip: rect(83px, 9999px, 151px, 0);
    }
    70% {
        clip: rect(137px, 9999px, 39px, 0);
    }
    80% {
        clip: rect(19px, 9999px, 67px, 0);
    }
    90% {
        clip: rect(56px, 9999px, 98px, 0);
    }
    100% {
        clip: rect(132px, 9999px, 61px, 0);
    }
}

@keyframes glitch-anim-2 {
    0% {
        clip: rect(132px, 9999px, 61px, 0);
    }
    10% {
        clip: rect(56px, 9999px, 98px, 0);
    }
    20% {
        clip: rect(19px, 9999px, 67px, 0);
    }
    30% {
        clip: rect(137px, 9999px, 39px, 0);
    }
    40% {
        clip: rect(83px, 9999px, 151px, 0);
    }
    50% {
        clip: rect(58px, 9999px, 140px, 0);
    }
    60% {
        clip: rect(133px, 9999px, 39px, 0);
    }
    70% {
        clip: rect(53px, 9999px, 109px, 0);
    }
    80% {
        clip: rect(141px, 9999px, 3px, 0);
    }
    90% {
        clip: rect(33px, 9999px, 144px, 0);
    }
    100% {
        clip: rect(51px, 9999px, 28px, 0);
    }
}
</style>
