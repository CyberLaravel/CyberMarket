<script setup>
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { toast } from "@/components/ui/toast";

import { Head, Link } from "@inertiajs/vue3";

defineProps(["canResetPassword", "status", "errors"]);
const emit = defineEmits(["submit"]);

const email = defineModel("email");
const password = defineModel("password");
const rememberMe = defineModel("rememberMe");

function handleLogin() {
    toast({
        title: "Login Attempt",
        description: "Login functionality not implemented in this demo.",
    });

    emit("submit", { email, password, rememberMe });
}
</script>

<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <Card class="w-full max-w-md">
            <CardHeader>
                <CardTitle>Login</CardTitle>
                <CardDescription>
                    Enter your credentials to access your account
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="handleLogin" class="space-y-4">
                    <div class="space-y-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            v-model="email"
                            type="email"
                            placeholder="m@example.com"
                        />
                        <p v-if="errors.email" class="text-sm text-red-500">
                            {{ errors.email }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            v-model="password"
                            type="password"
                        />
                        <p v-if="errors.password" class="text-sm text-red-500">
                            {{ errors.password }}
                        </p>
                    </div>
                    <Button type="submit" class="w-full">Login</Button>
                </form>
            </CardContent>
            <CardFooter class="flex justify-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <Link
                        :href="route('register')"
                        class="text-blue-600 hover:underline"
                        >Register</Link
                    >
                </p>
            </CardFooter>
        </Card>
    </div>
</template>
