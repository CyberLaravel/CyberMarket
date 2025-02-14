<script setup>
import { cn } from "@/lib/utils";
import { Link } from "@inertiajs/vue3";

const navLinks = [
    { route: "dashboard", label: "Overview" },
    {
        route: "dashboard",
        label: "Customers",
        class: "text-muted-foreground",
    },
    {
        route: "dashboard",
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
    <nav
        :class="
            cn('flex items-center space-x-4 lg:space-x-6', $attrs.class ?? '')
        "
    >
        <Link
            v-for="link in navLinks"
            :key="link.label"
            :href="route(link.route)"
            :class="
                cn(
                    'text-sm font-medium transition-colors hover:text-primary',
                    link.class
                )
            "
        >
            {{ link.label }}
        </Link>
    </nav>
</template>
