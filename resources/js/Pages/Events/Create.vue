<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
  companies: Array,
  users: Array,
});

const form = useForm({
  title: "",
  description: "",
  date: "",
  location: "",
  status: "upcoming",
  company_id: "",
});

const submit = () => {
  form.post("/events", {
    onSuccess: () => form.reset(),
  });
};
</script>
<template>
  <AuthenticatedLayout>
    <div
      class="max-w-3xl mx-auto mt-12 bg-white rounded-xl shadow-md px-8 py-10"
    >
      <h2 class="text-3xl font-bold text-gray-800 mb-6">📅 Create New Event</h2>
      <form @submit.prevent="submit" class="space-y-6">
        <!-- Title -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1"
            >Event Title</label
          >
          <input
            v-model="form.title"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
            placeholder="e.g., Annual Sales Meetup"
            required
          />
        </div>

        <!-- Description -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1"
            >Description</label
          >
          <textarea
            v-model="form.description"
            rows="3"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
            placeholder="Brief overview of the event"
            required
          ></textarea>
        </div>

        <!-- Date & Location (side by side on larger screens) -->
        <div class="grid sm:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1"
              >Date</label
            >
            <input
              v-model="form.date"
              type="date"
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
              required
            />
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1"
              >Location</label
            >
            <input
              v-model="form.location"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
              placeholder="e.g., Karachi Expo Center"
              required
            />
          </div>
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1"
            >Status</label
          >
          <select
            v-model="form.status"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
            required
          >
            <option value="upcoming">Upcoming</option>
            <option value="ongoing">Ongoing</option>
            <option value="completed">Completed</option>
          </select>
        </div>

        <!-- Company -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1"
            >Company</label
          >
          <select
            v-model="form.company_id"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
            required
          >
            <option value="" disabled selected>Select a company</option>
            <option
              v-for="company in companies"
              :key="company.id"
              :value="company.id"
            >
              {{ company.name }}
            </option>
          </select>
        </div>
        <!-- Submit Button -->
        <div class="pt-4">
          <button
            type="submit"
            class="w-full bg-blue-600 text-white font-semibold py-2.5 rounded-md hover:bg-blue-700 transition duration-200 shadow-md"
          >
            ➕ Create Event
          </button>
        </div>
      </form>

      <!-- Back Link -->
      <div class="mt-6 text-center">
        <Link href="/events" class="text-blue-500 hover:underline text-sm">
          ← Back to Events
        </Link>
      </div>
    </div>
  </AuthenticatedLayout>
</template>


