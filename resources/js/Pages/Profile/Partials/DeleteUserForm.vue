<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import ActionSection from "@/Components/ActionSection.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: "",
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <ActionSection>
        <template #title> Delete Account </template>

        <template #description> Permanently delete your account. </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <button
                    @click="confirmUserDeletion"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
                >
                    Delete Account
                </button>
            </div>

            <DialogModal :show="confirmingUserDeletion" @close="closeModal">
                <template #title> Delete Account </template>

                <template #content>
                    Are you sure you want to delete your account? Once your
                    account is deleted, all of its resources and data will be
                    permanently deleted. Please enter your password to confirm
                    you would like to permanently delete your account.

                    <div class="mt-4">
                        <input
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Password"
                            autocomplete="current-password"
                            @keyup.enter="deleteUser"
                        />

                        <InputError
                            :message="form.errors.password"
                            class="mt-2"
                        />
                    </div>
                </template>

                <template #footer>
                    <button
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition mr-2"
                    >
                        Cancel
                    </button>

                    <button
                        @click="deleteUser"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Delete Account
                    </button>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
