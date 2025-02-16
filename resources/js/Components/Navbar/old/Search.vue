<script setup lang="ts">
import { Input } from "@/Components/ui/input";
import { Search as SearchIcon } from "lucide-vue-next";
</script>

<template>
    <div class="relative w-full max-w-sm">
        <SearchIcon class="absolute left-2 top-2.5 h-4 w-4 text-primary" />
        <Input type="search" placeholder="Search..." class="form-input pl-8" />
    </div>
</template>
