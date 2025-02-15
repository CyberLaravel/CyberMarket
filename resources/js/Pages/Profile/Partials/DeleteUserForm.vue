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

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const { toast } = useToast();

const form = useForm({
    password: "",
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    setTimeout(() => passwordInput.value?.focus(), 250);
};

const deleteUser = () => {
    form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            toast({
                title: "Account Deleted",
                description: "Your account has been permanently deleted.",
            });
        },
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <div class="max-w-xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-yellow-400">
                Delete Account
            </h3>
            <p class="text-gray-100 mt-1">
                Permanently delete your account and all associated data.
            </p>
        </div>

        <div class="bg-gray-800 rounded-lg p-6">
            <div class="space-y-4">
                <div class="text-sm text-gray-100">
                    Once your account is deleted, all of its resources and data
                    will be permanently deleted. Before deleting your account,
                    please download any data or information that you wish to
                    retain.
                </div>

                <div class="pt-2">
                    <Button variant="destructive" @click="confirmUserDeletion">
                        Delete Account
                    </Button>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <Dialog :open="confirmingUserDeletion" @update:open="closeModal">
            <DialogContent class="bg-gray-800">
                <DialogHeader>
                    <DialogTitle class="text-yellow-400"
                        >Delete Account</DialogTitle
                    >
                    <DialogDescription class="text-gray-100">
                        Are you sure you want to delete your account? Once your
                        account is deleted, all of its resources and data will
                        be permanently deleted. Please enter your password to
                        confirm you would like to permanently delete your
                        account.
                    </DialogDescription>
                </DialogHeader>

                <div class="space-y-4">
                    <Input
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        placeholder="Password"
                        autocomplete="current-password"
                        class="w-full bg-gray-700 text-gray-100"
                        @keyup.enter="deleteUser"
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
                            @click="deleteUser"
                        >
                            {{
                                form.processing
                                    ? "Deleting..."
                                    : "Delete Account"
                            }}
                        </Button>
                    </div>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
</template>
