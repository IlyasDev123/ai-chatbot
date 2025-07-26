<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r shadow-lg hidden sm:flex flex-col">
      <!-- Logo -->
      <div class="h-16 flex items-center px-6 border-b">
        <Link :href="route('dashboard')">
        <ApplicationLogo class="h-9 w-auto" />
        </Link>
      </div>

      <!-- Vertical Navigation Menu -->
      <nav class="px-4 py-6 space-y-2 flex flex-col">
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</NavLink>
        <NavLink :href="route('events.index')" :active="route().current('events.index')">Events</NavLink>
        <NavLink :href="route('chatbot.index')" :active="route().current('chatbot.index')">AI Agent</NavLink>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Top Bar with Profile Dropdown -->
      <div class="bg-white shadow-sm px-4 py-3 flex justify-between items-center sm:justify-end">
        <!-- Mobile Hamburger -->
        <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="sm:hidden text-gray-600">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path v-if="!showingNavigationDropdown" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <!-- Profile Dropdown (Desktop Only) -->
        <div class="hidden sm:block">
          <Dropdown align="right" width="48">
            <template #trigger>
              <button
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                <span>{{ $page.props.auth.user.name }}</span>
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.293 7.293L10 12l4.707-4.707" />
                </svg>
              </button>
            </template>
            <template #content>
              <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
              <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
            </template>
          </Dropdown>
        </div>
      </div>

      <!-- Mobile Navigation Menu -->
      <div v-if="showingNavigationDropdown" class="sm:hidden bg-white border-b">
        <div class="px-4 py-2 space-y-1">
          <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard
          </ResponsiveNavLink>
          <ResponsiveNavLink :href="route('events.index')" :active="route().current('events.index')">Events
          </ResponsiveNavLink>
          <ResponsiveNavLink :href="route('chatbot.index')" :active="route().current('chatbot.index')">AI Agent
          </ResponsiveNavLink>
        </div>
        <div class="border-t px-4 py-2">
          <div class="text-base font-medium text-gray-800">{{ $page.props.auth.user.name }}</div>
          <div class="text-sm font-medium text-gray-500">{{ $page.props.auth.user.email }}</div>
          <div class="mt-2 space-y-1">
            <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
            <ResponsiveNavLink :href="route('logout')" method="post" as="button">Log Out</ResponsiveNavLink>
          </div>
        </div>
      </div>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto">
        <header v-if="$slots.header" class="bg-white shadow-sm">
          <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <slot name="header" />
          </div>
        </header>

        <div class="py-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <slot />
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
