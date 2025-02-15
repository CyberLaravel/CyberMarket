<script setup>
import { Link } from "@inertiajs/vue3";
const navLinks = [
    { route: "dashboard", label: "Overview" },
    {
        route: "dashboard",
        label: "Customers",
        class: "text-muted-foreground",
    },
    {
        route: "products.index",
        label: "Products",
        class: "text-muted-foreground",
    },
    {
        route: "dashboard",
        label: "Settings",
        class: "text-muted-foreground",
    },
];
</script>

<template>
    <nav class="flex items-center space-x-6">
        <Link
            v-for="item in navLinks"
            :key="item.route"
            :href="route(item.route)"
            :class="[
                'navbar-link relative group',
                $page.url.startsWith(item.route)
                    ? 'text-primary after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-yellow-400 after:shadow-[0_0_10px_rgba(250,204,21,0.5)]'
                    : '',
            ]"
        >
            {{ item.label }}
        </Link>
    </nav>
</template>
