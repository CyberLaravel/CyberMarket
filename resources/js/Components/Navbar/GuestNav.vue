<script setup>
import { Link } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";

const navLinks = [
    { route: "login", label: "Login" },
    { route: "register", label: "Register" },
];
</script>

<template>
    <div class="navbar">
        <div class="navbar-inner">
            <Link :href="route('home')" class="navbar-brand"> CyberStore </Link>

            <div class="ml-auto flex items-center space-x-4">
                <Link
                    v-for="item in navLinks"
                    :key="item.route"
                    :href="route(item.route)"
                >
                    <Button
                        :variant="
                            item.route === 'register' ? 'default' : 'ghost'
                        "
                        :class="[
                            item.route === 'register'
                                ? 'btn-primary'
                                : 'btn-ghost',
                        ]"
                    >
                        {{ item.label }}
                    </Button>
                </Link>
            </div>
        </div>
    </div>
</template>
