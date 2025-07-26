<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>

    <Head title="Welcome - AI Travel Assistant" />
    <div class="bg-slate-900 text-white">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-teal-500 selection:text-white">
            <div class="absolute inset-0 z-0 opacity-10">
                <img class="w-full h-full object-cover"
                    src="https://images.unsplash.com/photo-1500835556837-99ac94a94552?q=80&w=2787&auto=format&fit=crop"
                    alt="World Map Background" />
            </div>
            <div class="relative w-full max-w-7xl px-6 lg:px-8 z-10">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:col-start-1">
                        <div class="flex items-center gap-x-2">
                            <svg class="h-10 w-auto text-teal-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM8.22 17.24c-1.04-.4-1.95-1-2.73-1.78.6-.96 1.43-1.74 2.4-2.28.97-.54 2.05-.8 3.11-.75v-2.09c-1.6-.2-3.13-.79-4.38-1.69-.1-.07-.12-.21-.05-.31.33-.51.76-.95 1.25-1.32.1-.07.24-.05.31.05 1.09 1.25 2.58 2.11 4.25 2.39v-2.1c0-.55.45-1 1-1s1 .45 1 1v2.1c1.67-.28 3.16-1.14 4.25-2.39.07-.09.22-.12.31-.05.49.37.92.81 1.25 1.32.07.1.05.24-.05.31-1.25.9-2.78 1.49-4.38 1.69v2.09c1.06-.05 2.14.21 3.11.75.97.54 1.8 1.32 2.4 2.28-.78.78-1.69 1.38-2.73 1.78-1.04.4-2.16.56-3.27.46-1.11.1-2.23-.06-3.27-.46z" />
                            </svg>
                            <span class="font-semibold text-xl">TravelAI</span>
                        </div>
                    </div>
                    <nav v-if="canLogin" class="flex flex-1 justify-end lg:col-start-3">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-white/80 ring-1 ring-transparent transition hover:text-white focus:outline-none focus-visible:ring-teal-500">
                        Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')"
                                class="rounded-md px-3 py-2 text-white/80 ring-1 ring-transparent transition hover:text-white focus:outline-none focus-visible:ring-teal-500">
                            Log in
                            </Link>
                            <Link v-if="canRegister" :href="route('register')"
                                class="ml-4 rounded-md px-3 py-2 text-white bg-teal-500 ring-1 ring-transparent transition hover:bg-teal-600 focus:outline-none focus-visible:ring-teal-500">
                            Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="my-20">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                            The Future of Travel is Intelligent
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-300">
                            Leverage our advanced AI platform to automate your travel agency, delight your clients, and
                            manage events
                            effortlessly.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="#"
                                class="rounded-md bg-teal-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-500">Get
                                Started</a>
                            <a href="#features"
                                class="text-sm font-semibold leading-6 text-white/80 transition hover:text-white">Learn
                                more <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <section id="features" class="bg-white text-gray-800 py-20 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-teal-600">Your Complete Travel Solution</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Everything you need to scale your travel business
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        From client-facing interactions to back-end operations, our AI handles the complexities so you
                        can focus
                        on creating unforgettable experiences.
                    </p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <svg class="h-5 w-5 flex-none text-teal-600" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 1a9 9 0 0 0-9 9c0 4.25 3.06 7.83 7 8.79V12h-2v-3h2V7a4 4 0 0 1 4-4h2v3h-2a1 1 0 0 0-1 1v2h3l-.5 3h-2.5v7.79A9 9 0 0 0 12 1z" />
                                </svg>
                                AI Assistant for Travel Agencies
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Provide 24/7 support to your clients with an intelligent chatbot
                                    that can
                                    handle inquiries, create itineraries, and process bookings, enhancing customer
                                    satisfaction
                                    and engagement.</p>
                            </dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <svg class="h-5 w-5 flex-none text-teal-600" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z" />
                                </svg>
                                Automated Email Management
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Streamline your workflow with automated email campaigns, from
                                    sending
                                    personalized travel offers to delivering booking confirmations and pre-trip
                                    reminders. [17]
                                </p>
                            </dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <svg class="h-5 w-5 flex-none text-teal-600" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-2 .9-2 2v12c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H5V10h14v8zM7 12h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z" />
                                </svg>
                                Effortless Event Management
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Automate every aspect of your event planning. Our AI can manage
                                    registrations, coordinate with vendors, send out automated updates, and handle guest
                                    inquiries seamlessly. [2]</p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <footer class="bg-slate-800 text-white/60 py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
                <p>TravelAI © 2025. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>