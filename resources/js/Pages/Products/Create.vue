<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Button } from "@/Components/ui/button";
import { toast } from "@/Components/ui/toast";

const form = useForm({
    name: "",
    description: "",
    price: "",
    images: [],
});

const submit = () => {
    form.post("/products", {
        onSuccess: () => {
            form.reset();
            form.images = [];
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

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    form.images.push(...files);
};

const handleDrop = (event) => {
    event.preventDefault();
    const files = Array.from(event.dataTransfer.files);
    form.images.push(...files);
};

const handleDragOver = (event) => {
    event.preventDefault();
};

const triggerFileInput = () => {
    document.getElementById("images").click();
};
</script>

<template>
    {{ form }}
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

                <div class="space-y-2">
                    <Label for="images">Product Images</Label>
                    <div
                        class="border-dashed border-2 border-gray-300 p-4 text-center cursor-pointer"
                        @drop="handleDrop"
                        @dragover="handleDragOver"
                        @click="triggerFileInput"
                    >
                        <p>
                            Drag and drop images here or click to select files
                        </p>
                        <Input
                            id="images"
                            type="file"
                            @change="handleFileChange"
                            accept="image/*"
                            multiple
                            class="hidden"
                        />
                    </div>
                    <span
                        v-if="form.errors.images"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.images }}
                    </span>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        <div
                            v-for="(image, index) in form.images"
                            :key="index"
                            class="relative"
                        >
                            <img
                                :src="URL.createObjectURL(image)"
                                class="w-full h-auto rounded"
                            />
                        </div>
                    </div>
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
