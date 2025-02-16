<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    team: Object,
    permissions: Object,
});

const form = useForm({
    name: props.team.name,
});

const updateTeamName = () => {
    form.put(route("teams.update", props.team), {
        errorBag: "updateTeamName",
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="bg-gray-800 border border-yellow-400 rounded-lg p-6 space-y-6">
        <!-- Header -->
        <div class="space-y-2">
            <h3 class="cyberpunk-heading neon-text text-2xl font-bold">
                Team Name
            </h3>
            <p class="text-blue-300">The team's name and owner information.</p>
        </div>

        <!-- Content -->
        <div class="space-y-6">
            <!-- Team Owner Information -->
            <div class="space-y-2">
                <label class="text-yellow-400 block font-bold"
                    >Team Owner</label
                >

                <div
                    class="flex items-center p-4 bg-gray-900 rounded-lg border border-yellow-400/30 hover:border-yellow-400/50 transition-colors duration-300"
                >
                    <img
                        class="size-12 rounded-full ring-2 ring-yellow-400/50 hover:ring-yellow-400 transition-all duration-300"
                        :src="team.owner.profile_photo_url"
                        :alt="team.owner.name"
                    />

                    <div class="ms-4 leading-tight">
                        <div class="text-gray-100 font-['Orbitron']">
                            {{ team.owner.name }}
                        </div>
                        <div
                            class="text-sm text-blue-300 hover:text-blue-200 transition-colors duration-300"
                        >
                            {{ team.owner.email }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="space-y-2">
                <label for="name" class="text-yellow-400 block font-bold"
                    >Team Name</label
                >

                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full bg-gray-800 border border-yellow-400 rounded-md px-4 py-2 text-gray-100 focus:ring-2 focus:ring-yellow-400 focus:outline-none cyberpunk-input"
                    :disabled="!permissions.canUpdateTeam"
                />

                <span v-if="form.errors.name" class="text-sm text-red-400">
                    {{ form.errors.name }}
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div
            v-if="permissions.canUpdateTeam"
            class="flex justify-end space-x-4 pt-4"
        >
            <span v-if="form.recentlySuccessful" class="text-blue-300">
                Saved.
            </span>

            <button
                :disabled="form.processing"
                @click="updateTeamName"
                class="bg-yellow-400 hover:bg-yellow-300 text-black font-['Orbitron'] px-4 py-2 rounded-md transition-all duration-300 hover:shadow-[0_0_15px_rgba(250,204,21,0.5)]"
            >
                Save
            </button>
        </div>
    </div>
</template>
