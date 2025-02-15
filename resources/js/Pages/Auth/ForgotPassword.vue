<script setup>
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Link } from "@inertiajs/vue3";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/form";
import { useForm as veeUseForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

defineProps({
    status: String,
});

const veeFormSchema = toTypedSchema(
    z.object({
        email: z.string().email("Invalid email address"),
    })
);

const veeForm = veeUseForm({
    validationSchema: veeFormSchema,
});

const inertiaForm = useForm({
    email: "",
});

const handleForgotPassword = veeForm.handleSubmit(() => {
    inertiaForm.email = veeForm.values.email;
    inertiaForm.post(route("password.email"), {
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
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                    </svg>
                </div>
                <CardTitle
                    class="text-yellow-400 text-2xl font-orbitron glitch-text"
                >
                    Forgot Password
                </CardTitle>
                <CardDescription class="text-gray-100">
                    Enter your email to reset your password
                </CardDescription>
            </CardHeader>

            <CardContent>
                <div
                    v-if="status"
                    class="mb-4 text-sm font-medium text-yellow-400"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="handleForgotPassword" class="space-y-4">
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel class="text-gray-100"
                                >Email Address</FormLabel
                            >
                            <FormControl>
                                <Input
                                    class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                                    id="email"
                                    v-bind="componentField"
                                    type="email"
                                    placeholder="name@example.com"
                                />
                            </FormControl>
                            <FormMessage class="text-yellow-400" />
                        </FormItem>
                    </FormField>

                    <Button
                        type="submit"
                        class="w-full bg-yellow-400 text-black hover:bg-yellow-300 transition-colors"
                    >
                        Send Reset Link
                    </Button>
                </form>
            </CardContent>

            <CardFooter class="flex justify-center">
                <p class="text-sm text-gray-100">
                    Remember your password?
                    <Link
                        :href="route('login')"
                        class="text-blue-300 hover:text-yellow-400 transition-colors"
                    >
                        Sign in
                    </Link>
                </p>
            </CardFooter>
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
