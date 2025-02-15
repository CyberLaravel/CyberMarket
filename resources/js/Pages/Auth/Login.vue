<script setup>
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Link } from "@inertiajs/vue3";
import { Checkbox } from "@/Components/ui/checkbox";
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
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const veeFormSchema = toTypedSchema(
    z.object({
        email: z.string().email("Invalid email address"),
        password: z.string().min(1, "Password is required"),
        remember: z.boolean().optional(),
    })
);

const veeForm = veeUseForm({
    validationSchema: veeFormSchema,
});

const inertiaForm = useForm({
    email: "",
    password: "",
    remember: false,
});

const handleLogin = veeForm.handleSubmit(() => {
    inertiaForm.email = veeForm.values.email;
    inertiaForm.password = veeForm.values.password;
    inertiaForm.remember = veeForm.values.remember;

    inertiaForm.post(route("login"), {
        onFinish: () => inertiaForm.reset("password"),
        onError: (errors) => {
            Object.keys(errors).forEach((key) => {
                veeForm.setFieldError(key, errors[key]);
            });
        },
    });
});
</script>

<template>
   <AppLayout>
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
                    Welcome Back
                </CardTitle>
                <CardDescription class="text-gray-100">
                    Please sign in to your account
                </CardDescription>
            </CardHeader>

            <CardContent>
                <div
                    v-if="status"
                    class="mb-4 text-sm font-medium text-yellow-400"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="handleLogin" class="space-y-4">
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel class="text-gray-100">Email</FormLabel>
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

                    <FormField v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormLabel class="text-gray-100"
                                >Password</FormLabel
                            >
                            <FormControl>
                                <Input
                                    class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                                    id="password"
                                    v-bind="componentField"
                                    type="password"
                                    placeholder="Enter your password"
                                />
                            </FormControl>
                            <FormMessage class="text-yellow-400" />
                        </FormItem>
                    </FormField>

                    <FormField v-slot="{ value, handleChange }" name="remember">
                        <FormItem class="flex items-center space-x-2 space-y-0">
                            <FormControl>
                                <Checkbox
                                    :checked="value"
                                    @update:checked="handleChange"
                                />
                            </FormControl>
                            <FormLabel
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-gray-100"
                            >
                                Remember me
                            </FormLabel>
                        </FormItem>
                    </FormField>

                    <Button
                        type="submit"
                        class="w-full bg-yellow-400 text-black hover:bg-yellow-300 transition-colors"
                    >
                        Sign in
                    </Button>
                </form>
            </CardContent>

            <CardFooter class="flex flex-col space-y-2 text-center">
                <p class="text-sm text-gray-100">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-blue-300 hover:text-yellow-400 transition-colors"
                    >
                        Forgot your password?
                    </Link>
                </p>
                <p class="text-sm text-gray-100">
                    Don't have an account?
                    <Link
                        :href="route('register')"
                        class="text-blue-300 hover:text-yellow-400 transition-colors"
                    >
                        Sign up
                    </Link>
                </p>
            </CardFooter>
        </Card>
    </div>
   </AppLayout>
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
