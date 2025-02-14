<template>
    {{ form.errors }}
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
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                            />
                        </svg>
                        <h2 class="mt-4 text-3xl font-semibold text-gray-900">
                            Two-Factor Authentication
                        </h2>
                        <p class="mt-2 text-gray-600">
                            {{
                                useRecoveryCode
                                    ? "Enter your recovery code"
                                    : "Enter the code from your authenticator app"
                            }}
                        </p>
                    </div>

                    <form
                        @submit.prevent="handleTwoFactorChallenge"
                        class="space-y-6"
                    >
                        <div v-if="!useRecoveryCode">
                            <label
                                for="code"
                                class="block text-sm font-medium text-gray-700"
                                >Authentication Code</label
                            >
                            <input
                                id="code"
                                type="text"
                                v-model="form.code"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                            <div v-show="form.errors.code">
                                <p class="text-sm text-red-400">
                                    {{ form.errors.code }}
                                </p>
                            </div>
                        </div>

                        <div v-else>
                            <label
                                for="recovery-code"
                                class="block text-sm font-medium text-gray-700"
                                >Recovery Code</label
                            >
                            <input
                                id="recovery-code"
                                type="text"
                                v-model="form.recovery_code"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />

                            <div v-show="form.errors.recovery_code">
                                <p class="text-sm text-red-400">
                                    {{ form.errors.recovery_code }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Verify
                            </button>
                        </div>
                    </form>
                </div>

                <div
                    class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-center"
                >
                    <button
                        @click="toggleRecoveryCode"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                    >
                        {{
                            useRecoveryCode
                                ? "Use authentication code"
                                : "Use a recovery code"
                        }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    code: "",
    recovery_code: "",
});

const useRecoveryCode = ref(false);

const handleTwoFactorChallenge = () => {
    if (useRecoveryCode.value) {
        // Handle recovery code verification
        console.log("Recovery code verification attempt", {
            recoveryCode: form.recovery_code,
        });
        form.post(route("two-factor.login"));
    } else {
        // Handle two-factor authentication code verification
        console.log("Two-factor authentication attempt", { code: form.code });
        form.post(route("two-factor.login"));
    }
};

const toggleRecoveryCode = () => {
    useRecoveryCode.value = !useRecoveryCode.value;
    form.code = "";
    form.recovery_code = "";
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

body {
    font-family: "Inter", sans-serif;
}
</style>
