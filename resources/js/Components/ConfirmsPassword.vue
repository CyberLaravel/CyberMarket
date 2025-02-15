<script setup>
import { ref, reactive, nextTick } from "vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";

const emit = defineEmits(["confirmed"]);

defineProps({
    title: {
        type: String,
        default: "Confirm Password",
    },
    content: {
        type: String,
        default: "For your security, please confirm your password to continue.",
    },
    button: {
        type: String,
        default: "Confirm",
    },
});

const confirmingPassword = ref(false);

const form = reactive({
    password: "",
    error: "",
    processing: false,
});

const passwordInput = ref(null);

const startConfirmingPassword = () => {
    axios.get(route("password.confirmation")).then((response) => {
        if (response.data.confirmed) {
            emit("confirmed");
        } else {
            confirmingPassword.value = true;

            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios
        .post(route("password.confirm"), {
            password: form.password,
        })
        .then(() => {
            form.processing = false;

            closeModal();
            nextTick().then(() => emit("confirmed"));
        })
        .catch((error) => {
            form.processing = false;
            form.error = error.response.data.errors.password[0];
            passwordInput.value.focus();
        });
};

const closeModal = () => {
    confirmingPassword.value = false;
    form.password = "";
    form.error = "";
};
</script>

<template>
    <span class="inline-flex">
        <span @click="startConfirmingPassword" class="cursor-pointer">
            <slot />
        </span>

        <Dialog :open="confirmingPassword" @update:open="closeModal">
            <DialogContent class="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>{{ title }}</DialogTitle>
                    <DialogDescription>
                        {{ content }}
                    </DialogDescription>
                </DialogHeader>

                <div class="mt-6 space-y-4">
                    <Input
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="w-full"
                        placeholder="Password"
                        autocomplete="current-password"
                        @keyup.enter="confirmPassword"
                    />

                    <p v-if="form.error" class="text-sm text-destructive">
                        {{ form.error }}
                    </p>
                </div>

                <DialogFooter class="gap-3">
                    <Button variant="outline" @click="closeModal">
                        Cancel
                    </Button>

                    <Button
                        :disabled="form.processing"
                        @click="confirmPassword"
                    >
                        {{ button }}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </span>
</template>
