<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    team: Object,
});

const confirmingTeamDeletion = ref(false);
const form = useForm({});

const confirmTeamDeletion = () => {
    confirmingTeamDeletion.value = true;
};

const deleteTeam = () => {
    form.delete(route("teams.destroy", props.team), {
        errorBag: "deleteTeam",
    });
};
</script>

<template>
    <div class="bg-gray-800 p-6 rounded-lg border border-yellow-400/30">
        <div class="space-y-6">
            <!-- Title -->
            <span
                class="font-['Orbitron'] text-yellow-400 text-xl font-bold neon-text"
            >
                Delete Team
            </span>

            <!-- Description -->
            <span class="text-blue-300"> Permanently delete this team. </span>

            <!-- Content -->
            <div class="max-w-xl text-sm text-gray-100">
                Once a team is deleted, all of its resources and data will be
                permanently deleted. Before deleting this team, please download
                any data or information regarding this team that you wish to
                retain.
            </div>

            <div class="mt-5">
                <button
                    @click="confirmTeamDeletion"
                    class="bg-red-500 hover:bg-red-600 text-black font-['Orbitron'] transition-all duration-300 hover:shadow-[0_0_15px_rgba(239,68,68,0.5)] px-4 py-2 rounded-md"
                >
                    Delete Team
                </button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <div
                v-if="confirmingTeamDeletion"
                class="fixed inset-0 flex items-center justify-center z-50"
            >
                <div class="fixed inset-0 bg-black/50"></div>

                <div
                    class="relative bg-gray-800 p-6 rounded-lg border border-yellow-400/30 max-w-md w-full m-4"
                >
                    <!-- Modal Title -->
                    <span
                        class="font-['Orbitron'] text-yellow-400 text-xl font-bold neon-text block mb-4"
                    >
                        Delete Team
                    </span>

                    <!-- Modal Content -->
                    <div class="text-gray-100 mb-6">
                        Are you sure you want to delete this team? Once a team
                        is deleted, all of its resources and data will be
                        permanently deleted.
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3">
                        <button
                            @click="confirmingTeamDeletion = false"
                            class="font-['Orbitron'] border border-yellow-400 text-yellow-400 hover:bg-yellow-400/10 px-4 py-2 rounded-md transition-all duration-300"
                        >
                            Cancel
                        </button>

                        <button
                            class="font-['Orbitron'] bg-red-500 hover:bg-red-600 text-black transition-all duration-300 hover:shadow-[0_0_15px_rgba(239,68,68,0.5)] px-4 py-2 rounded-md"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="deleteTeam"
                        >
                            Delete Team
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.neon-text {
    text-shadow: 0 0 10px rgba(250, 204, 21, 0.5),
        0 0 20px rgba(250, 204, 21, 0.3), 0 0 30px rgba(250, 204, 21, 0.1);
}
</style>
