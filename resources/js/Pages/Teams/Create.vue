<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateTeamForm from "@/Pages/Teams/Partials/CreateTeamForm.vue";
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2
                class="font-['Orbitron'] text-2xl font-bold text-yellow-400 glitch-text"
            >
                Create Team
            </h2>
        </template>

        <div class="bg-gray-900">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateTeamForm />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.glitch-text {
    text-shadow: 0 0 10px rgba(255, 251, 0, 0.5),
        0 0 20px rgba(255, 251, 0, 0.3), 0 0 30px rgba(255, 251, 0, 0.1);
    animation: glitch 3s infinite;
}

@keyframes glitch {
    0% {
        text-shadow: 0 0 10px rgba(255, 251, 0, 0.5),
            0 0 20px rgba(255, 251, 0, 0.3), 0 0 30px rgba(255, 251, 0, 0.1);
    }
    50% {
        text-shadow: 0 0 12px rgba(255, 251, 0, 0.6),
            0 0 24px rgba(255, 251, 0, 0.4), 0 0 36px rgba(255, 251, 0, 0.2);
    }
    100% {
        text-shadow: 0 0 10px rgba(255, 251, 0, 0.5),
            0 0 20px rgba(255, 251, 0, 0.3), 0 0 30px rgba(255, 251, 0, 0.1);
    }
}
</style>
