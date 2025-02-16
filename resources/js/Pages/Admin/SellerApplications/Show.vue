<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Textarea } from "@/Components/ui/textarea";
import { Badge } from "@/Components/ui/badge";

const props = defineProps({
    application: Object,
});

const form = useForm({
    admin_notes: "",
});

const approve = () => {
    form.post(route("admin.seller-applications.approve", props.application.id));
};

const reject = () => {
    form.post(route("admin.seller-applications.reject", props.application.id));
};

const getStatusColor = (status) => {
    switch (status) {
        case "pending":
            return "bg-yellow-400/20 text-yellow-400 border-yellow-400";
        case "approved":
            return "bg-green-500/20 text-green-500 border-green-500";
        case "rejected":
            return "bg-red-500/20 text-red-500 border-red-500";
        default:
            return "bg-gray-500/20 text-gray-500 border-gray-500";
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="`Application - ${application.business_name}`" />

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <Card class="bg-gray-800 border-yellow-400">
                    <CardHeader>
                        <div class="flex justify-between items-center">
                            <CardTitle
                                class="text-2xl text-yellow-400 font-orbitron glitch-text"
                            >
                                Seller Application
                            </CardTitle>
                            <Badge
                                :class="getStatusColor(application.status)"
                                class="border px-3 py-1"
                            >
                                {{ application.status }}
                            </Badge>
                        </div>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <!-- Applicant Info -->
                        <div
                            class="bg-gray-900 p-4 rounded-lg border border-yellow-400/30"
                        >
                            <h3 class="text-yellow-400 font-medium mb-2">
                                Applicant Information
                            </h3>
                            <div class="grid grid-cols-2 gap-4 text-blue-300">
                                <div>
                                    <p class="text-sm">Name</p>
                                    <p class="font-medium">
                                        {{ application.user.name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm">Email</p>
                                    <p class="font-medium">
                                        {{ application.user.email }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Business Info -->
                        <div
                            class="bg-gray-900 p-4 rounded-lg border border-yellow-400/30"
                        >
                            <h3 class="text-yellow-400 font-medium mb-2">
                                Business Information
                            </h3>
                            <div class="space-y-4 text-blue-300">
                                <div>
                                    <p class="text-sm">Business Name</p>
                                    <p class="font-medium">
                                        {{ application.business_name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm">Description</p>
                                    <p class="font-medium">
                                        {{ application.description }}
                                    </p>
                                </div>
                                <div v-if="application.website">
                                    <p class="text-sm">Website</p>
                                    <a
                                        :href="application.website"
                                        target="_blank"
                                        class="font-medium text-yellow-400 hover:text-yellow-300"
                                    >
                                        {{ application.website }}
                                    </a>
                                </div>
                                <div>
                                    <p class="text-sm">Reason for Applying</p>
                                    <p class="font-medium">
                                        {{ application.reason }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Actions -->
                        <div
                            v-if="application.status === 'pending'"
                            class="space-y-4"
                        >
                            <div
                                class="bg-gray-900 p-4 rounded-lg border border-yellow-400/30"
                            >
                                <h3 class="text-yellow-400 font-medium mb-2">
                                    Admin Notes
                                </h3>
                                <Textarea
                                    v-model="form.admin_notes"
                                    class="bg-gray-800 border-yellow-400 text-gray-100"
                                    rows="4"
                                    placeholder="Add notes about this application (optional)"
                                />
                            </div>

                            <div class="flex justify-end gap-4">
                                <Button
                                    @click="reject"
                                    :disabled="form.processing"
                                    class="bg-red-500 text-white hover:bg-red-600"
                                >
                                    Reject Application
                                </Button>
                                <Button
                                    @click="approve"
                                    :disabled="form.processing"
                                    class="bg-yellow-400 text-black hover:bg-yellow-300"
                                >
                                    Approve Application
                                </Button>
                            </div>
                        </div>

                        <!-- Admin Notes Display -->
                        <div
                            v-if="application.admin_notes"
                            class="bg-gray-900 p-4 rounded-lg border border-yellow-400/30"
                        >
                            <h3 class="text-yellow-400 font-medium mb-2">
                                Admin Notes
                            </h3>
                            <p class="text-blue-300">
                                {{ application.admin_notes }}
                            </p>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
