<script setup>
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { toast } from "@/components/ui/toast";

import { useForm, Link, router } from "@inertiajs/vue3";
import DropdownMenuItem from "@/components/ui/dropdown-menu/DropdownMenuItem.vue";

const props = defineProps({
    status: String,
});

const form = useForm({});

const handleResendVerification = () => {
    // Handle resend verification email logic here
    console.log("Resend verification email attempt");
    form.post(route("verification.send"));
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md">
            <Card class="bg-white shadow-2xl rounded-lg overflow-hidden">
                <CardHeader class="p-8">
                    <div class="text-center mb-8">
                        <svg
                            class="mx-auto h-12 w-auto text-indigo-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            />
                        </svg>
                        <h2 class="mt-4 text-3xl font-semibold text-gray-900">
                            Verify Your Email
                        </h2>
                        <p class="mt-2 text-gray-600">
                            We've sent a verification link to your email
                        </p>
                    </div>
                </CardHeader>

                <CardContent>
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            Please check your email and click on the
                            verification link to complete your registration.
                        </p>
                        <p class="text-sm text-gray-600">
                            If you haven't received the email, please check your
                            spam folder or use the form below to resend the
                            verification email.
                        </p>
                    </div>

                    <form
                        @submit.prevent="handleResendVerification"
                        class="mt-6"
                    >
                        <Button class="w-full">
                            Resend Verification Email
                        </Button>
                    </form>

                    <div class="mt-6 flex space-x-4">
                        <Link :href="route('profile.show')" class="w-full">
                            <Button class="w-full" variant="secondary">
                                Edit Profile
                            </Button>
                        </Link>
                        <form @submit.prevent="logout" class="w-full">
                            <Button class="w-full" variant="secondary">
                                Logout
                            </Button>
                        </form>
                    </div>
                </CardContent>

                <CardFooter
                    class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-center"
                >
                    <span class="text-sm text-gray-600">Already verified?</span>
                    <Link
                        :href="route('login')"
                        class="ml-1 text-sm font-medium text-indigo-600 hover:text-indigo-500"
                        >Return to login</Link
                    >
                </CardFooter>
            </Card>
        </div>
    </div>
</template>
