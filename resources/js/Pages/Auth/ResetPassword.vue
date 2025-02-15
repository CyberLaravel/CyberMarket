<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/form";
import { useForm as inertiaUseForm } from "@inertiajs/vue3";
import { useForm as veeUseForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

const props = defineProps({
    email: String,
    token: String,
});

const veeFormSchema = toTypedSchema(
    z
        .object({
            password: z
                .string()
                .min(8, "Password must be at least 8 characters"),
            password_confirmation: z.string(),
        })
        .refine((data) => data.password === data.password_confirmation, {
            message: "Passwords don't match",
            path: ["password_confirmation"],
        })
);

const veeForm = veeUseForm({
    validationSchema: veeFormSchema,
});

const inertiaForm = inertiaUseForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const handleResetPassword = veeForm.handleSubmit(() => {
    inertiaForm.password = veeForm.values.password;
    inertiaForm.password_confirmation = veeForm.values.password_confirmation;

    inertiaForm.post(route("password.update"), {
        onFinish: () => inertiaForm.reset("password", "password_confirmation"),
        onError: (errors) => {
            Object.keys(errors).forEach((key) => {
                veeForm.setFieldError(key, errors[key]);
            });
        },
    });
});
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-900">
        <Card class="w-full max-w-md border-yellow-400 bg-gray-800">
            <CardHeader class="text-center">
                <div class="mx-auto mb-4 size-12 text-yellow-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                        />
                    </svg>
                </div>
                <CardTitle
                    class="text-yellow-400 text-2xl font-orbitron glitch-text"
                >
                    Reset Password
                </CardTitle>
                <CardDescription class="text-gray-100">
                    Enter your new password
                </CardDescription>
            </CardHeader>

            <CardContent>
                <form @submit.prevent="handleResetPassword" class="space-y-4">
                    <FormField v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormLabel class="text-gray-100"
                                >New Password</FormLabel
                            >
                            <FormControl>
                                <Input
                                    class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                                    id="password"
                                    v-bind="componentField"
                                    type="password"
                                    placeholder="********"
                                />
                            </FormControl>
                            <FormMessage class="text-yellow-400" />
                        </FormItem>
                    </FormField>

                    <FormField
                        v-slot="{ componentField }"
                        name="password_confirmation"
                    >
                        <FormItem>
                            <FormLabel class="text-gray-100"
                                >Confirm New Password</FormLabel
                            >
                            <FormControl>
                                <Input
                                    class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                                    id="password_confirmation"
                                    v-bind="componentField"
                                    type="password"
                                    placeholder="********"
                                />
                            </FormControl>
                            <FormMessage class="text-yellow-400" />
                        </FormItem>
                    </FormField>

                    <Button
                        type="submit"
                        class="w-full bg-yellow-400 text-black hover:bg-yellow-300 transition-colors"
                    >
                        Reset Password
                    </Button>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<style scoped>
.glitch-text {
    text-shadow: 0 0 10px rgba(255, 214, 0, 0.8),
        0 0 20px rgba(255, 214, 0, 0.5), 0 0 30px rgba(255, 214, 0, 0.3);
    animation: glitch 3s infinite;
}

@keyframes glitch {
    0% {
        transform: translate(0);
    }
    20% {
        transform: translate(-2px, 2px);
    }
    40% {
        transform: translate(-2px, -2px);
    }
    60% {
        transform: translate(2px, 2px);
    }
    80% {
        transform: translate(2px, -2px);
    }
    100% {
        transform: translate(0);
    }
}
</style>
