<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { useToast } from "@/Components/ui/toast";
import { Avatar, AvatarImage, AvatarFallback } from "@/Components/ui/avatar";
import { Camera } from "lucide-vue-next";

const props = defineProps({
    user: Object,
});

const { toast } = useToast();
const photoInput = ref(null);
const photoPreview = ref(null);

const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => {
            clearPhotoFileInput();
            toast({
                title: "Profile Updated",
                description:
                    "Your profile information has been updated successfully.",
            });
        },
    });
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];
    if (!photo) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };
    reader.readAsDataURL(photo);
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};

const deletePhoto = () => {
    router.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            toast({
                title: "Profile Photo Deleted",
            });
        },
    });
};
</script>

<template>
    <div class="max-w-xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-yellow-400">
                Profile Information
            </h3>
            <p class="text-gray-100 mt-1">
                Update your account's profile information and email address.
            </p>
        </div>

        <form @submit.prevent="updateProfileInformation" class="space-y-6">
            <!-- Profile Photo -->
            <div
                v-if="$page.props.jetstream.managesProfilePhotos"
                class="bg-gray-800 rounded-lg p-6"
            >
                <div class="flex items-center gap-6">
                    <Avatar class="w-20 h-20">
                        <AvatarImage
                            v-if="!photoPreview"
                            :src="user.profile_photo_url"
                            :alt="user.name"
                        />
                        <AvatarImage
                            v-else
                            :src="photoPreview"
                            :alt="user.name"
                        />
                        <AvatarFallback>{{
                            user.name.charAt(0)
                        }}</AvatarFallback>
                    </Avatar>
                    <div class="flex gap-3">
                        <Button
                            variant="outline"
                            size="sm"
                            @click="selectNewPhoto"
                            class="bg-yellow-400 text-black hover:bg-yellow-300"
                        >
                            <Camera class="mr-2 h-4 w-4" />
                            Change Photo
                        </Button>
                        <Button
                            v-if="user.profile_photo_path"
                            variant="destructive"
                            size="sm"
                            @click="deletePhoto"
                            class="bg-red-600 text-white hover:bg-red-500"
                            type="button"
                        >
                            Remove Photo
                        </Button>
                    </div>
                    <input
                        ref="photoInput"
                        type="file"
                        class="hidden"
                        @change="updatePhotoPreview"
                    />
                </div>
                <p v-if="form.errors.photo" class="mt-2 text-sm text-red-500">
                    {{ form.errors.photo }}
                </p>
            </div>

            <!-- Profile Information -->
            <div class="bg-gray-800 rounded-lg p-6 space-y-4">
                <!-- Name -->
                <div class="space-y-2">
                    <Label for="name" class="text-sm font-medium text-gray-100"
                        >Name</Label
                    >
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        required
                        autocomplete="name"
                        class="bg-gray-700 text-gray-100"
                    />
                    <p v-if="form.errors.name" class="text-sm text-red-500">
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <Label for="email" class="text-sm font-medium text-gray-100"
                        >Email</Label
                    >
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        required
                        autocomplete="email"
                        class="bg-gray-700 text-gray-100"
                    />
                    <p v-if="form.errors.email" class="text-sm text-red-500">
                        {{ form.errors.email }}
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between">
                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-yellow-400 text-black hover:bg-yellow-300"
                >
                    {{ form.processing ? "Saving..." : "Save Changes" }}
                </Button>
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-100">
                    Saved successfully.
                </p>
            </div>
        </form>
    </div>
</template>
