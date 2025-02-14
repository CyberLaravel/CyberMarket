<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const photoInput = ref(null);
const photoPreview = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
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
</script>

<template>
    <form @submit.prevent="updateProfileInformation" class="space-y-6">
        <div
            v-if="$page.props.jetstream.managesProfilePhotos"
            class="space-y-2"
        >
            <label for="photo" class="block text-sm font-medium text-blue-300"
                >Profile Photo</label
            >

            <div v-show="!photoPreview" class="mt-2">
                <img
                    :src="user.profile_photo_url"
                    :alt="user.name"
                    class="rounded-full h-20 w-20 object-cover"
                />
            </div>

            <div v-show="photoPreview" class="mt-2">
                <span
                    class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                    :style="'background-image: url(\'' + photoPreview + '\');'"
                />
            </div>

            <button
                type="button"
                @click.prevent="selectNewPhoto"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200"
            >
                Select A New Photo
            </button>

            <input
                ref="photoInput"
                type="file"
                class="hidden"
                @change="updatePhotoPreview"
            />

            <p v-if="form.errors.photo" class="mt-2 text-sm text-red-500">
                {{ form.errors.photo }}
            </p>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-blue-300"
                >Name</label
            >
            <input
                id="name"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-blue-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
                autocomplete="name"
            />
            <p v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                {{ form.errors.name }}
            </p>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-blue-300"
                >Email</label
            >
            <input
                id="email"
                v-model="form.email"
                type="email"
                class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-blue-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
                autocomplete="username"
            />
            <p v-if="form.errors.email" class="mt-2 text-sm text-red-500">
                {{ form.errors.email }}
            </p>
        </div>

        <div class="flex items-center">
            <button
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="px-4 py-2 bg-yellow-500 text-gray-900 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200"
            >
                Save
            </button>

            <p
                v-if="form.recentlySuccessful"
                class="text-sm text-green-400 ml-3"
            >
                Saved.
            </p>
        </div>
    </form>
</template>


