<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Button } from "@/Components/ui/button";
import { toast } from "@/Components/ui/toast";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const HOST = import.meta.env.VITE_STORAGE_HOST || "http://localhost:9000";
const BUCKET = import.meta.env.VITE_STORAGE_BUCKET || "glitchmart";

const getImageUrl = (imagePath) => {
    if (imagePath) {
        const cleanPath = imagePath.replace(/^\/+/, "");
        return `${HOST}/${BUCKET}/${cleanPath}`;
    }
    return "https://placehold.co/600x600?text=No+Image";
};

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    primary_image: null,
});

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.primary_image = file;
    }
};

const submit = () => {
    form.post(`/products/${props.product.id}`, {
        _method: "PUT",
        onSuccess: () => {
            toast({
                title: "Success",
                description: "Product has been updated successfully",
            });
        },
        onError: () => {
            toast({
                title: "Error",
                description: "Failed to update product. Please try again.",
                variant: "destructive",
            });
        },
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Edit Product">
        <!-- Header Content -->
        <template #headerTitle> Edit Product </template>
        <template #headerDescription>
            Update the details for "{{ product.name }}"
        </template>

        <!-- Main Content -->
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <Label for="name">Product Name</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            placeholder="Enter product name"
                            :error="form.errors.name"
                            required
                        />
                        <span
                            v-if="form.errors.name"
                            class="text-sm text-destructive"
                        >
                            {{ form.errors.name }}
                        </span>
                    </div>

                    <div class="space-y-2">
                        <Label for="price">Price</Label>
                        <Input
                            id="price"
                            v-model="form.price"
                            type="number"
                            step="0.01"
                            min="0"
                            placeholder="Enter price"
                            :error="form.errors.price"
                            required
                        />
                        <span
                            v-if="form.errors.price"
                            class="text-sm text-destructive"
                        >
                            {{ form.errors.price }}
                        </span>
                    </div>
                </div>

                <div class="space-y-2">
                    <Label for="primary_image">Product Image</Label>
                    <div class="flex items-center gap-4">
                        <img
                            :src="getImageUrl(product.primary_image)"
                            alt="Product image"
                            class="w-24 h-24 object-cover rounded-lg"
                        />
                        <Input
                            id="primary_image"
                            type="file"
                            accept="image/*"
                            @input="handleImageUpload"
                            :error="form.errors.primary_image"
                        />
                    </div>
                    <span
                        v-if="form.errors.primary_image"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.primary_image }}
                    </span>
                </div>

                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <Textarea
                        id="description"
                        v-model="form.description"
                        placeholder="Enter product description"
                        :error="form.errors.description"
                        required
                        rows="4"
                    />
                    <span
                        v-if="form.errors.description"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.description }}
                    </span>
                </div>

                <div class="flex justify-end space-x-4">
                    <Button
                        variant="outline"
                        type="button"
                        @click="$inertia.visit('/products')"
                    >
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? "Updating..." : "Update Product" }}
                    </Button>
                </div>
            </form>
        </div>

        <!-- Footer Content -->
        <template #footerContent>
            <p class="text-sm text-muted-foreground">
                Last updated:
                {{ new Date(product.updated_at).toLocaleDateString() }}
            </p>
        </template>
    </AppLayout>
</template>
