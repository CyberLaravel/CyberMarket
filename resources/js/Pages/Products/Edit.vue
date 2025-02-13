<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    product: Object,
});

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    image: props.product.image,
});

const submit = () => {
    form.put(`/products/${props.product.id}`);
};
</script>

<template>
    <div>
        <h1>Edit Product</h1>
        <form @submit.prevent="submit">
            <input v-model="form.name" placeholder="Name" />
            <textarea
                v-model="form.description"
                placeholder="Description"
            ></textarea>
            <input v-model="form.price" type="number" placeholder="Price" />
            <input v-model="form.image" placeholder="Image URL" />
            <button type="submit">Update</button>
        </form>
    </div>
</template>
