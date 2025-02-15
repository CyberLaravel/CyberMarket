<script setup lang="ts">
import { cn } from "@/lib/utils";
import { Search } from "lucide-vue-next";
import {
    ComboboxInput,
    type ComboboxInputProps,
    useForwardProps,
} from "radix-vue";
import { computed, type HTMLAttributes } from "vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps<
    ComboboxInputProps & {
        class?: HTMLAttributes["class"];
    }
>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <div
        class="flex items-center border-b border-yellow-400/30 hover:border-yellow-400 px-4 py-2 bg-gray-900 hover:bg-gray-800 transition-all group"
        cmdk-input-wrapper
    >
        <Search
            class="mr-2 h-4 w-4 shrink-0 text-yellow-400/50 group-hover:text-yellow-400 transition-colors"
        />
        <ComboboxInput
            v-bind="{ ...forwardedProps, ...$attrs }"
            auto-focus
            :class="
                cn(
                    'flex h-8 w-full bg-transparent',
                    'text-sm text-gray-100',
                    'placeholder:text-gray-500',
                    'outline-none focus:ring-0',
                    'disabled:cursor-not-allowed disabled:opacity-50',
                    props.class
                )
            "
        />
    </div>
</template>
