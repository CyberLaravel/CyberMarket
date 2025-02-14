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
                            Forgot Password
                        </h2>
                        <p class="mt-2 text-gray-600">
                            Enter your email to reset your password
                        </p>
                    </div>

                    <div
                        v-if="status"
                        class="mb-4 font-medium text-sm text-yellow-400"
                    >
                        {{ status }}
                    </div>

                    <form
                        @submit.prevent="handleForgotPassword"
                        class="space-y-6"
                    >
                        <div>
                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                                >Email Address</label
                            >
                            <input
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                            <div v-show="form.errors.email">
                                <p class="text-sm text-red-400">
                                    {{ form.errors.email }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Send Reset Link
                            </button>
                        </div>
                    </form>
                </div>

                <div
                    class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-center"
                >
                    <span class="text-sm text-gray-600">
                        Remember your password?
                    </span>
                    <a
                        href="#"
                        class="ml-1 text-sm font-medium text-indigo-600 hover:text-indigo-500"
                    >
                        Sign in
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const handleForgotPassword = () => {
    form.post(route("password.email"));
};
</script>
