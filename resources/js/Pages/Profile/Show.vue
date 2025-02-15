<script setup>
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import TwoFactorAuthenticationForm from "./Partials/TwoFactorAuthenticationForm.vue";
import LogoutOtherBrowserSessionsForm from "./Partials/LogoutOtherBrowserSessionsForm.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    sessions: Array,
    confirmsTwoFactorAuthentication: Boolean,
});
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <!-- Page Header -->
                <div class="mb-12">
                    <h1
                        class="text-2xl font-bold font-['Orbitron'] text-yellow-400 glitch-text"
                    >
                        Account Settings
                    </h1>
                    <p class="mt-1 text-sm text-gray-100">
                        Manage your account settings and security preferences.
                    </p>
                </div>

                <div class="grid gap-x-16 gap-y-10 lg:grid-cols-2">
                    <!-- Left Column -->
                    <div class="space-y-10">
                        <!-- Profile Information Section -->
                        <section
                            class="bg-gray-800 rounded-xl border border-yellow-400 shadow-neon p-6"
                        >
                            <h2
                                class="text-base font-['Orbitron'] font-medium text-yellow-400 mb-6"
                            >
                                Profile Information
                            </h2>
                            <UpdateProfileInformationForm
                                :user="$page.props.auth.user"
                            />
                        </section>

                        <!-- Password Section -->
                        <section
                            class="bg-gray-800 rounded-xl border border-yellow-400 shadow-neon p-6"
                        >
                            <h2
                                class="text-base font-['Orbitron'] font-medium text-yellow-400 mb-6"
                            >
                                Password
                            </h2>
                            <UpdatePasswordForm />
                        </section>

                        <!-- Danger Zone -->
                        <section
                            class="bg-gray-800/50 rounded-xl border border-red-500 shadow-neon-red p-6"
                        >
                            <h2
                                class="text-base font-['Orbitron'] font-medium text-red-500 mb-6"
                            >
                                Danger Zone
                            </h2>
                            <DeleteUserForm />
                        </section>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-10">
                        <!-- Two Factor Authentication -->
                        <section
                            class="bg-gray-800 rounded-xl border border-yellow-400 shadow-neon p-6"
                        >
                            <h2
                                class="text-base font-['Orbitron'] font-medium text-yellow-400 mb-6"
                            >
                                Two-Factor Authentication
                            </h2>
                            <TwoFactorAuthenticationForm
                                :requires-confirmation="
                                    confirmsTwoFactorAuthentication
                                "
                            />
                        </section>

                        <!-- Browser Sessions -->
                        <section
                            class="bg-gray-800 rounded-xl border border-yellow-400 shadow-neon p-6"
                        >
                            <h2
                                class="text-base font-['Orbitron'] font-medium text-yellow-400 mb-6"
                            >
                                Browser Sessions
                            </h2>
                            <LogoutOtherBrowserSessionsForm
                                :sessions="sessions"
                            />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.shadow-neon {
    box-shadow: 0 0 5px theme("colors.yellow.400"),
        0 0 10px theme("colors.yellow.400/50");
}

.shadow-neon-red {
    box-shadow: 0 0 5px theme("colors.red.500"),
        0 0 10px theme("colors.red.500/50");
}

.glitch-text {
    text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75),
        -0.025em -0.05em 0 rgba(0, 255, 0, 0.75),
        0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
    animation: glitch 500ms infinite;
}

@keyframes glitch {
    0% {
        text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75),
            -0.05em -0.025em 0 rgba(0, 255, 0, 0.75),
            -0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
    }
    14% {
        text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75),
            -0.05em -0.025em 0 rgba(0, 255, 0, 0.75),
            -0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
    }
    15% {
        text-shadow: -0.05em -0.025em 0 rgba(255, 0, 0, 0.75),
            0.025em 0.025em 0 rgba(0, 255, 0, 0.75),
            -0.05em -0.05em 0 rgba(0, 0, 255, 0.75);
    }
    49% {
        text-shadow: -0.05em -0.025em 0 rgba(255, 0, 0, 0.75),
            0.025em 0.025em 0 rgba(0, 255, 0, 0.75),
            -0.05em -0.05em 0 rgba(0, 0, 255, 0.75);
    }
    50% {
        text-shadow: 0.025em 0.05em 0 rgba(255, 0, 0, 0.75),
            0.05em 0 0 rgba(0, 255, 0, 0.75), 0 -0.05em 0 rgba(0, 0, 255, 0.75);
    }
    99% {
        text-shadow: 0.025em 0.05em 0 rgba(255, 0, 0, 0.75),
            0.05em 0 0 rgba(0, 255, 0, 0.75), 0 -0.05em 0 rgba(0, 0, 255, 0.75);
    }
    100% {
        text-shadow: -0.025em 0 0 rgba(255, 0, 0, 0.75),
            -0.025em -0.025em 0 rgba(0, 255, 0, 0.75),
            -0.025em -0.05em 0 rgba(0, 0, 255, 0.75);
    }
}
</style>
