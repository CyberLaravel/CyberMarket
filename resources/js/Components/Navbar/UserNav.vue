<script setup>
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Link, router } from "@inertiajs/vue3";

const menuItems = [
    { route: "profile.show", label: "Profile", shortcut: "⇧⌘P" },
    { route: "profile.show", label: "Billing", shortcut: "⌘B" },
    { route: "profile.show", label: "Settings", shortcut: "⌘S" },
    { route: "profile.show", label: "New Team" },
];

const logout = () => {
    console.log("loggggging out");
    router.post(route("logout"));
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="relative h-8 w-8 rounded-full">
                <Avatar class="h-8 w-8">
                    <AvatarImage src="/avatars/01.png" alt="@shadcn" />
                    <AvatarFallback>SC</AvatarFallback>
                </Avatar>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-56" align="end">
            <DropdownMenuLabel class="font-normal flex">
                <div class="flex flex-col space-y-1">
                    <p class="text-sm font-medium leading-none">Joe doe</p>
                    <p class="text-xs leading-none text-muted-foreground">
                        m@example.com
                    </p>
                </div>
            </DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
                <Link
                    :href="route(item.route)"
                    v-for="item in menuItems"
                    :key="item.label"
                >
                    <DropdownMenuItem class="cursor-pointer">
                        {{ item.label }}
                        <DropdownMenuShortcut v-if="item.shortcut">{{
                            item.shortcut
                        }}</DropdownMenuShortcut>
                    </DropdownMenuItem>
                </Link>
            </DropdownMenuGroup>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
                <form @submit.prevent="logout">
                    <Button class="cursor-pointer w-full" variant="secondary">
                        Logout
                    </Button>
                </form>
            </DropdownMenuGroup>
            <DropdownMenuSeparator />
        </DropdownMenuContent>
    </DropdownMenu>
</template>
