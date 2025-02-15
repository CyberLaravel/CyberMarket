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
                    :class="
                        cn(
                            'w-[200px] justify-between bg-gray-900 border-yellow-400 text-gray-100 hover:bg-gray-800 hover:text-yellow-400 hover:border-yellow-300 transition-all shadow-[0_0_5px_rgba(250,204,21,0.2)] hover:shadow-[0_0_10px_rgba(250,204,21,0.4)]',
                            $attrs.class ?? ''
                        )
                    "
                >
                    <Avatar class="mr-2 h-5 w-5 ring-1 ring-yellow-400/30">
                        <AvatarImage
                            :src="`https://avatar.vercel.sh/${selectedTeam.id}.png`"
                            :alt="selectedTeam.name"
                            class="grayscale hover:grayscale-0 transition-all"
                        />
                        <AvatarFallback class="bg-gray-800 text-yellow-400">{{
                            selectedTeam.name.charAt(0)
                        }}</AvatarFallback>
                    </Avatar>
                    {{ selectedTeam.name }}
                    <CaretSortIcon
                        class="ml-auto h-4 w-4 shrink-0 text-yellow-400"
                    />
                </Button>
            </PopoverTrigger>
            <PopoverContent
                class="w-[200px] p-0 bg-gray-900 border-yellow-400 shadow-[0_0_15px_rgba(250,204,21,0.3)]"
            >
                <Command
                    class="bg-transparent"
                    :filter-function="
                        (list, term) =>
                            list.filter(
                                (i) =>
                                    typeof i.name === 'string' &&
                                    i.name.toLowerCase().includes(term)
                            )
                    "
                >
                    <CommandList>
                        <CommandInput
                            placeholder="Search team..."
                            class="w-full bg-gray-900 text-gray-100 placeholder:text-gray-500 border-b border-yellow-400/30 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 transition-all px-4 py-2 outline-none hover:bg-gray-800"
                        />
                        <CommandEmpty class="text-gray-400 py-4"
                            >No team found.</CommandEmpty
                        >
                        <CommandGroup
                            v-for="group in groups"
                            :key="group.label"
                            :heading="group.label"
                            class="text-yellow-400"
                        >
                            <CommandItem
                                v-for="team in group.teams"
                                :key="team.id"
                                :value="team"
                                class="text-sm text-gray-100 hover:text-yellow-400 hover:bg-gray-800 cursor-pointer"
                                @select="
                                    () => {
                                        selectedTeam = team;
                                        open = false;
                                    }
                                "
                                @click="switchToTeam(team)"
                            >
                                <Avatar
                                    class="mr-2 h-5 w-5 ring-1 ring-yellow-400/30"
                                >
                                    <AvatarImage
                                        :src="`https://avatar.vercel.sh/${team.id}.png`"
                                        :alt="team.name"
                                        class="grayscale hover:grayscale-0 transition-all"
                                    />
                                    <AvatarFallback
                                        class="bg-gray-800 text-yellow-400"
                                    >
                                        {{ team.name.charAt(0) }}
                                    </AvatarFallback>
                                </Avatar>
                                {{ team.name }}
                                <CheckIcon
                                    :class="
                                        cn(
                                            'ml-auto h-4 w-4 text-yellow-400',
                                            team.id ===
                                                $page.props.auth.user
                                                    .current_team_id
                                                ? 'opacity-100'
                                                : 'opacity-0'
                                        )
                                    "
                                />
                            </CommandItem>
                        </CommandGroup>
                    </CommandList>
                    <CommandSeparator class="bg-yellow-400/30" />
                    <CommandList>
                        <CommandGroup>
                            <Link :href="route('teams.create')">
                                <CommandItem
                                    class="text-gray-100 hover:text-yellow-400 hover:bg-gray-800 cursor-pointer"
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
                                    class="text-gray-100 hover:text-yellow-400 hover:bg-gray-800 cursor-pointer"
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
.command-input {
    @apply bg-gray-800 text-gray-100 border-none focus:ring-2 focus:ring-yellow-400;
}

.command-list {
    scrollbar-width: thin;
    @apply overflow-auto;
}

.command-list::-webkit-scrollbar {
    @apply w-1.5;
}

.command-list::-webkit-scrollbar-track {
    @apply bg-gray-800;
}

.command-list::-webkit-scrollbar-thumb {
    @apply bg-yellow-400 rounded-full hover:bg-yellow-300 transition-colors;
}
</style>
