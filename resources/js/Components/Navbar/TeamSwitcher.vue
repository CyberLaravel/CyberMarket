<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";

import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import { Button } from "@/Components/ui/button";
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
    CommandSeparator,
} from "@/Components/ui/command";
import { Dialog } from "@/Components/ui/dialog";

import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";

import { cn } from "@/lib/utils";
import { CaretSortIcon, CheckIcon, PlusCircledIcon } from "@radix-icons/vue";
import { computed, ref } from "vue";
import { Settings } from "lucide-vue-next";

const page = usePage();
const selectedTeam = ref(page.props.auth.user.current_team);

const props = defineProps({
    teams: Array,
});

const mapTeamsToGroups = (teams) => {
    const personalTeams = teams.filter((team) => team.personal_team);
    const otherTeams = teams.filter((team) => !team.personal_team);

    return [
        {
            label: "Personal Account",
            teams: personalTeams,
        },
        {
            label: "Teams",
            teams: otherTeams,
        },
    ];
};

const groups = mapTeamsToGroups(props.teams);

const open = ref(false);
const showNewTeamDialog = ref(false);

const switchToTeam = (team) => {
    console.log({ t: team });
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const handleTeamSelect = (team) => {
    open.value = false;
    switchToTeam(team);
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <Dialog v-model:open="showNewTeamDialog">
        <Popover v-model:open="open">
            <PopoverTrigger as-child>
                <Button
                    variant="outline"
                    role="combobox"
                    aria-expanded="open"
                    aria-label="Select a team"
                    class="w-[200px] justify-between bg-gray-900 border-yellow-400 text-gray-100 hover:bg-gray-800 hover:text-yellow-400"
                >
                    <Avatar class="mr-2 h-5 w-5 border border-yellow-400">
                        <AvatarImage
                            :src="`https://avatar.vercel.sh/${selectedTeam.id}.png`"
                            :alt="selectedTeam.name"
                        />
                        <AvatarFallback class="bg-gray-800 text-yellow-400">
                            {{ selectedTeam.name.charAt(0) }}
                        </AvatarFallback>
                    </Avatar>
                    {{ selectedTeam.name }}
                    <CaretSortIcon
                        class="ml-auto h-4 w-4 shrink-0 text-yellow-400"
                    />
                </Button>
            </PopoverTrigger>
            <PopoverContent
                class="w-[200px] p-0 bg-gray-900 border border-yellow-400 text-gray-100 shadow-lg shadow-yellow-400/20"
            >
                <Command class="bg-gray-900">
                    <CommandList>
                        <CommandInput
                            placeholder="Search team..."
                            class="bg-gray-900 text-gray-100 placeholder:text-gray-500 border-b border-yellow-400/20"
                        />
                        <CommandEmpty class="text-gray-400 p-2">
                            No team found.
                        </CommandEmpty>
                        <CommandGroup
                            v-for="group in groups"
                            :key="group.label"
                            :heading="group.label"
                            class="text-blue-300 px-2 py-1"
                        >
                            <CommandItem
                                v-for="team in group.teams"
                                :key="team.id"
                                :value="team"
                                class="text-gray-100 rounded-sm px-2 py-1.5 hover:bg-gray-800 hover:text-yellow-400 cursor-pointer"
                                @select="() => handleTeamSelect(team)"
                            >
                                <Avatar
                                    class="mr-2 h-5 w-5 border border-yellow-400"
                                >
                                    <AvatarImage
                                        :src="`https://avatar.vercel.sh/${team.id}.png`"
                                        :alt="team.name"
                                    />
                                    <AvatarFallback
                                        class="bg-gray-800 text-yellow-400"
                                    >
                                        {{ team.name.charAt(0) }}
                                    </AvatarFallback>
                                </Avatar>
                                {{ team.name }}
                                <CheckIcon
                                    :class="[
                                        'ml-auto h-4 w-4 text-yellow-400',
                                        team.id ===
                                        $page.props.auth.user.current_team_id
                                            ? 'opacity-100'
                                            : 'opacity-0',
                                    ]"
                                />
                            </CommandItem>
                        </CommandGroup>
                    </CommandList>
                    <CommandSeparator class="bg-yellow-400/20 h-px" />
                    <CommandList>
                        <CommandGroup>
                            <Link :href="route('teams.create')">
                                <CommandItem
                                    class="text-gray-100 rounded-sm px-2 py-1.5 hover:bg-gray-800 hover:text-yellow-400 cursor-pointer"
                                    value="create-team"
                                >
                                    <PlusCircledIcon
                                        class="mr-2 h-5 w-5 text-yellow-400"
                                    />
                                    Create Team
                                </CommandItem>
                            </Link>
                            <Link
                                :href="
                                    route(
                                        'teams.show',
                                        $page.props.auth.user.current_team_id
                                    )
                                "
                            >
                                <CommandItem
                                    class="text-gray-100 rounded-sm px-2 py-1.5 hover:bg-gray-800 hover:text-yellow-400 cursor-pointer"
                                    value="team-settings"
                                >
                                    <Settings
                                        class="mr-2 h-5 w-5 text-yellow-400"
                                    />
                                    Team Settings
                                </CommandItem>
                            </Link>
                        </CommandGroup>
                    </CommandList>
                </Command>
            </PopoverContent>
        </Popover>
    </Dialog>
</template>

<style scoped>
/* Remove the local styles since they're now in components.css */
</style>
