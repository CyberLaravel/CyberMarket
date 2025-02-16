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
            <Button
                variant="ghost"
                class="relative h-8 w-8 rounded-full hover:bg-gray-800"
            >
                <Avatar class="h-8 w-8 ring-1 ring-yellow-400">
                    <AvatarImage
                        :src="user.profile_photo_url"
                        :alt="user.name"
                        class="hover:grayscale-0 transition-all duration-300"
                    />
                    <AvatarFallback class="bg-gray-900 text-yellow-400">
                        {{ user.name.charAt(0) }}
                    </AvatarFallback>
                </Avatar>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent
            class="w-56 bg-gray-900 border border-yellow-400 shadow-lg shadow-yellow-400/20"
            align="end"
        >
            <DropdownMenuLabel class="font-normal">
                <div class="flex flex-col space-y-1">
                    <p class="text-sm font-medium leading-none text-gray-100">
                        {{ user.name }}
                    </p>
                    <p class="text-xs leading-none text-blue-300">
                        {{ user.email }}
                    </p>
                </div>
            </DropdownMenuLabel>
            <DropdownMenuSeparator class="bg-yellow-400" />
            <DropdownMenuGroup>
                <Link
                    :href="route(item.route)"
                    v-for="item in menuItems"
                    :key="item.label"
                >
                    <DropdownMenuItem
                        class="cursor-pointer text-gray-100 hover:text-yellow-400 hover:bg-gray-800 transition-colors duration-200"
                    >
                        {{ item.label }}
                        <DropdownMenuShortcut
                            v-if="item.shortcut"
                            class="text-blue-300"
                        >
                            {{ item.shortcut }}
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </Link>
            </DropdownMenuGroup>
            <DropdownMenuSeparator class="bg-yellow-400" />
            <DropdownMenuGroup>
                <form @submit.prevent="logout">
                    <Button
                        class="w-full bg-yellow-400 text-black hover:bg-yellow-300 transition-colors duration-200"
                    >
                        Logout
                    </Button>
                </form>
            </DropdownMenuGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
