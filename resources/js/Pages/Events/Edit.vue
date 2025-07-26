<template>
  <AppLayout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow">
      <h2 class="text-2xl font-bold mb-4">Edit Event</h2>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-sm font-medium">Title</label>
          <input v-model="form.title" type="text" class="w-full p-2 border rounded" required />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium">Description</label>
          <textarea v-model="form.description" class="w-full p-2 border rounded" required></textarea>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium">Date</label>
          <input v-model="form.date" type="date" class="w-full p-2 border rounded" required />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium">Location</label>
          <input v-model="form.location" type="text" class="w-full p-2 border rounded" required />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium">Status</label>
          <select v-model="form.status" class="w-full p-2 border rounded" required>
            <option value="upcoming">Upcoming</option>
            <option value="ongoing">Ongoing</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium">Company</label>
          <select v-model="form.company_id" class="w-full p-2 border rounded" required>
            <option v-for="company in companies" :key="company.id" :value="company.id">
              {{ company.name }}
            </option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium">Assign to User (Optional)</label>
          <select v-model="form.assigned_user_id" class="w-full p-2 border rounded">
            <option value="">None</option>
            <option v-for="user in users" :key="user.id" :value="user.id">
              {{ user.name }}
            </option>
          </select>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
          Update
        </button>
      </form>
      <Link href="/events" class="block mt-4 text-blue-500">Back to Events</Link>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AuthenticatedLayout";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
  event: Object,
  companies: Array,
  users: Array,
});

const form = useForm({
  title: props.event.title,
  description: props.event.description,
  date: props.event.date,
  location: props.event.location,
  status: props.event.status,
  company_id: props.event.company_id,
  assigned_user_id: props.event.user_id || "",
});

const submit = () => {
  form.put(`/events/${props.event.id}`);
};
</script>
