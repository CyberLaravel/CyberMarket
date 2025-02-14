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
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";

import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";

import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { cn } from "@/lib/utils";
import { CaretSortIcon, CheckIcon, PlusCircledIcon } from "@radix-icons/vue";
import { computed, ref } from "vue";
import { Settings } from "lucide-vue-next";

const props = defineProps(["teams"]);

// Function to map teams data to groups format
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
const selectedTeam = ref(usePage().props.auth.user.current_team);

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
                    :class="cn('w-[200px] justify-between', $attrs.class ?? '')"
                >
                    <Avatar class="mr-2 h-5 w-5">
                        <AvatarImage
                            :src="`https://avatar.vercel.sh/${selectedTeam.id}.png`"
                            :alt="selectedTeam.name"
                        />
                        <AvatarFallback>SC</AvatarFallback>
                    </Avatar>
                    {{ selectedTeam.name }}
                    <CaretSortIcon
                        class="ml-auto h-4 w-4 shrink-0 opacity-50"
                    />
                </Button>
            </PopoverTrigger>
            <PopoverContent class="w-[200px] p-0">
                <Command
                    :filter-function="
                        (list, term) =>
                            list.filter((i) =>
                                i.name?.toLowerCase()?.includes(term)
                            )
                    "
                >
                    <CommandList>
                        <CommandInput placeholder="Search team..." />
                        <CommandEmpty>No team found.</CommandEmpty>
                        <CommandGroup
                            v-for="group in groups"
                            :key="group.label"
                            :heading="group.label"
                        >
                            <CommandItem
                                v-for="team in group.teams"
                                :key="team.id"
                                :value="team"
                                class="text-sm"
                                @select="
                                    () => {
                                        selectedTeam = team;
                                        open = false;
                                    }
                                "
                                @click="switchToTeam(team)"
                            >
                                <Avatar class="mr-2 h-5 w-5">
                                    <AvatarImage
                                        :src="`https://avatar.vercel.sh/${team.id}.png`"
                                        :alt="team.name"
                                        class="grayscale"
                                    />
                                    <AvatarFallback>SC</AvatarFallback>
                                </Avatar>
                                {{ team.name }}
                                <CheckIcon
                                    :class="
                                        cn(
                                            'ml-auto h-4 w-4',
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
                    <CommandSeparator />
                    <CommandList>
                        <CommandGroup>
                            <Link :href="route('teams.create')">
                                <CommandItem value="create-team">
                                    <PlusCircledIcon class="mr-2 h-5 w-5" />
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
                                <CommandItem value="team-settings">
                                    <Settings class="mr-2 h-5 w-5" />
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
