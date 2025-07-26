<template>
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-900">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0 opacity-10">
            <img class="w-full h-full object-cover"
                src="https://images.unsplash.com/photo-1500835556837-99ac94a94552?q=80&w=2787&auto=format&fit=crop"
                alt="World Map Background" />
        </div>

        <!-- Logo -->
        <div class="z-10">
            <Link href="/" class="flex items-center gap-x-2">
            <svg class="h-12 w-auto text-teal-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM8.22 17.24c-1.04-.4-1.95-1-2.73-1.78.6-.96 1.43-1.74 2.4-2.28.97-.54 2.05-.8 3.11-.75v-2.09c-1.6-.2-3.13-.79-4.38-1.69-.1-.07-.12-.21-.05-.31.33-.51.76-.95 1.25-1.32.1-.07.24-.05.31.05 1.09 1.25 2.58 2.11 4.25 2.39v-2.1c0-.55.45-1 1-1s1 .45 1 1v2.1c1.67-.28 3.16-1.14 4.25-2.39.07-.09.22-.12.31-.05.49.37.92.81 1.25 1.32.07.1.05.24-.05.31-1.25.9-2.78 1.49-4.38 1.69v2.09c1.06-.05 2.14.21 3.11.75.97.54 1.8 1.32 2.4 2.28-.78.78-1.69 1.38-2.73 1.78-1.04.4-2.16.56-3.27.46-1.11.1-2.23-.06-3.27-.46z" />
            </svg>
            <span class="font-semibold text-2xl text-white">TravelAI</span>
            </Link>
        </div>

        <!-- Form Card -->
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-8 bg-slate-800/60 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-lg z-10">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>