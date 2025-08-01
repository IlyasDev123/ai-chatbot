<template>
  <div class="max-w-6xl mx-auto p-4">
    <!-- Search Form -->
    <form @submit.prevent="getPlaces" class="mb-6 flex gap-2 items-center">
      <input
        v-model="userPrompt"
        type="text"
        placeholder="Search places with AI (e.g. 'Hidden lakes in Skardu')"
        class="border border-gray-300 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
      />
      <button
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded transition"
        :disabled="loading"
      >
        {{ loading ? "Searching..." : "Search" }}
      </button>
    </form>

    <!-- AI Suggestions -->
    <div class="flex gap-2 mb-4 text-sm">
      <button
        v-for="example in examples"
        :key="example"
        @click="useExample(example)"
        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded"
      >
        {{ example }}
      </button>
    </div>

    <!-- Leaflet Map -->
    <l-map
      ref="mapRef"
      style="height: 550px; width: 100%"
      :zoom="zoom"
      :center="center"
      :scroll-wheel-zoom="true"
    >
      <l-tile-layer :url="tileUrl" :attribution="tileAttribution" />
      <l-marker
        v-for="(place, index) in places"
        :key="index"
        :lat-lng="[place.lat, place.lng]"
      >
        <l-popup>
          <strong>{{ place.name }}</strong
          ><br />
          <span class="text-sm text-gray-600">{{ place.description }}</span
          ><br />
          <span v-if="place.distance_km" class="text-xs text-gray-500">
            ~{{ place.distance_km }} km from center
          </span>
        </l-popup>
      </l-marker>
    </l-map>

    <!-- No Data -->
    <div
      v-if="!places.length && !loading"
      class="text-center text-gray-500 mt-6"
    >
      No places loaded. Try entering a location or theme above.
    </div>
  </div>
</template>

  <script setup>
import { ref } from "vue";
import axios from "axios";
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import L from "leaflet";

// Map Setup
const center = ref([35.9, 74.3]); // Gilgit-Baltistan
const zoom = ref(8);
const tileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
const tileAttribution =
  '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>';

// Reactive Data
const mapRef = ref(null);
const places = ref([]);
const userPrompt = ref("Top 5 lakes in Gilgit-Baltistan");
const loading = ref(false);
const examples = [
  "Hidden valleys in Hunza",
  "Historical sites in Gilgit",
  "Best viewpoints in Skardu",
  "Beautiful lakes in Astore",
];

// Fetch Data from AI API
const getPlaces = async () => {
  loading.value = true;
  try {
    const { data } = await axios.post("/ai/map", {
      prompt: `
  You are a travel assistant.
  List 5 beautiful places in "${userPrompt.value}" with:
  - name,
  - exact coordinates (latitude, longitude),
  - short description,
  - category (e.g., lake, fort, viewpoint),
  - distance from center (in kilometers).
  Return only a clean JSON array with fields:
  name, lat, lng, description, category, distance_km.
        `.trim(),
    });

    if (Array.isArray(data) && data.length) {
      places.value = data;

      const bounds = L.latLngBounds(data.map((p) => [p.lat, p.lng]));
      mapRef.value?.leafletObject?.fitBounds(bounds);
    } else {
      places.value = [];
      alert("No locations found for this prompt.");
    }
  } catch (e) {
    console.error("AI map error:", e);
    alert("Failed to load places. Please try again.");
  } finally {
    loading.value = false;
  }
};

// Use example prompts
const useExample = (text) => {
  userPrompt.value = text;
  getPlaces();
};
</script>
