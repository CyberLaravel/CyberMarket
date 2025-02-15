<script setup>
import { ref } from "vue";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
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
import { useForm as inertiaUseForm } from "@inertiajs/vue3";
import { useForm as veeUseForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

const useRecoveryCode = ref(false);

const veeFormSchema = toTypedSchema(
    z
        .object({
            code: z.string().optional(),
            recovery_code: z.string().optional(),
        })
        .superRefine((data, ctx) => {
            if (!useRecoveryCode.value && !data.code) {
                ctx.addIssue({
                    code: "custom",
                    message: "Authentication code is required",
                    path: ["code"],
                });
            }
            if (useRecoveryCode.value && !data.recovery_code) {
                ctx.addIssue({
                    code: "custom",
                    message: "Recovery code is required",
                    path: ["recovery_code"],
                });
            }
        })
);

const veeForm = veeUseForm({
    validationSchema: veeFormSchema,
});

const inertiaForm = inertiaUseForm({
    code: "",
    recovery_code: "",
});

const handleTwoFactorChallenge = veeForm.handleSubmit(() => {
    if (useRecoveryCode.value) {
        inertiaForm.recovery_code = veeForm.values.recovery_code;
    } else {
        inertiaForm.code = veeForm.values.code;
    }

    inertiaForm.post(route("two-factor.login"), {
        onFinish: () => {
            inertiaForm.reset("code", "recovery_code");
        },
        onError: (errors) => {
            Object.keys(errors).forEach((key) => {
                veeForm.setFieldError(key, errors[key]);
            });
        },
    });
});

const toggleRecoveryCode = () => {
    useRecoveryCode.value = !useRecoveryCode.value;
    veeForm.resetForm();
    inertiaForm.reset("code", "recovery_code");
};
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
                    Two Factor Authentication
                </CardTitle>
                <CardDescription class="text-gray-100">
                    {{
                        useRecoveryCode
                            ? "Enter your recovery code"
                            : "Enter your authentication code"
                    }}
                </CardDescription>
            </CardHeader>

            <CardContent>
                <form
                    @submit.prevent="handleTwoFactorChallenge"
                    class="space-y-4"
                >
                    <div v-if="!useRecoveryCode">
                        <FormField v-slot="{ componentField }" name="code">
                            <FormItem>
                                <FormLabel class="text-gray-100"
                                    >Authentication Code</FormLabel
                                >
                                <FormControl>
                                    <Input
                                        class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                                        id="code"
                                        v-bind="componentField"
                                        type="text"
                                        inputmode="numeric"
                                        autocomplete="one-time-code"
                                        placeholder="Enter 6-digit code"
                                    />
                                </FormControl>
                                <FormMessage class="text-yellow-400" />
                            </FormItem>
                        </FormField>
                    </div>

                    <div v-else>
                        <FormField
                            v-slot="{ componentField }"
                            name="recovery_code"
                        >
                            <FormItem>
                                <FormLabel class="text-gray-100"
                                    >Recovery Code</FormLabel
                                >
                                <FormControl>
                                    <Input
                                        class="bg-gray-800 border-yellow-400 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-yellow-400"
                                        id="recovery_code"
                                        v-bind="componentField"
                                        type="text"
                                        placeholder="Enter recovery code"
                                    />
                                </FormControl>
                                <FormMessage class="text-yellow-400" />
                            </FormItem>
                        </FormField>
                    </div>

                    <Button
                        type="submit"
                        class="w-full bg-yellow-400 text-black hover:bg-yellow-300 transition-colors"
                    >
                        Verify
                    </Button>
                </form>
            </CardContent>

            <CardFooter class="text-center">
                <Button
                    variant="ghost"
                    class="w-full text-blue-300 hover:text-yellow-400 transition-colors"
                    @click="toggleRecoveryCode"
                >
                    {{
                        useRecoveryCode
                            ? "Use authentication code"
                            : "Use recovery code"
                    }}
                </Button>
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
