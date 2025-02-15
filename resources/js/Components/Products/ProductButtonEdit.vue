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
        class="w-8"
    >
        <Button
            variant="outline"
            class="w-full h-8 flex items-center justify-center bg-gray-900 border-yellow-400 hover:bg-gray-800 hover:border-blue-300 hover:text-blue-300 transition-all duration-300 text-yellow-400 hover:shadow-neon-blue"
        >
            <Pencil class="h-4 w-4" />
        </Button>
    </Link>
</template>
