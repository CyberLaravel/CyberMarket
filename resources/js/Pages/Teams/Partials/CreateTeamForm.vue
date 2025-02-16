<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
});

const createTeam = () => {
    form.post(route("teams.store"), {
        errorBag: "createTeam",
        preserveScroll: true,
    });
};
</script>

<template>
    <form
        @submit.prevent="createTeam"
        class="bg-gray-800 p-6 rounded-lg border border-yellow-400/30"
    >
        <div class="space-y-6">
            <!-- Title -->
            <div>
                <span
                    class="font-['Orbitron'] text-yellow-400 text-xl font-bold neon-text"
                >
                    Team Details
                </span>
            </div>

            <!-- Description -->
            <div>
                <span class="text-blue-300">
                    Create a new team to collaborate with others on projects.
                </span>
            </div>

            <!-- Form Content -->
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6">
                    <label class="text-yellow-400">Team Owner</label>

                    <div
                        class="flex items-center mt-2 p-4 bg-gray-900 rounded-lg border border-yellow-400/30 hover:border-yellow-400/50 transition-colors duration-300"
                    >
                        <img
                            class="object-cover size-12 rounded-full ring-2 ring-yellow-400/50 hover:ring-yellow-400 transition-all duration-300"
                            :src="$page.props.auth.user.profile_photo_url"
                            :alt="$page.props.auth.user.name"
                        />

                        <div class="ms-4 leading-tight">
                            <div class="text-gray-100 font-['Orbitron']">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div
                                class="text-sm text-blue-300 hover:text-blue-200 transition-colors duration-300"
                            >
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <label for="name" class="text-yellow-400">Team Name</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full bg-gray-900 border-yellow-400/50 focus:border-yellow-400 focus:ring focus:ring-yellow-400/30 text-gray-100 placeholder-gray-500 rounded-md shadow-sm"
                        autofocus
                    />
                    <div
                        v-if="form.errors.name"
                        class="mt-2 text-red-400 text-sm"
                    >
                        {{ form.errors.name }}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    :disabled="form.processing"
                    :class="{ 'opacity-25': form.processing }"
                    class="bg-yellow-400 hover:bg-yellow-300 text-black font-['Orbitron'] transition-all duration-300 hover:shadow-[0_0_15px_rgba(250,204,21,0.5)] rounded-md px-4 py-2"
                >
                    Create
                </button>
            </div>
        </div>
    </form>
</template>

<style scoped>
.neon-text {
    text-shadow: 0 0 10px rgba(250, 204, 21, 0.5),
        0 0 20px rgba(250, 204, 21, 0.3), 0 0 30px rgba(250, 204, 21, 0.1);
}
</style>
