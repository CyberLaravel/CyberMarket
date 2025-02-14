<script setup>
import { Button } from "@/components/ui/button";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["product"]);
const form = useForm({});

const handleProductDelete = () => {
    form.delete(route("products.destroy", props.product.id));
};
</script>

<template>
    <form
        @submit.prevent="handleProductDelete"
        v-if="$page.props.auth.user.id === product.seller.id"
        class="w-full"
    >
        <Button type="submit" class="w-full">Delete</Button>
    </form>
</template>
