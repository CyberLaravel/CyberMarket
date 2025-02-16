<script setup>
import { ref } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
    team: Object,
    availableRoles: Array,
    userPermissions: Object,
});

const page = usePage();

const addTeamMemberForm = useForm({
    email: "",
    role: null,
});

const updateRoleForm = useForm({
    role: null,
});

const leaveTeamForm = useForm({});
const removeTeamMemberForm = useForm({});

const currentlyManagingRole = ref(false);
const managingRoleFor = ref(null);
const confirmingLeavingTeam = ref(false);
const teamMemberBeingRemoved = ref(null);

const addTeamMember = () => {
    addTeamMemberForm.post(route("team-members.store", props.team), {
        errorBag: "addTeamMember",
        preserveScroll: true,
        onSuccess: () => addTeamMemberForm.reset(),
    });
};

const cancelTeamInvitation = (invitation) => {
    router.delete(route("team-invitations.destroy", invitation), {
        preserveScroll: true,
    });
};

const manageRole = (teamMember) => {
    managingRoleFor.value = teamMember;
    updateRoleForm.role = teamMember.membership.role;
    currentlyManagingRole.value = true;
};

const updateRole = () => {
    updateRoleForm.put(
        route("team-members.update", [props.team, managingRoleFor.value]),
        {
            preserveScroll: true,
            onSuccess: () => (currentlyManagingRole.value = false),
        }
    );
};

const confirmLeavingTeam = () => {
    confirmingLeavingTeam.value = true;
};

const leaveTeam = () => {
    leaveTeamForm.delete(
        route("team-members.destroy", [props.team, page.props.auth.user])
    );
};

const confirmTeamMemberRemoval = (teamMember) => {
    teamMemberBeingRemoved.value = teamMember;
};

const removeTeamMember = () => {
    removeTeamMemberForm.delete(
        route("team-members.destroy", [
            props.team,
            teamMemberBeingRemoved.value,
        ]),
        {
            errorBag: "removeTeamMember",
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => (teamMemberBeingRemoved.value = null),
        }
    );
};

const displayableRole = (role) => {
    return props.availableRoles.find((r) => r.key === role).name;
};
</script>

<template>
    <div>
        <div v-if="userPermissions.canAddTeamMembers">
            <hr
                class="border-t border-yellow-400/30 my-6 shadow-[0_0_10px_rgba(251,191,36,0.1)]"
            />

            <div class="md:grid md:grid-cols-3 md:gap-4 mt-6">
                <!-- Title Section -->
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3
                            class="text-2xl font-bold text-yellow-400 font-['Orbitron'] tracking-wide"
                        >
                            Add Team Member
                        </h3>
                        <p class="mt-3 text-sm text-blue-300 leading-relaxed">
                            Add a new team member to your team, allowing them to
                            collaborate with you.
                        </p>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form @submit.prevent="addTeamMember">
                        <div
                            class="bg-gray-800/80 backdrop-blur-sm rounded-lg p-4 space-y-3 border border-yellow-400/20"
                        >
                            <!-- Description -->
                            <div
                                class="max-w-xl text-sm text-blue-300 bg-gray-800/50 p-4 rounded-md"
                            >
                                Please provide the email address of the person
                                you would like to add to this team.
                            </div>

                            <!-- Member Email -->
                            <div class="space-y-2">
                                <label
                                    for="email"
                                    class="text-yellow-400 font-['Orbitron'] block"
                                >
                                    Email
                                </label>
                                <input
                                    id="email"
                                    v-model="addTeamMemberForm.email"
                                    type="email"
                                    class="w-full bg-gray-800/90 border border-yellow-400/50 text-gray-100 rounded-md transition-all duration-200 focus:border-yellow-400 focus:bg-gray-800 focus:ring-2 focus:ring-yellow-400/50"
                                />
                                <span
                                    v-if="addTeamMemberForm.errors.email"
                                    class="text-sm text-red-400"
                                >
                                    {{ addTeamMemberForm.errors.email }}
                                </span>
                            </div>

                            <!-- Role -->
                            <div
                                v-if="availableRoles.length > 0"
                                class="space-y-2"
                            >
                                <label
                                    for="roles"
                                    class="text-yellow-400 font-['Orbitron'] block"
                                >
                                    Role
                                </label>
                                <span
                                    v-if="addTeamMemberForm.errors.role"
                                    class="text-sm text-red-400"
                                >
                                    {{ addTeamMemberForm.errors.role }}
                                </span>

                                <div
                                    class="relative z-0 mt-2 bg-gray-800/50 rounded-lg border border-yellow-400/30"
                                >
                                    <button
                                        v-for="(role, i) in availableRoles"
                                        :key="role.key"
                                        type="button"
                                        class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-200 hover:bg-gray-900"
                                        :class="[
                                            i > 0
                                                ? 'border-t border-yellow-400/30'
                                                : '',
                                            addTeamMemberForm.role === role.key
                                                ? 'bg-gray-800'
                                                : 'bg-gray-800/90',
                                        ]"
                                        @click="
                                            addTeamMemberForm.role = role.key
                                        "
                                    >
                                        <div
                                            :class="{
                                                'opacity-50':
                                                    addTeamMemberForm.role &&
                                                    addTeamMemberForm.role !=
                                                        role.key,
                                            }"
                                        >
                                            <!-- Role Name -->
                                            <div class="flex items-center">
                                                <div
                                                    class="text-sm"
                                                    :class="
                                                        addTeamMemberForm.role ==
                                                        role.key
                                                            ? 'font-semibold text-yellow-400'
                                                            : 'text-blue-300'
                                                    "
                                                >
                                                    {{ role.name }}
                                                </div>

                                                <svg
                                                    v-if="
                                                        addTeamMemberForm.role ==
                                                        role.key
                                                    "
                                                    class="ms-2 size-5 text-yellow-400"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    />
                                                </svg>
                                            </div>

                                            <!-- Role Description -->
                                            <div
                                                class="mt-2 text-xs text-gray-400"
                                            >
                                                {{ role.description }}
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-end px-4 py-3 bg-gray-900/80 text-right rounded-b-lg"
                        >
                            <span
                                v-if="addTeamMemberForm.recentlySuccessful"
                                class="me-3 text-yellow-400"
                            >
                                Added.
                            </span>

                            <button
                                type="submit"
                                :disabled="addTeamMemberForm.processing"
                                :class="{
                                    'opacity-25': addTeamMemberForm.processing,
                                }"
                                class="bg-yellow-400 hover:bg-yellow-500 text-black font-['Orbitron'] px-4 py-2 rounded-md transition-all duration-300"
                            >
                                Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div
            v-if="
                team.team_invitations.length > 0 &&
                userPermissions.canAddTeamMembers
            "
        >
            <hr class="border-t border-yellow-400/30 my-8" />

            <div
                class="bg-gray-800/80 rounded-lg p-6 mt-10 border border-yellow-400/30"
            >
                <h3
                    class="text-2xl font-bold text-yellow-400 font-['Orbitron'] cyberpunk-glow"
                >
                    Pending Team Invitations
                </h3>
                <p class="mt-3 text-sm text-blue-300">
                    These people have been invited to your team and have been
                    sent an invitation email. They may join the team by
                    accepting the email invitation.
                </p>

                <div class="mt-6 space-y-6">
                    <div
                        v-for="invitation in team.team_invitations"
                        :key="invitation.id"
                        class="flex items-center justify-between"
                    >
                        <div class="text-gray-600 dark:text-gray-400">
                            {{ invitation.email }}
                        </div>

                        <div class="flex items-center">
                            <!-- Cancel Team Invitation -->
                            <button
                                v-if="userPermissions.canRemoveTeamMembers"
                                class="cursor-pointer ms-6 text-sm text-red-500 focus:outline-none"
                                @click="cancelTeamInvitation(invitation)"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="team.users.length > 0">
            <hr class="border-t border-yellow-400/30 my-8" />

            <div
                class="bg-gray-800/80 rounded-lg p-6 mt-10 border border-yellow-400/30"
            >
                <h3
                    class="text-2xl font-bold text-yellow-400 font-['Orbitron'] cyberpunk-glow"
                >
                    Team Members
                </h3>
                <p class="mt-3 text-sm text-blue-300">
                    All of the people that are part of this team.
                </p>

                <div class="mt-6 space-y-6">
                    <div
                        v-for="user in team.users"
                        :key="user.id"
                        class="flex items-center justify-between"
                    >
                        <div class="flex items-center">
                            <img
                                class="size-8 rounded-full object-cover"
                                :src="user.profile_photo_url"
                                :alt="user.name"
                            />
                            <div class="ms-4 dark:text-white">
                                {{ user.name }}
                            </div>
                        </div>

                        <div class="flex items-center">
                            <!-- Manage Team Member Role -->
                            <button
                                v-if="
                                    userPermissions.canUpdateTeamMembers &&
                                    availableRoles.length
                                "
                                class="ms-2 text-sm text-gray-400 underline"
                                @click="manageRole(user)"
                            >
                                {{ displayableRole(user.membership.role) }}
                            </button>

                            <div
                                v-else-if="availableRoles.length"
                                class="ms-2 text-sm text-gray-400"
                            >
                                {{ displayableRole(user.membership.role) }}
                            </div>

                            <!-- Leave Team -->
                            <button
                                v-if="$page.props.auth.user.id === user.id"
                                class="cursor-pointer ms-6 text-sm text-red-500"
                                @click="confirmLeavingTeam"
                            >
                                Leave
                            </button>

                            <!-- Remove Team Member -->
                            <button
                                v-else-if="userPermissions.canRemoveTeamMembers"
                                class="cursor-pointer ms-6 text-sm text-red-500"
                                @click="confirmTeamMemberRemoval(user)"
                            >
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Management Modal -->
        <div
            v-if="currentlyManagingRole"
            class="fixed inset-0 bg-gray-900/75 flex items-center justify-center z-50"
        >
            <div
                class="bg-gray-800 rounded-lg max-w-2xl w-full mx-4 border border-yellow-400"
            >
                <div class="p-6">
                    <h3
                        class="text-2xl font-['Orbitron'] text-yellow-400 font-bold cyberpunk-glow"
                    >
                        Manage Role
                    </h3>

                    <div class="space-y-2">
                        <button
                            v-for="(role, i) in availableRoles"
                            :key="role.key"
                            type="button"
                            class="w-full p-4 rounded-lg transition-all duration-200 relative group border"
                            :class="{
                                'bg-gray-800 border-yellow-400 shadow-[0_0_10px_rgba(251,191,36,0.3)]':
                                    updateRoleForm.role === role.key,
                                'bg-gray-800/50 border-gray-700 hover:border-yellow-400/50 hover:bg-gray-900':
                                    updateRoleForm.role !== role.key,
                            }"
                            @click="updateRoleForm.role = role.key"
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="text-lg font-['Orbitron']"
                                            :class="{
                                                'text-yellow-400 cyberpunk-glow':
                                                    updateRoleForm.role ===
                                                    role.key,
                                                'text-gray-100':
                                                    updateRoleForm.role !==
                                                    role.key,
                                            }"
                                        >
                                            {{ role.name }}
                                        </span>
                                    </div>
                                    <p
                                        class="mt-2 text-sm"
                                        :class="{
                                            'text-blue-300':
                                                updateRoleForm.role ===
                                                role.key,
                                            'text-gray-400':
                                                updateRoleForm.role !==
                                                role.key,
                                        }"
                                    >
                                        {{ role.description }}
                                    </p>
                                </div>

                                <div
                                    v-if="updateRoleForm.role === role.key"
                                    class="text-yellow-400"
                                >
                                    <svg
                                        class="size-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <button
                            @click="currentlyManagingRole = false"
                            class="border border-gray-600 text-gray-300 hover:border-yellow-400 hover:text-yellow-400 font-['Orbitron'] px-4 py-2 rounded-md"
                        >
                            Cancel
                        </button>
                        <button
                            @click="updateRole"
                            :disabled="updateRoleForm.processing"
                            class="bg-yellow-400 hover:bg-yellow-500 text-black font-['Orbitron'] font-bold px-4 py-2 rounded-md"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Team Confirmation Modal -->
        <div
            v-if="confirmingLeavingTeam"
            class="fixed inset-0 flex items-center justify-center z-50"
        >
            <div
                class="fixed inset-0 bg-black/50"
                @click="confirmingLeavingTeam = false"
            ></div>

            <div
                class="relative bg-gray-800 p-6 rounded-lg border border-yellow-400/30 max-w-md w-full m-4"
            >
                <!-- Modal Title -->
                <span
                    class="font-['Orbitron'] text-yellow-400 text-xl font-bold neon-text block mb-4"
                >
                    Leave Team
                </span>

                <!-- Modal Content -->
                <div class="text-gray-100 mb-6">
                    Are you sure you would like to leave this team?
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3">
                    <button
                        @click="confirmingLeavingTeam = false"
                        class="font-['Orbitron'] border border-yellow-400 text-yellow-400 hover:bg-yellow-400/10 px-4 py-2 rounded-md transition-all duration-300"
                    >
                        Cancel
                    </button>

                    <button
                        class="font-['Orbitron'] bg-red-500 hover:bg-red-600 text-white transition-all duration-300 hover:shadow-[0_0_15px_rgba(239,68,68,0.5)] px-4 py-2 rounded-md"
                        :class="{ 'opacity-25': leaveTeamForm.processing }"
                        :disabled="leaveTeamForm.processing"
                        @click="leaveTeam"
                    >
                        Leave
                    </button>
                </div>
            </div>
        </div>

        <!-- Remove Team Member Confirmation Modal -->
        <div
            v-if="teamMemberBeingRemoved"
            class="fixed inset-0 flex items-center justify-center z-50"
        >
            <div
                class="fixed inset-0 bg-black/50"
                @click="teamMemberBeingRemoved = null"
            ></div>

            <div
                class="relative bg-gray-800 p-6 rounded-lg border border-yellow-400/30 max-w-md w-full m-4"
            >
                <!-- Modal Title -->
                <span
                    class="font-['Orbitron'] text-yellow-400 text-xl font-bold neon-text block mb-4"
                >
                    Remove Team Member
                </span>

                <!-- Modal Content -->
                <div class="text-gray-100 mb-6">
                    Are you sure you would like to remove this person from the
                    team?
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3">
                    <button
                        @click="teamMemberBeingRemoved = null"
                        class="font-['Orbitron'] border border-yellow-400 text-yellow-400 hover:bg-yellow-400/10 px-4 py-2 rounded-md transition-all duration-300"
                    >
                        Cancel
                    </button>

                    <button
                        class="font-['Orbitron'] bg-red-500 hover:bg-red-600 text-white transition-all duration-300 hover:shadow-[0_0_15px_rgba(239,68,68,0.5)] px-4 py-2 rounded-md"
                        :class="{
                            'opacity-25': removeTeamMemberForm.processing,
                        }"
                        :disabled="removeTeamMemberForm.processing"
                        @click="removeTeamMember"
                    >
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Base Text Colors */
:deep(.text-gray-600),
:deep(.dark\:text-gray-400),
:deep(.text-gray-900),
:deep(.dark\:text-white),
:deep(.text-gray-700),
:deep(.dark\:text-gray-300) {
    @apply text-gray-100;
}

/* Input Styling */
:deep(.cyberpunk-input) {
    @apply bg-gray-800/90 border border-yellow-400/50 text-gray-100 rounded-md;
    transition: all 0.2s ease;
}

:deep(.cyberpunk-input:focus) {
    @apply border-yellow-400 bg-gray-800;
    box-shadow: 0 0 10px rgba(251, 191, 36, 0.15);
}

/* Button Styling */
:deep(button) {
    transition: all 0.2s ease;
}

:deep(button:hover:not(:disabled)) {
    @apply bg-gray-900;
}

/* Role Selection Buttons */
:deep(.border-gray-200),
:deep(.dark\:border-gray-700) {
    @apply border-yellow-400/30 bg-gray-800/90;
}

/* Team Member List */
:deep(.space-y-6 > div) {
    @apply bg-gray-800/90 p-3 flex items-center;
    border: 1px solid theme("colors.yellow.400/20");
    border-radius: 0.375rem;
    transition: all 0.2s ease;
    margin-bottom: 0.5rem;
}

:deep(.space-y-6 > div:hover) {
    @apply bg-gray-800 border-yellow-400/30;
    transform: translateX(2px);
}

/* Profile Images */
:deep(img.rounded-full) {
    @apply ring-2 ring-yellow-400/20 ring-offset-2 ring-offset-gray-800;
    transition: all 0.2s ease;
}

:deep(.space-y-6 > div:hover img.rounded-full) {
    @apply ring-yellow-400/40;
}

/* Section Headers */
:deep(h3.text-2xl) {
    @apply tracking-wide;
    text-shadow: 0 0 20px theme("colors.yellow.400/20");
}

/* Section Dividers */
:deep(hr) {
    @apply my-6 border-yellow-400/20;
    box-shadow: 0 0 10px theme("colors.yellow.400/10");
}

/* Section Cards */
:deep(.bg-gray-800\/80) {
    @apply backdrop-blur-sm;
    border: 1px solid theme("colors.yellow.400/20");
}

/* Action Buttons */
:deep(.text-red-500) {
    @apply transition-colors duration-200 px-2 py-1 rounded;
}

:deep(.text-red-500:hover) {
    @apply bg-red-500/10 text-red-400;
}

/* Role Badge */
:deep(.text-gray-400.underline) {
    @apply px-2 py-0.5 rounded-full border border-yellow-400/20 no-underline;
    transition: all 0.2s ease;
}

:deep(.text-gray-400.underline:hover) {
    @apply border-yellow-400/40 bg-gray-800;
}

/* Modal Styling */
:deep(.modal-backdrop) {
    @apply bg-gray-900/75 backdrop-blur-sm;
}

:deep(.modal-content) {
    @apply bg-gray-800/95 border border-yellow-400/30;
    box-shadow: 0 0 30px theme("colors.yellow.400/5");
}

/* Focus States */
:deep(*:focus-visible) {
    @apply outline-none ring-2 ring-yellow-400/50;
}

/* Section Spacing */
:deep(.md\:gap-6) {
    @apply gap-4;
}
:deep(.mt-8) {
    @apply mt-6;
}
:deep(.mt-10) {
    @apply mt-6;
}
:deep(.space-y-6) {
    @apply space-y-3;
}
:deep(.my-8) {
    @apply my-6;
}
:deep(.p-6) {
    @apply p-4;
}

/* Transitions */
:deep(.transition-all) {
    transition-duration: 200ms;
}

/* Success Messages */
:deep(.text-green-400) {
    @apply text-yellow-400;
}

/* Error Messages */
:deep(.text-red-400) {
    text-shadow: 0 0 10px theme("colors.red.400/30");
}
</style>
