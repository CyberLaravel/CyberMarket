<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import {
    Card,
    CardContent,
    CardDescription,
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

const veeFormSchema = toTypedSchema(
    z.object({
        password: z.string().min(1, "Password is required"),
    })
);

const veeForm = veeUseForm({
    validationSchema: veeFormSchema,
});

const inertiaForm = useForm({
    password: "",
});

const handleConfirmPassword = veeForm.handleSubmit(() => {
    inertiaForm.password = veeForm.values.password;
    inertiaForm.post(route("password.confirm"), {
        onFinish: () => {
            inertiaForm.reset();
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
    <div class="min-h-screen flex items-center justify-center bg-gray-900">
        <Card class="w-full max-w-md border-yellow-400 bg-gray-800">
            <CardHeader class="text-center">
                <div class="mx-auto mb-4 size-12 text-yellow-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                        />
                    </svg>
                </div>
                <CardTitle
                    class="text-yellow-400 text-2xl font-orbitron glitch-text"
                >
                    Confirm Password
                </CardTitle>
                <CardDescription class="text-gray-100">
                    Please confirm your password before continuing
                </CardDescription>
            </CardHeader>

            <CardContent>
                <form @submit.prevent="handleConfirmPassword" class="space-y-4">
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

                    <Button
                        type="submit"
                        class="w-full bg-yellow-400 text-black hover:bg-yellow-300 transition-colors"
                    >
                        Confirm Password
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
