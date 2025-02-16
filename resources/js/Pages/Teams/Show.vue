<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteTeamForm from "@/Pages/Teams/Partials/DeleteTeamForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import TeamMemberManager from "@/Pages/Teams/Partials/TeamMemberManager.vue";
import UpdateTeamNameForm from "@/Pages/Teams/Partials/UpdateTeamNameForm.vue";

defineProps({
    team: Object,
    availableRoles: Array,
    permissions: Object,
});
</script>

<template>
    <AppLayout title="Team Settings">
        <h2
            class="font-['Orbitron'] text-2xl font-bold text-yellow-400 leading-tight glitch-text"
        >
            Team Settings
        </h2>

        <div class="cyberpunk-section">
            <div class="cyberpunk-container">
                <div class="cyberpunk-card">
                    <UpdateTeamNameForm
                        :team="team"
                        :permissions="permissions"
                    />
                </div>

                <div class="cyberpunk-card">
                    <TeamMemberManager
                        :team="team"
                        :available-roles="availableRoles"
                        :user-permissions="permissions"
                    />
                </div>
                <div v-if="permissions.canDeleteTeam && !team.personal_team">
                    <SectionBorder class="neon-border" />

                    <DeleteTeamForm :team="team" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
