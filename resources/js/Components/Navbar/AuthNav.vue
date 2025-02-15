<script setup>
import { usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import MainNav from "./MainNav.vue";
import Search from "./Search.vue";
import TeamSwitcher from "./TeamSwitcher.vue";
import UserNav from "./UserNav.vue";
import CartButton from "@/Components/Cart/CartButton.vue";

const page = usePage();
</script>

<template>
    <div class="navbar">
        <div class="navbar-inner">
            <Link :href="route('dashboard')" class="navbar-brand">
                CyberStore
            </Link>

            <TeamSwitcher
                :teams="page.props.auth.user.all_teams"
                class="navbar-link"
            />
            <MainNav class="mx-6" />
            <div class="ml-auto flex items-center space-x-6">
                <Search class="navbar-link" />
                <UserNav class="navbar-link" />
                <CartButton class="navbar-link" />
            </div>
        </div>
    </div>
</template>
