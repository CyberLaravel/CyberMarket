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
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                            />
                        </svg>
                        <h2 class="mt-4 text-3xl font-semibold text-gray-900">
                            Reset Password
                        </h2>
                        <p class="mt-2 text-gray-600">
                            Enter your new password
                        </p>
                    </div>

                    <form
                        @submit.prevent="handleResetPassword"
                        class="space-y-6"
                    >
                        <div>
                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700"
                                >New Password</label
                            >
                            <input
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                            <div v-show="form.errors.password">
                                <p class="text-sm text-red-400">
                                    {{ form.errors.password }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <label
                                for="confirm-password"
                                class="block text-sm font-medium text-gray-700"
                                >Confirm New Password</label
                            >
                            <input
                                id="confirm-password"
                                type="password"
                                v-model="confirmPassword"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                            <div v-show="form.errors.confirmPassword">
                                <p class="text-sm text-red-400">
                                    {{ form.errors.confirmPassword }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const handleResetPassword = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    font-family: "Inter", sans-serif;
}
</style>
