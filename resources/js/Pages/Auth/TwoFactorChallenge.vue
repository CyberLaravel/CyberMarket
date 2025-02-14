<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { useForm as inertiaUseForm } from "@inertiajs/vue3";
import { ref } from "vue";
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
import { z } from "zod";
import { toTypedSchema } from "@vee-validate/zod";

const veeFormFormSchema = toTypedSchema(
    z.object({
        code: z
            .string()
            .optional()
            .refine(
                (value) => {
                    return useRecoveryCode.value || value?.length > 0;
                },
                {
                    message:
                        "Authentication code is required when not using recovery code.",
                }
            ),
        recovery_code: z
            .string()
            .optional()
            .refine(
                (value) => {
                    return (
                        !useRecoveryCode.value ||
                        (useRecoveryCode.value && value?.length > 0)
                    );
                },
                {
                    message:
                        "Recovery code is required when using recovery code.",
                }
            ),
    })
);

const veeForm = veeUseForm({
    validationSchema: veeFormFormSchema,
});

const inertiaForm = inertiaUseForm({
    code: "",
    recovery_code: "",
});

const useRecoveryCode = ref(false);

const handleTwoFactorChallenge = veeForm.handleSubmit(() => {
    if (useRecoveryCode.value) {
        // Handle recovery code verification
        console.log("Recovery code verification attempt", {
            recoveryCode: inertiaForm.recovery_code,
        });
        inertiaForm.recovery_code = veeForm.values.recovery_code;
        inertiaForm.post(route("two-factor.login"), {
            onFinish: () => {
                inertiaForm.reset("code", "recovery_code");
            },
            onError: (errors) => {
                // Map the errors to the corresponding fields in the veeForm
                Object.keys(errors).forEach((key) => {
                    veeForm.setFieldError(key, errors[key]);
                });
            },
        });
    } else {
        // Handle two-factor authentication code verification
        console.log("Two-factor authentication attempt", {
            code: inertiaForm.code,
        });
        inertiaForm.code = veeForm.values.code;
        inertiaForm.post(route("two-factor.login"), {
            onFinish: () => {
                inertiaForm.reset("code", "recovery_code");
            },
            onError: (errors) => {
                // Map the errors to the corresponding fields in the veeForm
                Object.keys(errors).forEach((key) => {
                    veeForm.setFieldError(key, errors[key]);
                });
            },
        });
    }
});

const toggleRecoveryCode = () => {
    useRecoveryCode.value = !useRecoveryCode.value;
    veeForm.resetForm();
    inertiaForm.reset("code", "recovery_code");
};
</script>

<template>
    {{ veeForm.errors }}
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <Card class="w-full max-w-md">
            <CardHeader>
                <CardTitle> Two-Factor Authentication </CardTitle>
                <CardDescription>
                    {{
                        useRecoveryCode
                            ? "Enter your recovery code"
                            : "Enter the code from your authenticator app"
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
                                <FormLabel>Authentication Code</FormLabel>
                                <FormControl>
                                    <Input
                                        id="code"
                                        v-bind="componentField"
                                        type="text"
                                        placeholder="123456"
                                    />
                                </FormControl>
                                <FormDescription>
                                    Enter two factor code from your phone.
                                </FormDescription>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>

                    <div v-else>
                        <FormField
                            v-slot="{ componentField }"
                            name="recovery_code"
                        >
                            <FormItem>
                                <FormLabel>Recovery Code</FormLabel>
                                <FormControl>
                                    <Input
                                        id="recovery-code"
                                        v-bind="componentField"
                                        type="text"
                                        placeholder="xxxxxx-xxxxxx"
                                    />
                                </FormControl>
                                <FormDescription>
                                    Enter your recovery code.
                                </FormDescription>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>

                    <div>
                        <Button type="submit" class="w-full">Verify</Button>
                    </div>
                </form>
            </CardContent>
            <CardFooter class="flex justify-center">
                <Button @click="toggleRecoveryCode" class="w-full">
                    {{
                        useRecoveryCode
                            ? "Use authentication code"
                            : "Use a recovery code"
                    }}
                </Button>
            </CardFooter>
        </Card>
    </div>
</template>
