<script setup>
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import { Button } from "@/Components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);

const menuItems = [
    { route: "profile.show", label: "Profile", shortcut: "⇧⌘P" },
    { route: "profile.show", label: "Billing", shortcut: "⌘B" },
    { route: "profile.show", label: "Settings", shortcut: "⌘S" },
    { route: "profile.show", label: "New Team" },
];

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="relative h-8 w-8 rounded-full">
                <Avatar class="h-8 w-8 ring-1 ring-yellow-400/30">
                    <AvatarImage
                        :src="`https://avatar.vercel.sh/${user.id}.png`"
                        :alt="user.name"
                        class="grayscale hover:grayscale-0 transition-all"
                    />
                    <AvatarFallback class="bg-gray-800 text-primary">
                        {{ user.name.charAt(0) }}
                    </AvatarFallback>
                </Avatar>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-56 card-cyberpunk" align="end">
            <DropdownMenuLabel class="font-normal">
                <div class="flex flex-col space-y-1">
                    <p class="text-sm font-medium leading-none text-body">
                        {{ user.name }}
                    </p>
                    <p class="text-xs leading-none text-muted">
                        {{ user.email }}
                    </p>
                </div>
            </DropdownMenuLabel>
            <DropdownMenuSeparator class="bg-yellow-400/30" />
            <DropdownMenuGroup>
                <Link
                    :href="route(item.route)"
                    v-for="item in menuItems"
                    :key="item.label"
                >
                    <DropdownMenuItem
                        class="cursor-pointer text-body hover:text-primary hover:bg-gray-800"
                    >
                        {{ item.label }}
                        <DropdownMenuShortcut
                            v-if="item.shortcut"
                            class="text-muted"
                        >
                            {{ item.shortcut }}
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </Link>
            </DropdownMenuGroup>
            <DropdownMenuSeparator class="bg-yellow-400/30" />
            <DropdownMenuGroup>
                <form @submit.prevent="logout">
                    <Button class="w-full btn-primary"> Logout </Button>
                </form>
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
