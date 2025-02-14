<script setup>
import { ref } from "vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import TwoFactorAuthenticationForm from "./Partials/TwoFactorAuthenticationForm.vue";
import LogoutOtherBrowserSessionsForm from "./Partials/LogoutOtherBrowserSessionsForm.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";

const props = defineProps({
    sessions: Array,
    confirmsTwoFactorAuthentication: Boolean,
});

const activeTab = ref("profile");
</script>

<template>
    <div class="min-h-screen bg-gray-900 text-blue-300">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-neon rounded-lg overflow-hidden">
                <div class="border-b border-gray-700 p-6">
                    <h2 class="text-3xl font-bold text-yellow-400">
                        User Profile
                    </h2>
                    <p class="mt-1 text-sm">
                        Manage your account settings and security
                    </p>
                </div>

                <div class="flex border-b border-gray-700">
                    <button
                        v-for="tab in [
                            'profile',
                            'password',
                            '2fa',
                            'sessions',
                            'delete',
                        ]"
                        :key="tab"
                        @click="activeTab = tab"
                        :class="[
                            'px-4 py-2 text-sm font-medium',
                            activeTab === tab
                                ? 'text-yellow-400 border-b-2 border-yellow-400'
                                : 'text-gray-400 hover:text-blue-300',
                        ]"
                    >
                        {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
                    </button>
                </div>

                <div class="p-6">
                    <UpdateProfileInformationForm
                        v-if="activeTab === 'profile'"
                        :user="$page.props.auth.user"
                    />
                    <UpdatePasswordForm v-if="activeTab === 'password'" />
                    <TwoFactorAuthenticationForm
                        v-if="activeTab === '2fa'"
                        :requires-confirmation="confirmsTwoFactorAuthentication"
                    />
                    <LogoutOtherBrowserSessionsForm
                        v-if="activeTab === 'sessions'"
                        :sessions="sessions"
                    />
                    <DeleteUserForm v-if="activeTab === 'delete'" />
                </div>
            </div>
        </div>
    </div>
</template>
