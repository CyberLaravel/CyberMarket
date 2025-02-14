<script setup>
import { computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import CyberAuthCard from "@/Components/CyberAuthCard.vue";
import CyberAuthLogo from "@/Components/CyberAuthLogo.vue";
import CyberButton from "@/Components/CyberButton.vue";

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <Head title="Email Verification" />

    <CyberAuthCard>
        <template #logo>
            <CyberAuthLogo />
        </template>

        <div class="mb-4 text-sm text-blue-300">
            Before continuing, could you verify your email address by clicking
            on the link we just emailed to you? If you didn't receive the email,
            we will gladly send you another.
        </div>

        <div
            v-if="verificationLinkSent"
            class="mb-4 font-medium text-sm text-yellow-400"
        >
            A new verification link has been sent to the email address you
            provided in your profile settings.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <CyberButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </CyberButton>

                <div>
                    <Link
                        :href="route('profile.show')"
                        class="underline text-sm text-blue-300 hover:text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400"
                    >
                        Edit Profile</Link
                    >

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline text-sm text-blue-300 hover:text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 ms-2"
                    >
                        Log Out
                    </Link>
                </div>
            </div>
        </form>
    </CyberAuthCard>
</template>
