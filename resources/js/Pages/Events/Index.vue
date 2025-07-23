<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

defineProps({
  events: Object,
  filters: Object,
});

const filters = ref({
  search: "",
  status: "",
});

watch(
  filters,
  () => {
    router.get("/events", filters.value, {
      preserveState: true,
      replace: true,
    });
  },
  { deep: true }
);

const updateFilters = () => {
  filters.value.search = filters.value.search;
  filters.value.status = filters.value.status;
};

const clearFilters = () => {
  filters.value = {
    search: "",
    status: "",
  };
  updateFilters();
};

const deleteEvent = (id) => {
  if (confirm("Are you sure you want to delete this event?")) {
    router.delete(`/events/${id}`);
  }
};

const goToPage = (url) => {
  if (url) {
    router.get(url, filters.value, { preserveState: true, replace: true });
  }
};
</script>

<template>
  <Head title="Events" />
  <AuthenticatedLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div
        class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6"
      >
        <h2 class="text-3xl font-extrabold text-gray-800">📅 Events</h2>
        <Link
          href="/events/create"
          class="bg-blue-600 text-white px-5 py-2.5 rounded-md hover:bg-blue-700 shadow transition"
        >
          + Add Event
        </Link>
      </div>

      <!-- Filters -->
      <!-- Filters with Clear Button -->
      <div class="flex flex-col sm:flex-row sm:items-end gap-4 mb-8">
        <div class="flex-1">
          <label class="block text-sm font-medium text-gray-700 mb-1"
            >Search</label
          >
          <input
            v-model="filters.search"
            placeholder="🔍 Search by title..."
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            @input="updateFilters"
          />
        </div>

        <div class="sm:w-1/4">
          <label class="block text-sm font-medium text-gray-700 mb-1"
            >Status</label
          >
          <select
            v-model="filters.status"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            @change="updateFilters"
          >
            <option value="">All Statuses</option>
            <option value="upcoming">Upcoming</option>
            <option value="ongoing">Ongoing</option>
            <option value="completed">Completed</option>
          </select>
        </div>

        <div class="sm:w-auto">
          <button
            @click="clearFilters"
            class="mt-1 sm:mt-6 w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-md border hover:bg-gray-200 transition"
          >
            ✖ Clear Filters
          </button>
        </div>
      </div>

      <!-- Event Cards Grid -->
      <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6"
      >
        <div
          v-for="event in events.data"
          :key="event.id"
          class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-lg transition duration-200 flex flex-col justify-between"
        >
          <!-- Title + Description -->
          <div class="mb-4">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              {{ event.title }}
            </h3>
            <p class="text-sm text-gray-600 line-clamp-2">
              {{ event.description || "No description provided." }}
            </p>
          </div>

          <!-- Metadata -->
          <div class="space-y-2 text-sm text-gray-700">
            <div class="flex justify-between gap-2">
              <span class="font-medium">📍 Location:</span>
              <span class="text-right truncate w-2/3">{{
                event.location || "N/A"
              }}</span>
            </div>
            <div class="flex justify-between gap-2">
              <span class="font-medium">📆 Date:</span>
              <span class="text-right">{{ event.date }}</span>
            </div>
            <div class="flex justify-between gap-2">
              <span class="font-medium">🏢 Company:</span>
              <span class="text-right truncate w-2/3">{{
                event.company?.name || "N/A"
              }}</span>
            </div>
            <div class="flex justify-between gap-2">
              <span class="font-medium">🔖 Status:</span>
              <span
                :class="{
                  'text-green-600 font-bold': event.status === 'upcoming',
                  'text-yellow-600 font-bold': event.status === 'ongoing',
                  'text-gray-600 font-bold': event.status === 'completed',
                }"
              >
                {{ event.status }}
              </span>
            </div>
          </div>

          <!-- Actions -->
          <div class="mt-5 flex justify-between items-center">
            <Link
              :href="`/events/${event.id}/edit`"
              class="text-blue-600 hover:underline text-sm font-medium"
            >
              ✏️ Edit
            </Link>
            <button
              @click="deleteEvent(event.id)"
              class="text-red-600 hover:underline text-sm font-medium"
            >
              🗑️ Delete
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div
        class="mt-10 flex flex-wrap justify-center items-center gap-4 text-sm text-gray-700"
      >
        <button
          :disabled="!events.prev_page_url"
          @click="goToPage(events.prev_page_url)"
          class="px-4 py-2 bg-gray-100 rounded-md border hover:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none transition"
        >
          ◀ Previous
        </button>
        <span class="font-medium">
          Page {{ events.current_page }} of {{ events.total }}
        </span>
        <button
          :disabled="!events.next_page_url"
          @click="goToPage(events.next_page_url)"
          class="px-4 py-2 bg-gray-100 rounded-md border hover:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none transition"
        >
          Next ▶
        </button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* line-clamp for description (if Tailwind plugin not used) */
.line-clamp-2 {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>
