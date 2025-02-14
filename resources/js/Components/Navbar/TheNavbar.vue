<script setup lang="ts">
import MainNav from "./MainNav.vue";
import Search from "./Search.vue";
import TeamSwitcher from "./TeamSwitcher.vue";
import UserNav from "./UserNav.vue";
defineProps(["teams"]);
</script>

<template>
    <div class="border-b">
        <div class="flex h-16 items-center px-4">
            <TeamSwitcher :teams="teams" />
            <MainNav class="mx-6" />
            <div class="ml-auto flex items-center space-x-4">
                <Search />
                <UserNav />
            </div>
        </div>
    </div>
</template>
