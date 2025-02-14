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
                        <button
                            type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Resend Verification Email
                        </button>
                    </form>

                    <div class="mt-6 flex space-x-4">
                        <Link
                            :href="route('profile.show')"
                            class="text-center flex-1 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Edit Profile
                        </Link>
                        <Link
                            :href="route('logout')"
                            class="text-center flex-1 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Logout
                        </Link>
                    </div>
                </div>

                <div
                    class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-center"
                >
                    <span class="text-sm text-gray-600">Already verified?</span>
                    <Link
                        :href="route('login')"
                        class="ml-1 text-sm font-medium text-indigo-600 hover:text-indigo-500"
                        >Return to login</Link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";

const props = defineProps({
    status: String,
});

const form = useForm({});

const handleResendVerification = () => {
    // Handle resend verification email logic here
    console.log("Resend verification email attempt");
    form.post(route("verification.send"));
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    font-family: "Inter", sans-serif;
}
</style>
