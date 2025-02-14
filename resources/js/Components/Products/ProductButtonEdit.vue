<!-- ProductButtonEdit.vue -->
<script setup>
import { Button } from "@/Components/ui/button";
import { Link } from "@inertiajs/vue3";
import { Pencil } from "lucide-vue-next";

defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Link
        v-if="$page.props.auth.user.id === product.seller.id"
        :href="route('products.edit', product.id)"
        class="w-full"
    >
        <Button
            variant="outline"
            class="w-full flex items-center justify-center gap-2"
        >
            <Pencil class="h-4 w-4" />
        </Button>
    </Link>
</template>
