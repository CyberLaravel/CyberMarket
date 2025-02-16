<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";

const props = defineProps({
    hasApplication: Boolean,
    application: Object,
});

const form = useForm({
    business_name: "",
    description: "",
    website: "",
    reason: "",
});

const submit = () => {
    form.post(route("seller.apply"));
};
</script>

<template>
    <AppLayout>
        <Head title="Become a Seller" />

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <Card class="bg-gray-800 border-yellow-400">
                    <CardHeader>
                        <CardTitle
                            class="text-2xl text-yellow-400 font-orbitron glitch-text"
                        >
                            Become a Seller
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div v-if="hasApplication" class="mb-6">
                            <div
                                class="p-4 rounded-lg border border-yellow-400 bg-gray-900"
                            >
                                <h3 class="text-yellow-400 font-medium mb-2">
                                    Application Status:
                                    <span
                                        :class="{
                                            'text-blue-300':
                                                application.status ===
                                                'pending',
                                            'text-green-400':
                                                application.status ===
                                                'approved',
                                            'text-red-400':
                                                application.status ===
                                                'rejected',
                                        }"
                                    >
                                        {{
                                            application.status
                                                .charAt(0)
                                                .toUpperCase() +
                                            application.status.slice(1)
                                        }}
                                    </span>
                                </h3>
                                <p class="text-blue-300 text-sm">
                                    {{
                                        application.status === "pending"
                                            ? "Your application is currently under review. We'll notify you once it's processed."
                                            : application.status === "approved"
                                            ? "Congratulations! Your application has been approved. You can now start selling products."
                                            : "Your application has been rejected. You may submit a new application after reviewing the requirements."
                                    }}
                                </p>
                            </div>
                        </div>

                        <form v-else @submit.prevent="submit" class="space-y-6">
                            <div class="space-y-2">
                                <Label
                                    for="business_name"
                                    class="text-blue-300"
                                >
                                    Business Name
                                </Label>
                                <Input
                                    id="business_name"
                                    v-model="form.business_name"
                                    type="text"
                                    class="bg-gray-900 border-yellow-400 text-yellow-400 placeholder:text-gray-500"
                                    placeholder="Your business name"
                                />
                                <span
                                    v-if="form.errors.business_name"
                                    class="text-red-400 text-sm"
                                >
                                    {{ form.errors.business_name }}
                                </span>
                            </div>

                            <div class="space-y-2">
                                <Label for="description" class="text-blue-300">
                                    Business Description
                                </Label>
                                <Textarea
                                    id="description"
                                    v-model="form.description"
                                    class="bg-gray-900 border-yellow-400 text-yellow-400 placeholder:text-gray-500"
                                    placeholder="Tell us about your business"
                                    rows="4"
                                />
                                <span
                                    v-if="form.errors.description"
                                    class="text-red-400 text-sm"
                                >
                                    {{ form.errors.description }}
                                </span>
                            </div>

                            <div class="space-y-2">
                                <Label for="website" class="text-blue-300">
                                    Website (Optional)
                                </Label>
                                <Input
                                    id="website"
                                    v-model="form.website"
                                    type="url"
                                    class="bg-gray-900 border-yellow-400 text-yellow-400 placeholder:text-gray-500"
                                    placeholder="https://your-website.com"
                                />
                                <span
                                    v-if="form.errors.website"
                                    class="text-red-400 text-sm"
                                >
                                    {{ form.errors.website }}
                                </span>
                            </div>

                            <div class="space-y-2">
                                <Label for="reason" class="text-blue-300">
                                    Why do you want to become a seller?
                                </Label>
                                <Textarea
                                    id="reason"
                                    v-model="form.reason"
                                    class="bg-gray-900 border-yellow-400 text-yellow-400 placeholder:text-gray-500"
                                    placeholder="Tell us why you want to join our marketplace"
                                    rows="4"
                                />
                                <span
                                    v-if="form.errors.reason"
                                    class="text-red-400 text-sm"
                                >
                                    {{ form.errors.reason }}
                                </span>
                            </div>

                            <div class="flex justify-end">
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="bg-yellow-400 text-black hover:bg-yellow-300 transition-colors duration-300"
                                >
                                    {{
                                        form.processing
                                            ? "Submitting..."
                                            : "Submit Application"
                                    }}
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
