<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex items-center w-full px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm transition-all'
        : 'flex items-center w-full px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-all',
);
</script>

<template>
    <Link :href="href" :class="classes">
    <slot />
    </Link>
</template>
