<script setup>
import { computed } from "vue";
import { Button } from "@/Components/ui/button";
import { Link, useForm } from "@inertiajs/vue3";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";

defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => status === "verification-link-sent"
);
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-900">
        <Card class="w-full max-w-md border-yellow-400 bg-gray-800">
            <CardHeader class="text-center">
                <div class="mx-auto mb-4 size-12 text-yellow-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
                <CardTitle
                    class="text-yellow-400 text-2xl font-orbitron glitch-text"
                >
                    Email Verification
                </CardTitle>
                <CardDescription class="text-gray-100">
                    Thanks for signing up! Before getting started, could you
                    verify your email address by clicking on the link we just
                    emailed to you? If you didn't receive the email, we will
                    gladly send you another.
                </CardDescription>
            </CardHeader>

            <CardContent>
                <div
                    v-if="verificationLinkSent"
                    class="mb-4 text-sm font-medium text-yellow-400"
                >
                    A new verification link has been sent to the email address
                    you provided during registration.
                </div>

                <form @submit.prevent="submit">
                    <div class="flex items-center justify-between">
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-yellow-400 text-black hover:bg-yellow-300 transition-colors"
                        >
                            Resend Verification Email
                        </Button>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="text-blue-300 hover:text-yellow-400 transition-colors"
                        >
                            Log Out
                        </Link>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<style scoped>
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
</style>
