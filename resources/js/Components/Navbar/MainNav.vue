<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);

const navLinks = computed(() => {
    const links = [
        { route: "dashboard", label: "Overview" },
        {
            route: "products.index",
            label: "Products",
            class: "text-muted-foreground",
        },
    ];

    // Add seller application link for non-sellers
    if (!user.value.is_admin) {
        links.push({
            route: "seller.apply",
            label: "Become a Seller",
            class: "text-muted-foreground",
        });
    }

    // Add seller-specific links
    if (user.value.is_admin) {
        links.push({
            route: "seller.dashboard",
            label: "Seller Dashboard",
            class: "text-muted-foreground",
        });
    }

    // Add admin-specific links
    if (user.value.is_admin) {
        links.push({
            route: "admin.dashboard",
            label: "Admin Dashboard",
            class: "text-muted-foreground",
        });
    }

    return links;
});
</script>

<template>
    <nav class="flex items-center space-x-6">
        <Link
            v-for="item in navLinks"
            :key="item.route"
            :href="route(item.route)"
            :class="[
                'navbar-link relative group',
                $page.url.startsWith(route(item.route))
                    ? 'text-primary after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-yellow-400 after:shadow-[0_0_10px_rgba(250,204,21,0.5)]'
                    : 'text-blue-300 hover:text-yellow-400',
            ]"
        >
            {{ item.label }}
        </Link>
    </nav>
</template>
