<script setup>
import { Head } from "@inertiajs/vue3";
import Toaster from "@/components/ui/toast/Toaster.vue";
import TheNavbar from "@/Components/Navbar/TheNavbar.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";

defineProps({
    title: String,
});
</script>

<template>
    <div>
        <Head :title="title" />

        <TheNavbar :teams="$page.props.auth.user.all_teams" />

        <div>
            <!-- Page Heading -->
            <header class="my-2">
                <Card class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <CardHeader>
                        <CardTitle v-if="$slots.headerTitle">
                            <slot name="headerTitle" />
                        </CardTitle>
                        <CardDescription v-if="$slots.headerDescription">
                            <slot name="headerDescription" />
                        </CardDescription>
                    </CardHeader>
                    <CardContent v-if="$slots.headerContent">
                        <slot name="headerContent" />
                    </CardContent>
                    <CardFooter v-if="$slots.headerFooter">
                        <slot name="headerFooter" />
                    </CardFooter>
                </Card>
            </header>

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto">
                <slot />
            </main>

            <footer>
                <Card class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <CardHeader>
                        <CardTitle>
                            <slot name="footerTitle" />
                        </CardTitle>
                        <CardDescription>
                            <slot name="footerDescription" />
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <slot name="footerContent" />
                    </CardContent>
                    <CardFooter>
                        <slot name="footerFooter" />
                    </CardFooter>
                </Card>
            </footer>
        </div>
    </div>

    <Toaster />
</template>
