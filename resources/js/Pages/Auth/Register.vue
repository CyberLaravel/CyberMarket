<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
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
import { toast } from "@/Components/ui/toast";

import { useForm as inertiaUseForm, Link } from "@inertiajs/vue3";
import { useForm as veeUseForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";

import * as z from "zod";

const veeFormFormSchema = toTypedSchema(
    z.object({
        name: z.string().min(2).max(50),
        email: z.string(),
        password: z.string(),
        password_confirmation: z.string(),
        terms: z.boolean(),
    })
);

const veeForm = veeUseForm({
    validationSchema: veeFormFormSchema,
});

const inertiaForm = inertiaUseForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const handleRegister = veeForm.handleSubmit(() => {
    // Set values from veeForm to inertiaForm
    inertiaForm.name = veeForm.values.name;
    inertiaForm.email = veeForm.values.email;
    inertiaForm.password = veeForm.values.password;
    inertiaForm.password_confirmation = veeForm.values.password_confirmation;
    inertiaForm.terms = veeForm.values.terms;

    inertiaForm.post(route("register"), {
        onFinish: () => {
            inertiaForm.reset("password", "password_confirmation");
        },

        onError: (errors) => {
            // Map the errors to the corresponding fields in the veeForm
            Object.keys(errors).forEach((key) => {
                veeForm.setFieldError(key, errors[key]);
            });
        },
    });
});
</script>

<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <Card class="w-full max-w-md">
            <CardHeader>
                <CardTitle>Register</CardTitle>
                <CardDescription
                    >Enter your credentials to create a new
                    account</CardDescription
                >
            </CardHeader>
            <CardContent>
                <form @submit="handleRegister" class="space-y-4">
                    <FormField v-slot="{ componentField }" name="name">
                        <FormItem>
                            <FormLabel>Name</FormLabel>
                            <FormControl>
                                <Input
                                    id="name"
                                    v-bind="componentField"
                                    type="text"
                                    placeholder="Joe duo"
                                />
                            </FormControl>
                            <FormDescription>
                                This is your public display name.
                            </FormDescription>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel>Email</FormLabel>
                            <FormControl>
                                <Input
                                    id="email"
                                    v-bind="componentField"
                                    type="email"
                                    placeholder="me@example.com"
                                />
                            </FormControl>
                            <FormDescription>
                                This is your Email.
                            </FormDescription>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormLabel>Password</FormLabel>
                            <FormControl>
                                <Input
                                    id="password"
                                    v-bind="componentField"
                                    type="password"
                                    placeholder="******"
                                />
                            </FormControl>
                            <FormDescription>
                                This is your password.
                            </FormDescription>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField
                        v-slot="{ componentField }"
                        name="password_confirmation"
                    >
                        <FormItem>
                            <FormLabel>Confirm Password</FormLabel>
                            <FormControl>
                                <Input
                                    id="password_confirmation"
                                    v-bind="componentField"
                                    type="password"
                                    placeholder="******"
                                />
                            </FormControl>
                            <FormDescription>
                                This is your public display name.
                            </FormDescription>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField
                        v-slot="{ value, handleChange }"
                        type="checkbox"
                        name="terms"
                    >
                        <FormItem
                            class="flex flex-row items-start gap-x-3 space-y-0 rounded-md border p-4"
                        >
                            <FormControl>
                                <Checkbox
                                    :checked="value"
                                    @update:checked="handleChange"
                                />
                            </FormControl>
                            <div class="space-y-1 leading-none">
                                <FormLabel
                                    >Accept terms and conditions</FormLabel
                                >
                                <FormDescription>
                                    Accept terms and conditions
                                </FormDescription>
                                <FormMessage />
                            </div>
                        </FormItem>
                    </FormField>

                    <Button type="submit" class="w-full">Register</Button>
                </form>
            </CardContent>
            <CardFooter class="flex justify-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <Link
                        :href="route('login')"
                        class="text-blue-600 hover:underline"
                        >Login</Link
                    >
                </p>
            </CardFooter>
        </Card>
    </div>
</template>
