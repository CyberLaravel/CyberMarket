<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { useToast } from "@/Components/ui/toast";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog";
import { Monitor, Smartphone } from "lucide-vue-next";

defineProps({
    sessions: Array,
});

const confirmingLogout = ref(false);
const passwordInput = ref(null);
const { toast } = useToast();

const form = useForm({
    password: "",
});

const confirmLogout = () => {
    confirmingLogout.value = true;
    setTimeout(() => passwordInput.value?.focus(), 250);
};

const logoutOtherBrowserSessions = () => {
    form.delete(route("other-browser-sessions.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            toast({
                title: "Sessions Logged Out",
                description: "All other browser sessions have been logged out.",
            });
        },
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingLogout.value = false;
    form.reset();
};
</script>

<template>
    <div class="max-w-xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-yellow-400">
                Browser Sessions
            </h3>
            <p class="text-gray-100 mt-1">
                Manage and log out your active sessions on other browsers and
                devices.
            </p>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 space-y-6">
            <p class="text-sm text-gray-100">
                If necessary, you may log out of all of your other browser
                sessions across all of your devices. Some of your recent
                sessions are listed below; however, this list may not be
                exhaustive. If you feel your account has been compromised, you
                should also update your password.
            </p>

            <!-- Active Sessions List -->
            <div v-if="sessions.length > 0" class="space-y-4">
                <div
                    v-for="(session, i) in sessions"
                    :key="i"
                    class="flex items-center gap-4 p-4 bg-gray-700 rounded-lg shadow-sm"
                >
                    <div class="text-gray-100">
                        <Monitor
                            v-if="session.agent.is_desktop"
                            class="h-6 w-6"
                        />
                        <Smartphone v-else class="h-6 w-6" />
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="text-sm text-gray-100">
                            {{ session.agent.platform ?? "Unknown" }} -
                            {{ session.agent.browser ?? "Unknown" }}
                        </div>

                        <div class="text-xs space-x-2">
                            <span class="text-gray-100">{{
                                session.ip_address
                            }}</span>
                            <span
                                v-if="session.is_current_device"
                                class="text-green-500 font-medium"
                            >
                                This device
                            </span>
                            <span v-else class="text-gray-100">
                                Last active {{ session.last_active }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout Button -->
            <div class="mt-6">
                <Button
                    @click="confirmLogout"
                    class="bg-yellow-400 text-black hover:bg-yellow-300"
                >
                    Log Out Other Browser Sessions
                </Button>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <Dialog :open="confirmingLogout" @update:open="closeModal">
            <DialogContent class="bg-gray-800">
                <DialogHeader>
                    <DialogTitle class="text-yellow-400"
                        >Log Out Other Browser Sessions</DialogTitle
                    >
                    <DialogDescription class="text-gray-100">
                        Please enter your password to confirm you would like to
                        log out of your other browser sessions.
                    </DialogDescription>
                </DialogHeader>

                <div class="space-y-4">
                    <Input
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        placeholder="Password"
                        autocomplete="current-password"
                        class="bg-gray-700 text-gray-100"
                        @keyup.enter="logoutOtherBrowserSessions"
                    />

                    <p v-if="form.errors.password" class="text-sm text-red-500">
                        {{ form.errors.password }}
                    </p>
                </div>

                <DialogFooter>
                    <div class="flex gap-3">
                        <Button variant="secondary" @click="closeModal">
                            Cancel
                        </Button>

                        <Button
                            variant="destructive"
                            :disabled="form.processing"
                            @click="logoutOtherBrowserSessions"
                            class="bg-red-600 text-white hover:bg-red-500"
                        >
                            {{
                                form.processing
                                    ? "Logging out..."
                                    : "Log Out Sessions"
                            }}
                        </Button>
                    </div>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
</template>
