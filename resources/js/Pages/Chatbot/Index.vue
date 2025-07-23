

<script setup>
import { ref } from "vue";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const message = ref("");
const response = ref("");
const loading = ref(false);

const sendMessage = async () => {
  if (!message.value.trim()) return;

  loading.value = true;
  response.value = "";

  try {
    const res = await axios.post("/chatbot/message", {
      message: message.value,
    });

    response.value = res.data.message;
  } catch (error) {
    response.value =
      "Error: " + (error.response?.data?.message || "Unknown error");
  }

  loading.value = false;
};

const clearMessage = () => {
  loading.value = true;
  message.value = "";
  loading.value = false;
};
</script>

<template>
  <Head title="Chatbot" />
  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded shadow">
      <h1 class="text-xl font-bold mb-4">Chat with AI</h1>

      <div class="mb-4">
        <textarea
          v-model="message"
          rows="3"
          class="w-full border rounded p-2"
          placeholder="Ask something..."
        ></textarea>
      </div>

      <button
        @click="sendMessage"
        :disabled="loading"
        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
      >
        {{ loading ? "Sending..." : "Send" }}
      </button>

      <button
        @click="clearMessage"
        :disabled="loading"
        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded mx-3"
      >
        {{ loading ? "Clearing..." : "Clear" }}
      </button>

      <div class="mt-6" v-if="response">
        <p class="text-gray-700 whitespace-pre-line">{{ response }}</p>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
