<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Badge } from "@/Components/ui/badge";

defineProps({
    applications: Object,
});

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
        <Head title="Seller Applications" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="bg-gray-800 border-yellow-400">
                    <CardHeader>
                        <CardTitle
                            class="text-2xl text-yellow-400 font-orbitron glitch-text"
                        >
                            Seller Applications
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div
                                v-for="application in applications.data"
                                :key="application.id"
                                class="p-4 bg-gray-900 rounded-lg border border-yellow-400/30 hover:border-yellow-400 transition-all duration-300"
                            >
                                <div
                                    class="flex items-center justify-between mb-2"
                                >
                                    <div>
                                        <h3 class="text-yellow-400 font-medium">
                                            {{ application.business_name }}
                                        </h3>
                                        <p class="text-blue-300 text-sm">
                                            by {{ application.user.name }}
                                        </p>
                                    </div>
                                    <Badge
                                        :class="
                                            getStatusColor(application.status)
                                        "
                                        class="border px-3 py-1"
                                    >
                                        {{ application.status }}
                                    </Badge>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-100 text-sm">
                                        Applied
                                        {{
                                            new Date(
                                                application.created_at
                                            ).toLocaleDateString()
                                        }}
                                    </p>
                                    <Link
                                        :href="
                                            route(
                                                'admin.seller-applications.show',
                                                application.id
                                            )
                                        "
                                        class="text-blue-300 hover:text-yellow-400 transition-colors duration-300"
                                    >
                                        View Details →
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="applications.links" class="mt-6">
                            <!-- Add pagination component here -->
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
