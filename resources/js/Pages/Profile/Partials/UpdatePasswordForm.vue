<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { useToast } from "@/Components/ui/toast";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const { toast } = useToast();

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("user-password.update"), {
        errorBag: "updatePassword",
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast({
                title: "Password Updated",
                description: "Your password has been successfully updated.",
            });
        },
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value?.focus();
            }
            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value?.focus();
            }
        },
    });
};
</script>

<template>
    <div class="max-w-xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-yellow-400">
                Update Password
            </h3>
            <p class="text-gray-100 mt-1">
                Ensure your account is using a long, random password to stay
                secure.
            </p>
        </div>

        <form @submit.prevent="updatePassword" class="space-y-6">
            <div class="bg-gray-800 rounded-lg p-6 space-y-4">
                <!-- Current Password -->
                <div class="space-y-2">
                    <Label
                        for="current_password"
                        class="text-sm font-medium text-gray-100"
                    >
                        Current Password
                    </Label>
                    <Input
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        type="password"
                        class="w-full bg-gray-700 text-gray-100"
                        autocomplete="current-password"
                    />
                    <p
                        v-if="form.errors.current_password"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors.current_password }}
                    </p>
                </div>

                <!-- New Password -->
                <div class="space-y-2">
                    <Label
                        for="password"
                        class="text-sm font-medium text-gray-100"
                    >
                        New Password
                    </Label>
                    <Input
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="w-full bg-gray-700 text-gray-100"
                        autocomplete="new-password"
                    />
                    <p v-if="form.errors.password" class="text-sm text-red-500">
                        {{ form.errors.password }}
                    </p>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <Label
                        for="password_confirmation"
                        class="text-sm font-medium text-gray-100"
                    >
                        Confirm Password
                    </Label>
                    <Input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="w-full bg-gray-700 text-gray-100"
                        autocomplete="new-password"
                    />
                    <p
                        v-if="form.errors.password_confirmation"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors.password_confirmation }}
                    </p>
                </div>
            </div>

            <!-- Action Button -->
            <div class="flex justify-start">
                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full sm:w-auto bg-yellow-400 text-black hover:bg-yellow-300"
                >
                    {{ form.processing ? "Updating..." : "Update Password" }}
                </Button>
            </div>
        </form>
    </div>
</template>
