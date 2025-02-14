<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Button } from "@/components/ui/button";
import { toast } from "@/components/ui/toast";

const form = useForm({
    name: "",
    description: "",
    price: "",
});

const submit = () => {
    form.post("/products", {
        onSuccess: () => {
            form.reset();
            toast({
                title: "Success",
                description: "Product has been added successfully",
            });
        },
        onError: () => {
            toast({
                title: "Error",
                description: "Failed to add product. Please try again.",
                variant: "destructive",
            });
        },
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Create Product">
        <!-- Header Content -->
        <template #headerTitle> Create New Product </template>
        <template #headerDescription>
            Add a new product to your inventory
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

                <div class="flex justify-end">
                    <Button type="submit" :disabled="form.processing">
                        {{
                            form.processing
                                ? "Adding Product..."
                                : "Add Product"
                        }}
                    </Button>
                </div>
            </form>
        </div>

        <!-- Footer Content -->
        <template #footerContent>
            <p class="text-sm text-muted-foreground">
                All products will be reviewed before being published.
            </p>
        </template>
    </AppLayout>
</template>
