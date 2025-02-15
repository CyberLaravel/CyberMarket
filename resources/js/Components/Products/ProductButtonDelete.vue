<!-- ProductButtonDelete.vue -->
<script setup>
import { Button } from "@/Components/ui/button";
import { useForm } from "@inertiajs/vue3";
import { Trash2 } from "lucide-vue-next";
import { toast } from "@/Components/ui/toast";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const form = useForm({});

const handleProductDelete = () => {
    if (confirm("Are you sure you want to delete this product?")) {
        form.delete(route("products.destroy", props.product.id), {
            onSuccess: () => {
                toast({
                    title: "Success",
                    description: "Product has been deleted",
                });
            },
            onError: () => {
                toast({
                    title: "Error",
                    description: "Failed to delete product. Please try again.",
                    variant: "destructive",
                });
            },
        });
    }
};
</script>

<template>
    <form
        @submit.prevent="handleProductDelete"
        v-if="$page.props.auth.user.id === product.seller.id"
        class="w-8"
    >
        <Button
            type="submit"
            variant="outline"
            class="w-full h-8 flex items-center justify-center bg-gray-900 border-yellow-400 hover:bg-gray-800 hover:border-red-400 hover:text-red-400 transition-all duration-300 text-yellow-400 hover:shadow-neon-red"
            :disabled="form.processing"
        >
            <Trash2 class="h-4 w-4" />
        </Button>
    </form>
</template>
