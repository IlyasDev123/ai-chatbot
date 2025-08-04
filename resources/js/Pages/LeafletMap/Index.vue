<template>
  <AuthenticatedLayout>
    <div class="max-w-6xl mx-auto p-4">
      <!-- Search Bar -->
      <form @submit.prevent="getPlaces" class="mb-6 flex gap-2">
        <input v-model="userPrompt" type="text" placeholder="Search places with AI"
          class="border border-gray-300 p-2 rounded w-full" />
        <button :disabled="loading" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          {{ loading ? 'Searching...' : 'Search' }}
        </button>
      </form>

      <!-- Example Prompts -->
      <div class="flex gap-2 mb-4 text-sm">
        <button v-for="example in examples" :key="example" @click="useExample(example)"
          class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded">
          {{ example }}
        </button>
      </div>

      <!-- Leaflet Map -->
      <l-map ref="mapRef" style="height: 60vh; width: 100%" :zoom="zoom" :center="center" :scroll-wheel-zoom="true">
        <l-tile-layer :url="tileUrl" :attribution="tileAttribution" />
        <l-marker v-for="(place, index) in places" :key="index" :lat-lng="[place.lat, place.lng]">
          <l-popup>
            <strong>{{ place.name }}</strong><br />
            <span class="text-sm text-gray-600">{{ place.description }}</span><br />
            <span v-if="place.distance_km" class="text-xs text-gray-500">~{{ place.distance_km }} km</span><br />
            <a :href="getGoogleMapsLink(place)" target="_blank" rel="noopener noreferrer"
              class="text-blue-600 hover:underline text-sm mt-1 block">
              View in Google Maps ↗
            </a>
          </l-popup>
        </l-marker>
      </l-map>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


const mapRef = ref(null);
const zoom = ref(8);
const center = ref([35.9, 74.3]); // Center of Gilgit-Baltistan
const tileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
const tileAttribution =
  '&copy; <a href="https://www.openstreetmap.org">OpenStreetMap</a> contributors';

const userPrompt = ref("Top lakes in Gilgit-Baltistan");
const places = ref([]);
const loading = ref(false);

const examples = [
  "Hidden valleys in Hunza",
  "Historical forts in Skardu",
  "Best viewpoints in Nagar",
  "Adventure spots in Khaplu",
];

// Fetch places from backend (e.g. Gemini or custom AI)
const getPlaces = async () => {
  loading.value = true;
  try {
    const { data } = await axios.post("/ai/map", {
      prompt: `
        You are a travel assistant.
        List 5 beautiful places in "${userPrompt.value}" with:
        - name,
        - lat, lng,
        - short description,
        - category,
        - distance_km.
        Return only JSON array.
      `.trim(),
    });

    if (Array.isArray(data) && data.length) {
      places.value = data;

      const bounds = L.latLngBounds(data.map((p) => [p.lat, p.lng]));
      mapRef.value?.leafletObject?.fitBounds(bounds);
    } else {
      alert("No places found.");
    }
  } catch (error) {
    console.error("Error fetching places:", error);
    alert("Failed to fetch places.");
  } finally {
    loading.value = false;
  }
};

const useExample = (example) => {
  userPrompt.value = example;
  getPlaces();
};

// Create Google Maps link (marker view, not Street View)
const getGoogleMapsLink = (place) => {
  return `https://www.google.com/maps?q=${place.lat},${place.lng}&z=15`;
};
</script>
