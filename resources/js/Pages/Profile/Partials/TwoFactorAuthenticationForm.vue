<script setup>
import { ref, computed, watch } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import ConfirmsPassword from "@/Components/ConfirmsPassword.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    requiresConfirmation: Boolean,
});

const page = usePage();
const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);

const confirmationForm = useForm({ code: "" });

const twoFactorEnabled = computed(
    () => !enabling.value && page.props.auth.user?.two_factor_enabled
);

watch(twoFactorEnabled, () => {
    if (!twoFactorEnabled.value) {
        confirmationForm.reset();
        confirmationForm.clearErrors();
    }
});

const enableTwoFactorAuthentication = () => {
    enabling.value = true;

    router.post(
        route("two-factor.enable"),
        {},
        {
            preserveScroll: true,
            onSuccess: () =>
                Promise.all([
                    showQrCode(),
                    showSetupKey(),
                    showRecoveryCodes(),
                ]),
            onFinish: () => {
                enabling.value = false;
                confirming.value = props.requiresConfirmation;
            },
        }
    );
};

const showQrCode = () => {
    return axios.get(route("two-factor.qr-code")).then((response) => {
        qrCode.value = response.data.svg;
    });
};

const showSetupKey = () => {
    return axios.get(route("two-factor.secret-key")).then((response) => {
        setupKey.value = response.data.secretKey;
    });
};

const showRecoveryCodes = () => {
    return axios.get(route("two-factor.recovery-codes")).then((response) => {
        recoveryCodes.value = response.data;
    });
};

const confirmTwoFactorAuthentication = () => {
    confirmationForm.post(route("two-factor.confirm"), {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            confirming.value = false;
            qrCode.value = null;
            setupKey.value = null;
        },
    });
};

const regenerateRecoveryCodes = () => {
    axios
        .post(route("two-factor.recovery-codes"))
        .then(() => showRecoveryCodes());
};

const disableTwoFactorAuthentication = () => {
    disabling.value = true;

    router.delete(route("two-factor.disable"), {
        preserveScroll: true,
        onSuccess: () => {
            disabling.value = false;
            confirming.value = false;
        },
    });
};

const copyToClipboard = async (text) => {
    try {
        await navigator.clipboard.writeText(text);
        // You might want to add a toast notification here
    } catch (err) {
        console.error("Failed to copy text: ", err);
    }
};
</script>

<template>
    <div class="max-w-xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-yellow-400">
                Two Factor Authentication
            </h3>
            <p class="text-gray-100 mt-1">
                Add additional security to your account using two factor
                authentication.
            </p>
        </div>

        <div class="space-y-6">
            <!-- QR Code Section -->
            <div
                v-if="twoFactorEnabled && qrCode"
                class="bg-gray-800 rounded-lg p-6"
            >
                <h4 class="text-lg font-medium text-yellow-400 mb-4">
                    {{
                        confirming
                            ? "Scan the QR code or enter the setup key"
                            : "QR Code"
                    }}
                </h4>

                <!-- QR Code Display -->
                <div class="flex flex-col items-center">
                    <div
                        class="bg-gray-700 p-3 rounded-lg shadow-sm"
                        v-html="qrCode"
                    />

                    <div v-if="setupKey" class="mt-4 w-full">
                        <div
                            class="flex items-center justify-between p-3 bg-gray-700 rounded-lg shadow-sm"
                        >
                            <span class="font-mono text-sm text-gray-100">{{
                                setupKey
                            }}</span>
                            <Button
                                variant="outline"
                                size="sm"
                                @click="copyToClipboard(setupKey)"
                                class="bg-yellow-400 text-black hover:bg-yellow-300"
                            >
                                Copy Key
                            </Button>
                        </div>
                    </div>
                </div>

                <!-- Verification Input -->
                <div v-if="confirming" class="mt-6">
                    <label class="block text-sm font-medium text-gray-100 mb-2"
                        >Enter Verification Code</label
                    >
                    <div class="flex gap-3">
                        <Input
                            v-model="confirmationForm.code"
                            type="text"
                            inputmode="numeric"
                            class="font-mono bg-gray-700 text-gray-100"
                            placeholder="Enter 6-digit code"
                        />
                        <Button
                            @click="confirmTwoFactorAuthentication"
                            class="bg-yellow-400 text-black hover:bg-yellow-300"
                        >
                            Verify
                        </Button>
                    </div>
                    <InputError
                        :message="confirmationForm.errors.code"
                        class="mt-1"
                    />
                </div>
            </div>

            <!-- Recovery Codes -->
            <div
                v-if="recoveryCodes.length > 0 && !confirming"
                class="bg-gray-800 rounded-lg p-6"
            >
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-medium text-yellow-400">
                        Recovery Codes
                    </h4>
                    <ConfirmsPassword @confirmed="regenerateRecoveryCodes">
                        <Button
                            variant="outline"
                            size="sm"
                            class="bg-yellow-400 text-black hover:bg-yellow-300"
                        >
                            Regenerate
                        </Button>
                    </ConfirmsPassword>
                </div>

                <p class="text-sm text-gray-100 mb-4">
                    Store these recovery codes in a secure password manager.
                    They can be used to recover access to your account.
                </p>

                <div class="grid grid-cols-2 gap-3">
                    <div
                        v-for="code in recoveryCodes"
                        :key="code"
                        class="flex items-center justify-between p-2 bg-gray-700 rounded-md shadow-sm"
                    >
                        <code class="text-sm text-gray-100">{{ code }}</code>
                        <Button
                            variant="ghost"
                            size="sm"
                            @click="copyToClipboard(code)"
                            class="bg-yellow-400 text-black hover:bg-yellow-300"
                        >
                            Copy
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-start gap-3 pt-4">
                <template v-if="!twoFactorEnabled">
                    <ConfirmsPassword
                        @confirmed="enableTwoFactorAuthentication"
                    >
                        <Button
                            :disabled="enabling"
                            class="bg-yellow-400 text-black hover:bg-yellow-300"
                        >
                            {{ enabling ? "Enabling..." : "Enable 2FA" }}
                        </Button>
                    </ConfirmsPassword>
                </template>

                <template v-else>
                    <ConfirmsPassword
                        v-if="confirming"
                        @confirmed="confirmTwoFactorAuthentication"
                    >
                        <Button
                            :disabled="enabling"
                            class="bg-yellow-400 text-black hover:bg-yellow-300"
                        >
                            Confirm Setup
                        </Button>
                    </ConfirmsPassword>

                    <ConfirmsPassword
                        v-if="recoveryCodes.length === 0 && !confirming"
                        @confirmed="showRecoveryCodes"
                    >
                        <Button
                            variant="outline"
                            class="bg-yellow-400 text-black hover:bg-yellow-300"
                        >
                            View Recovery Codes
                        </Button>
                    </ConfirmsPassword>

                    <ConfirmsPassword
                        v-if="!confirming"
                        @confirmed="disableTwoFactorAuthentication"
                    >
                        <Button
                            variant="destructive"
                            :disabled="disabling"
                            class="bg-red-600 text-white hover:bg-red-500"
                        >
                            {{ disabling ? "Disabling..." : "Disable 2FA" }}
                        </Button>
                    </ConfirmsPassword>
                </template>
            </div>
        </div>
    </div>
</template>
