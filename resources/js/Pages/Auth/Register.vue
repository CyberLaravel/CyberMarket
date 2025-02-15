<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
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
import { useToast } from "@/Components/ui/toast";

import { useForm as inertiaUseForm, Link } from "@inertiajs/vue3";
import { useForm as veeUseForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import AppLayout from "@/Layouts/AppLayout.vue";

const veeFormSchema = toTypedSchema(
    z
        .object({
            name: z
                .string()
                .min(2, "Name must be at least 2 characters")
                .max(50),
            email: z.string().email("Invalid email address"),
            password: z
                .string()
                .min(8, "Password must be at least 8 characters"),
            password_confirmation: z.string(),
            terms: z.boolean().refine((val) => val === true, {
                message: "You must accept the terms and conditions",
            }),
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
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const { toast } = useToast();

const handleRegister = veeForm.handleSubmit(() => {
    inertiaForm.name = veeForm.values.name;
    inertiaForm.email = veeForm.values.email;
    inertiaForm.password = veeForm.values.password;
    inertiaForm.password_confirmation = veeForm.values.password_confirmation;
    inertiaForm.terms = veeForm.values.terms;

    inertiaForm.post(route("register"), {
        onSuccess: () => {
            toast({
                title: "Registration successful",
                description: "Your account has been created.",
            });
        },
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
                        <svg
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                            />
                        </svg>
                    </div>
                    <CardTitle
                        class="text-yellow-400 text-2xl font-orbitron glitch-text"
                    >
                        Create an Account
                    </CardTitle>
                    <CardDescription class="text-gray-100">
                        Enter your details to create your account
                    </CardDescription>
                </CardHeader>

                <CardContent>
                    <form @submit.prevent="handleRegister" class="space-y-4">
                        <FormField v-slot="{ componentField }" name="name">
                            <FormItem>
                                <FormLabel class="text-gray-100"
                                    >Name</FormLabel
                                >
                                <FormControl>
                                    <Input
                                        class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                                        id="name"
                                        v-bind="componentField"
                                        type="text"
                                        placeholder="John Doe"
                                    />
                                </FormControl>
                                <FormMessage class="text-yellow-400" />
                            </FormItem>
                        </FormField>

                        <FormField v-slot="{ componentField }" name="email">
                            <FormItem>
                                <FormLabel class="text-gray-100"
                                    >Email</FormLabel
                                >
                                <FormControl>
                                    <Input
                                        class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                                        id="email"
                                        v-bind="componentField"
                                        type="email"
                                        placeholder="john@example.com"
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
                                    >Confirm Password</FormLabel
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

                        <FormField
                            v-slot="{ value, handleChange }"
                            name="terms"
                        >
                            <FormItem
                                class="flex flex-row items-start space-x-3 space-y-0 rounded-md border-yellow-400 border bg-gray-800 p-4"
                            >
                                <FormControl>
                                    <Checkbox
                                        :checked="value"
                                        @update:checked="handleChange"
                                    />
                                </FormControl>
                                <div class="space-y-1 leading-none">
                                    <FormLabel class="text-gray-100">
                                        Accept terms and conditions
                                    </FormLabel>
                                    <FormDescription class="text-gray-400">
                                        By creating an account, you agree to our
                                        Terms of Service and Privacy Policy.
                                    </FormDescription>
                                </div>
                            </FormItem>
                        </FormField>

                        <Button
                            type="submit"
                            class="w-full bg-yellow-400 text-black hover:bg-yellow-300 transition-colors"
                        >
                            Register
                        </Button>
                    </form>
                </CardContent>

                <CardFooter class="text-center">
                    <p class="text-sm text-gray-100">
                        Already have an account?
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
