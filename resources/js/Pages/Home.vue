<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button } from "@/Components/ui/button";
import { Link } from "@inertiajs/vue3";

const features = [
    {
        title: "Digital Products",
        description: "Browse our collection of high-quality digital products.",
        icon: `<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>`,
    },
    {
        title: "Secure Transactions",
        description:
            "Your payments are protected with state-of-the-art security.",
        icon: `<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>`,
    },
    {
        title: "Instant Delivery",
        description: "Get your products delivered instantly after purchase.",
        icon: `<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>`,
    },
];
</script>

<template>
    <AppLayout>
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <!-- Background Pattern -->
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#1f2937_1px,transparent_1px),linear-gradient(to_bottom,#1f2937_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_110%)]"
            />

            <div class="relative">
                <div class="container mx-auto px-4 py-24">
                    <div class="text-center">
                        <h1
                            class="text-4xl md:text-6xl font-bold text-primary glitch-text mb-6"
                        >
                            Welcome to CyberStore
                        </h1>
                        <p class="text-body text-xl mb-8 max-w-2xl mx-auto">
                            Your one-stop destination for premium digital
                            products in the cyberpunk universe.
                        </p>
                        <div class="flex justify-center gap-4">
                            <Link :href="route('products.index')">
                                <Button class="btn-primary text-lg px-8 py-6">
                                    Explore Products
                                </Button>
                            </Link>
                            <Link :href="route('register')">
                                <Button
                                    variant="outline"
                                    class="text-lg px-8 py-6 border-yellow-400 text-body hover:text-primary"
                                >
                                    Get Started
                                </Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-gray-800/50 py-24">
            <div class="container mx-auto px-4">
                <h2
                    class="text-3xl font-bold text-center text-primary mb-12 glitch-text"
                >
                    Why Choose CyberStore?
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="card-cyberpunk p-6 rounded-lg transform hover:scale-105 transition-transform"
                    >
                        <div
                            class="w-12 h-12 rounded-full bg-yellow-400/10 flex items-center justify-center mb-4 text-primary"
                            v-html="feature.icon"
                        />
                        <h3 class="text-xl font-bold text-primary mb-2">
                            {{ feature.title }}
                        </h3>
                        <p class="text-body">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="py-24 relative overflow-hidden">
            <div
                class="absolute inset-0 bg-yellow-400/5 [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)]"
            />
            <div class="relative container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-primary mb-6 glitch-text">
                    Ready to Join the Future?
                </h2>
                <p class="text-body text-xl mb-8 max-w-2xl mx-auto">
                    Start exploring our collection of digital products and join
                    the cyberpunk revolution today.
                </p>
                <Link :href="route('register')">
                    <Button class="btn-primary text-lg px-8 py-6">
                        Create Account
                    </Button>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
