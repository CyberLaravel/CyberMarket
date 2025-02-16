<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed, ref, onMounted } from "vue";
import TeamSwitcher from "./TeamSwitcher.vue";
import CartButton from "@/Components/Cart/CartButton.vue";
import { Search as SearchIcon } from "lucide-vue-next";
import { ShoppingCart } from "lucide-vue-next";
import { useCartStore } from "@/Stores/useCartStore";

import { CaretSortIcon, CheckIcon, PlusCircledIcon } from "@radix-icons/vue";
import { Settings } from "lucide-vue-next";

const dropdownOpen = ref(false);
const navDropdownOpen = ref(false);
const cartOpen = ref(false);
const teamSwitcherOpen = ref(false);

const page = usePage();
const user = computed(() => page.props.auth.user);
const isAuthenticated = computed(() => page.props.auth.user !== null);

// Guest navigation links
const authLinks = [
    { route: "login", label: "Login" },
    { route: "register", label: "Register" },
];

// Main navigation links
const mainNavLinks = computed(() => [
    { route: "dashboard", label: "Overview" },
    { route: "products.index", label: "Products" },
]);

// Additional navigation links based on user role
const additionalNavLinks = computed(() => {
    const links = [];

    if (!user.value.is_admin) {
        links.push({
            route: "seller.apply",
            label: "Become a Seller",
        });
    }

    if (user.value.is_admin) {
        links.push(
            {
                route: "seller.dashboard",
                label: "Seller Dashboard",
            },
            {
                route: "admin.dashboard",
                label: "Admin Dashboard",
            }
        );
    }

    return links;
});

// User menu items
const menuItems = [
    { route: "profile.show", label: "Profile", shortcut: "⇧⌘P" },
    { route: "profile.show", label: "Billing", shortcut: "⌘B" },
    { route: "profile.show", label: "Settings", shortcut: "⌘S" },
    { route: "profile.show", label: "New Team" },
];

const logout = () => {
    router.post(route("logout"));
};

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

const toggleNavDropdown = () => {
    navDropdownOpen.value = !navDropdownOpen.value;
};

const cart = useCartStore();
const selectedTeam = ref(
    isAuthenticated.value ? page.props.auth.user.current_team : null
);

const props = defineProps({
    teams: {
        type: Object,
        required: true,
    },
});

const mapTeamsToGroups = computed(() => {
    const teams = page.props.auth.user.all_teams;
    return [
        {
            label: "Personal Account",
            teams: Object.values(teams).filter((team) => team.personal_team),
        },
        {
            label: "Teams",
            teams: Object.values(teams).filter((team) => !team.personal_team),
        },
    ];
});

const switchToTeam = (team) => {
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
    teamSwitcherOpen.value = false;
    switchToTeam(team);
};

const toggleCart = () => {
    cartOpen.value = !cartOpen.value;
};

const searchQuery = ref("");

const handleSearch = (event) => {
    searchQuery.value = event.target.value;
    router.get(
        route("products.index"),
        {
            search: searchQuery.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["products"],
        }
    );
};

onMounted(() => {
    // Initialize search value from URL if present
    const urlParams = new URLSearchParams(window.location.search);
    searchQuery.value = urlParams.get("search") || "";
});
</script>

<template>
    <nav class="bg-gray-800 border-b border-yellow-400 shadow-glow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Authenticated Navbar -->
            <div
                v-if="isAuthenticated"
                class="flex items-center justify-between h-16"
            >
                <!-- Left Section: Logo and Navigation -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <Link
                        :href="route('dashboard')"
                        class="text-2xl font-bold text-yellow-400 font-orbitron hover:text-blue-300 transition-colors glitch-text"
                    >
                        CyberStore
                    </Link>

                    <!-- Team Switcher -->
                    <div class="relative">
                        <!-- Team Selector Button -->
                        <button
                            @click="teamSwitcherOpen = !teamSwitcherOpen"
                            class="flex items-center justify-between w-full px-4 py-2 text-sm bg-gray-900 border border-yellow-400 rounded-md text-gray-100 hover:bg-gray-800 hover:text-yellow-400 transition-colors duration-200"
                        >
                            <div class="flex items-center">
                                <!-- Team Avatar -->
                                <div class="relative w-5 h-5 mr-2">
                                    <img
                                        :src="`https://avatar.vercel.sh/${selectedTeam.id}.png`"
                                        :alt="selectedTeam.name"
                                        class="rounded-full border border-yellow-400"
                                    />
                                    <div
                                        v-if="
                                            !`https://avatar.vercel.sh/${selectedTeam.id}.png`
                                        "
                                        class="absolute inset-0 flex items-center justify-center bg-gray-800 text-yellow-400 rounded-full border border-yellow-400"
                                    >
                                        {{ selectedTeam.name.charAt(0) }}
                                    </div>
                                </div>
                                {{ selectedTeam.name }}
                            </div>
                            <CaretSortIcon
                                class="w-4 h-4 ml-2 text-yellow-400"
                            />
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            v-if="teamSwitcherOpen"
                            class="absolute z-50 w-[200px] mt-2 bg-gray-900 border border-yellow-400 rounded-md shadow-lg shadow-yellow-400/20"
                        >
                            <!-- Search Input -->
                            <div class="p-2 border-b border-yellow-400/20">
                                <input
                                    type="text"
                                    placeholder="Search team..."
                                    class="w-full px-2 py-1 bg-gray-900 text-gray-100 placeholder-gray-500 border-none focus:ring-2 focus:ring-yellow-400 rounded-md"
                                />
                            </div>

                            <!-- Team Groups -->
                            <div class="max-h-[300px] overflow-y-auto">
                                <div
                                    v-for="group in mapTeamsToGroups"
                                    :key="group.label"
                                >
                                    <div
                                        class="px-2 py-1 text-sm text-blue-300"
                                    >
                                        {{ group.label }}
                                    </div>

                                    <!-- Team Items -->
                                    <div
                                        v-for="team in group.teams"
                                        :key="team.id"
                                        @click="() => handleTeamSelect(team)"
                                        class="flex items-center px-2 py-1.5 text-gray-100 hover:bg-gray-800 hover:text-yellow-400 cursor-pointer"
                                    >
                                        <!-- Team Avatar -->
                                        <div class="relative w-5 h-5 mr-2">
                                            <img
                                                :src="`https://avatar.vercel.sh/${team.id}.png`"
                                                :alt="team.name"
                                                class="rounded-full border border-yellow-400"
                                            />
                                            <div
                                                v-if="
                                                    !`https://avatar.vercel.sh/${team.id}.png`
                                                "
                                                class="absolute inset-0 flex items-center justify-center bg-gray-800 text-yellow-400 rounded-full border border-yellow-400"
                                            >
                                                {{ team.name.charAt(0) }}
                                            </div>
                                        </div>
                                        {{ team.name }}
                                        <CheckIcon
                                            v-if="
                                                team.id ===
                                                $page.props.auth.user
                                                    .current_team_id
                                            "
                                            class="ml-auto h-4 w-4 text-yellow-400"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="h-px bg-yellow-400/20"></div>

                            <!-- Actions -->
                            <div class="p-1">
                                <Link
                                    :href="route('teams.create')"
                                    class="flex items-center px-2 py-1.5 text-gray-100 hover:bg-gray-800 hover:text-yellow-400 cursor-pointer rounded-sm"
                                >
                                    <PlusCircledIcon
                                        class="mr-2 h-5 w-5 text-yellow-400"
                                    />
                                    Create Team
                                </Link>

                                <Link
                                    :href="
                                        route(
                                            'teams.show',
                                            $page.props.auth.user
                                                .current_team_id
                                        )
                                    "
                                    class="flex items-center px-2 py-1.5 text-gray-100 hover:bg-gray-800 hover:text-yellow-400 cursor-pointer rounded-sm"
                                >
                                    <Settings
                                        class="mr-2 h-5 w-5 text-yellow-400"
                                    />
                                    Team Settings
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Main Navigation -->
                    <nav class="flex items-center space-x-8">
                        <!-- Main Nav Links -->
                        <Link
                            v-for="item in mainNavLinks"
                            :key="item.route"
                            :href="route(item.route)"
                            :class="[
                                'navbar-link relative group text-sm font-medium',
                                $page.url.startsWith(route(item.route))
                                    ? 'text-yellow-400 after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-yellow-400 after:shadow-[0_0_10px_rgba(250,204,21,0.5)]'
                                    : 'text-blue-300 hover:text-yellow-400',
                            ]"
                        >
                            {{ item.label }}
                        </Link>

                        <!-- More Dropdown -->
                        <div v-if="additionalNavLinks.length" class="relative">
                            <button
                                @click="toggleNavDropdown"
                                class="flex items-center space-x-1 text-blue-300 hover:text-yellow-400"
                            >
                                <span>More</span>
                                <svg
                                    class="w-4 h-4"
                                    :class="{ 'rotate-180': navDropdownOpen }"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>

                            <!-- Nav Dropdown Menu -->
                            <div
                                v-if="navDropdownOpen"
                                class="absolute left-0 mt-2 w-48 bg-gray-900 border border-yellow-400 rounded-md shadow-lg shadow-yellow-400/20 z-10"
                            >
                                <div class="py-1">
                                    <Link
                                        v-for="item in additionalNavLinks"
                                        :key="item.route"
                                        :href="route(item.route)"
                                        class="block px-4 py-2 text-sm text-gray-100 hover:text-yellow-400 hover:bg-gray-800"
                                    >
                                        {{ item.label }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- Right Section: Search, User, Cart -->
                <div class="flex items-center space-x-6">
                    <!-- Search Input -->
                    <div class="relative w-[300px]">
                        <SearchIcon
                            class="absolute left-3 top-2.5 h-4 w-4 text-yellow-400"
                        />
                        <input
                            type="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                            @input="handleSearch"
                            class="w-full bg-gray-800 border border-yellow-400 rounded-md py-2 pl-10 pr-4 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        />
                    </div>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button
                            @click="toggleDropdown"
                            class="relative h-8 w-8 rounded-full hover:bg-gray-800 focus:outline-none"
                        >
                            <img
                                v-if="user.profile_photo_url"
                                :src="user.profile_photo_url"
                                :alt="user.name"
                                class="h-8 w-8 rounded-full ring-1 ring-yellow-400 hover:grayscale-0 transition-all duration-300"
                            />
                            <div
                                v-else
                                class="h-8 w-8 rounded-full bg-gray-900 ring-1 ring-yellow-400 flex items-center justify-center text-yellow-400"
                            >
                                {{ user.name.charAt(0) }}
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            v-if="dropdownOpen"
                            class="absolute right-0 mt-2 w-56 bg-gray-900 border border-yellow-400 rounded-md shadow-lg shadow-yellow-400/20"
                        >
                            <div class="px-4 py-3">
                                <p class="text-sm font-medium text-gray-100">
                                    {{ user.name }}
                                </p>
                                <p class="text-xs text-blue-300">
                                    {{ user.email }}
                                </p>
                            </div>
                            <div class="border-t border-yellow-400"></div>
                            <div class="py-1">
                                <Link
                                    v-for="item in menuItems"
                                    :key="item.label"
                                    :href="route(item.route)"
                                    class="flex justify-between px-4 py-2 text-gray-100 hover:text-yellow-400 hover:bg-gray-800 transition-colors duration-200"
                                >
                                    {{ item.label }}
                                    <span
                                        v-if="item.shortcut"
                                        class="text-blue-300"
                                    >
                                        {{ item.shortcut }}
                                    </span>
                                </Link>
                            </div>
                            <div class="border-t border-yellow-400 py-1">
                                <form
                                    @submit.prevent="logout"
                                    class="px-4 py-2"
                                >
                                    <button
                                        type="submit"
                                        class="w-full bg-yellow-400 text-black hover:bg-yellow-300 transition-colors duration-200 py-2 px-4 rounded-md"
                                    >
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Button -->
                    <div class="relative">
                        <!-- Cart Button -->
                        <button
                            @click="toggleCart"
                            class="p-2 relative hover:bg-gray-800 rounded-md transition-colors"
                        >
                            <ShoppingCart
                                class="h-5 w-5 text-yellow-400 hover:text-blue-300 transition-colors"
                            />
                            <span
                                class="absolute -top-1 -right-1 h-4 w-4 rounded-full text-xs flex items-center justify-center bg-yellow-400 text-gray-900 border border-yellow-400 shadow-glow"
                            >
                                {{ cart.cartCount }}
                            </span>
                        </button>

                        <!-- Cart Drawer -->
                        <div
                            v-if="cartOpen"
                            class="fixed inset-0 bg-black bg-opacity-50 z-50"
                            @click="toggleCart"
                        ></div>

                        <div
                            v-if="cartOpen"
                            class="fixed right-0 top-0 h-full w-96 bg-gray-800 border-l border-yellow-400 shadow-lg z-50 transform transition-transform duration-300"
                        >
                            <!-- Header -->
                            <div class="p-6 border-b border-yellow-400/30">
                                <h2
                                    class="text-yellow-400 font-orbitron text-xl glitch-text"
                                >
                                    Shopping Cart
                                </h2>
                            </div>

                            <!-- Content -->
                            <div class="mt-4 p-6 space-y-4">
                                <div
                                    v-if="cart.items.length === 0"
                                    class="text-center py-6"
                                >
                                    <p class="text-gray-400">
                                        Your cart is empty
                                    </p>
                                </div>
                                <div v-else>
                                    <div
                                        v-for="item in cart.items"
                                        :key="item.id"
                                        class="flex items-center gap-4 py-4 border-b border-yellow-400/30"
                                    >
                                        <img
                                            :src="item.image"
                                            :alt="item.name"
                                            class="w-16 h-16 object-cover rounded border border-yellow-400/50"
                                        />
                                        <div class="flex-1">
                                            <h3
                                                class="font-medium text-gray-100"
                                            >
                                                {{ item.name }}
                                            </h3>
                                            <p class="text-sm text-blue-300">
                                                ${{ item.price }}
                                            </p>
                                            <div
                                                class="flex items-center gap-2 mt-2"
                                            >
                                                <button
                                                    class="w-8 h-8 flex items-center justify-center border border-yellow-400 text-yellow-400 rounded-md hover:bg-yellow-400 hover:text-gray-900 transition-colors"
                                                    @click="
                                                        cart.updateQuantity(
                                                            item.id,
                                                            item.quantity - 1
                                                        )
                                                    "
                                                >
                                                    -
                                                </button>
                                                <span class="text-gray-100">{{
                                                    item.quantity
                                                }}</span>
                                                <button
                                                    class="w-8 h-8 flex items-center justify-center border border-yellow-400 text-yellow-400 rounded-md hover:bg-yellow-400 hover:text-gray-900 transition-colors"
                                                    @click="
                                                        cart.updateQuantity(
                                                            item.id,
                                                            item.quantity + 1
                                                        )
                                                    "
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                        <button
                                            class="w-8 h-8 flex items-center justify-center bg-red-500 hover:bg-red-600 text-gray-100 rounded-md transition-colors"
                                            @click="
                                                cart.removeFromCart(item.id)
                                            "
                                        >
                                            ×
                                        </button>
                                    </div>

                                    <!-- Total and Checkout -->
                                    <div class="pt-4">
                                        <div class="flex justify-between mb-4">
                                            <span
                                                class="font-medium text-gray-100"
                                                >Total:</span
                                            >
                                            <span
                                                class="font-medium text-yellow-400"
                                                >${{
                                                    cart.cartTotal.toFixed(2)
                                                }}</span
                                            >
                                        </div>
                                        <Link
                                            :href="route('checkout.index')"
                                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium h-10 px-4 py-2 bg-yellow-400 text-gray-900 hover:bg-yellow-300 transition-colors shadow-glow"
                                        >
                                            Checkout
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guest Navbar -->
            <div v-else class="flex items-center justify-between h-16">
                <Link
                    :href="route('home')"
                    class="text-2xl font-bold text-yellow-400 font-orbitron hover:text-blue-300 transition-colors glitch-text"
                >
                    CyberStore
                </Link>

                <div class="flex items-center space-x-4">
                    <Link
                        v-for="item in authLinks"
                        :key="item.route"
                        :href="route(item.route)"
                        class="transition-all duration-300"
                    >
                        <button
                            :class="[
                                'px-4 py-2 rounded-md font-orbitron transition-all duration-300',
                                item.route === 'register'
                                    ? 'bg-yellow-400 text-gray-900 hover:bg-yellow-300 shadow-glow'
                                    : 'text-blue-300 hover:text-yellow-400',
                            ]"
                        >
                            {{ item.label }}
                        </button>
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
