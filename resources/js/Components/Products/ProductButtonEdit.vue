<script setup>
import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/vue3";

defineProps(["product"]);
</script>

<template>
    <Link
        :href="route('products.edit', product.id)"
        class="w-full"
        v-if="$page.props.auth.user.id === product.seller.id"
    >
        <Button class="w-full"> Edit </Button>
    </Link>
</template>
