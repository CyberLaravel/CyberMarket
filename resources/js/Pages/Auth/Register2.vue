<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import CyberAuthLogo from "@/Components/CyberAuthLogo.vue";
import CyberButton from "@/Components/CyberButton.vue";
import CyberInput from "@/Components/CyberInput.vue";
import CyberInputError from "@/Components/CyberInputError.vue";
import CyberInputLabel from "@/Components/CyberInputLabel.vue";
import CyberAuthCard from "@/Components/CyberAuthCard.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />

    <CyberAuthCard>
        <template #logo>
            <CyberAuthLogo />
        </template>

        <form @submit.prevent="submit">
            <div>
                <CyberInputLabel for="name" value="Name" />
                <CyberInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <CyberInputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <CyberInputLabel for="email" value="Email" />
                <CyberInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <CyberInputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <CyberInputLabel for="password" value="Password" />
                <CyberInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <CyberInputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <CyberInputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />
                <CyberInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <CyberInputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div
                v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                class="mt-4"
            >
                <CyberInputLabel for="terms">
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="terms"
                            v-model="form.terms"
                            name="terms"
                            class="rounded border-gray-300 text-yellow-400 shadow-sm focus:ring-yellow-400"
                        />

                        <div class="ms-2">
                            I agree to the
                            <a
                                target="_blank"
                                :href="route('terms.show')"
                                class="underline text-sm text-blue-300 hover:text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400"
                                >Terms of Service</a
                            >
                            and
                            <a
                                target="_blank"
                                :href="route('policy.show')"
                                class="underline text-sm text-blue-300 hover:text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400"
                                >Privacy Policy</a
                            >
                        </div>
                    </div>
                    <CyberInputError
                        class="mt-2"
                        :message="form.errors.terms"
                    />
                </CyberInputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-blue-300 hover:text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400"
                >
                    Already registered?
                </Link>

                <CyberButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </CyberButton>
            </div>
        </form>
    </CyberAuthCard>
</template>
