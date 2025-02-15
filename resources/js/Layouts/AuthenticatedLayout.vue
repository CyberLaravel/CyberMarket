<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import TheNavbar from "@/Components/Navbar/TheNavbar.vue";
import SideNavigation from "@/Components/Navbar/SideNavigation.vue";

const showingNavigationDropdown = ref(false);

const navigation = [
    {
        name: "Dashboard",
        href: route("dashboard"),
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>`,
    },
    {
        name: "Profile",
        href: route("profile.information"),
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>`,
    },
    {
        name: "Security",
        href: route("profile.security"),
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>`,
    },
];
</script>

<template>
    <div class="min-h-screen bg-gray-900">
        <!-- Top Navbar -->
        <TheNavbar />

        <div class="flex">
            <!-- Left Side Navigation -->
            <SideNavigation :navigation="navigation" />

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Mobile Menu Button -->
                <div class="sm:hidden p-4">
                    <Button
                        @click="
                            showingNavigationDropdown =
                                !showingNavigationDropdown
                        "
                        class="inline-flex items-center justify-center p-2 rounded-md text-blue-300 hover:text-yellow-400 hover:bg-gray-900 transition duration-150 ease-in-out"
                    >
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </Button>
                </div>

                <!-- Mobile Navigation Drawer -->
                <div
                    :class="{
                        'translate-x-0': showingNavigationDropdown,
                        '-translate-x-full': !showingNavigationDropdown,
                    }"
                    class="fixed inset-y-0 left-0 transform sm:hidden w-64 bg-gray-800 border-r border-yellow-400 transition duration-300 ease-in-out z-50"
                >
                    <div
                        class="h-16 border-b border-yellow-400 flex items-center justify-between px-6"
                    >
                        <h1
                            class="text-2xl font-bold text-yellow-400 font-['Orbitron']"
                        >
                            CYBER<span class="text-blue-300">SPACE</span>
                        </h1>
                        <Button
                            @click="showingNavigationDropdown = false"
                            class="text-blue-300 hover:text-yellow-400"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </Button>
                    </div>
                    <nav class="pt-6">
                        <div class="space-y-1 px-2">
                            <Link
                                v-for="item in navigation"
                                :key="item.name"
                                :href="item.href"
                                :class="[
                                    route().current(item.href)
                                        ? 'bg-gray-900 text-yellow-400 border-l-2 border-yellow-400'
                                        : 'text-blue-300 hover:text-yellow-400 hover:bg-gray-900',
                                    'group flex items-center px-4 py-3 text-sm font-medium transition-all duration-200',
                                ]"
                                @click="showingNavigationDropdown = false"
                            >
                                <span v-html="item.icon" class="mr-3"></span>
                                {{ item.name }}
                            </Link>
                        </div>
                    </nav>
                </div>

                <!-- Page Content -->
                <main
                    class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-900 p-6"
                >
                    <slot />
                </main>

                <!-- Footer -->
                <footer class="border-t border-yellow-400 bg-gray-800 py-4">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <p class="text-center text-blue-300">
                            © {{ new Date().getFullYear() }} CYBERSPACE. All
                            rights reserved.
                        </p>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>
