
<script setup>
import { ref, nextTick } from "vue";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const message = ref("");
const chatHistory = ref([]); // array of { role: 'user' | 'assistant', text: '...' }
const loading = ref(false);
const chatContainer = ref(null);

const sendMessage = async () => {
  if (!message.value.trim()) return;

  const userMessage = { role: "user", text: message.value };
  chatHistory.value.push(userMessage);
  loading.value = true;

  try {
    const res = await axios.post("/chatbot/message", {
      message: message.value,
    });

    const botMessage = {
      role: "assistant",
      text: res.data.message || "No response from AI.",
    };

    chatHistory.value.push(botMessage);
    message.value = "";
  } catch (error) {
    chatHistory.value.push({
      role: "assistant",
      text: "Error: " + (error.response?.data?.message || "Unknown error"),
    });
  }

  loading.value = false;

  // Scroll to bottom
  await nextTick();
  if (chatContainer.value) {
    chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
  }
};

const clearChat = () => {
  chatHistory.value = [];
  message.value = "";
};
</script>

<template>
    <Head title="Chatbot" />
    <AuthenticatedLayout>
      <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h1 class="text-xl font-bold mb-4">Chat with Travel Assistant</h1>

        <div
          ref="chatContainer"
          class="h-96 overflow-y-auto border rounded p-4 bg-gray-50"
        >
          <div
            v-for="(msg, index) in chatHistory"
            :key="index"
            class="mb-3 flex"
            :class="{
              'justify-end': msg.role === 'user',
              'justify-start': msg.role === 'assistant',
            }"
          >
            <div
              class="px-4 py-2 rounded shadow text-sm w-100"
              :class="{
                'bg-blue-500 text-white rounded-br-none': msg.role === 'user',
                'bg-gray-200 text-gray-800 rounded-bl-none': msg.role === 'assistant',
              }"
            >
              {{ msg.text }}
            </div>
          </div>
        </div>

        <div class="mt-4 flex gap-2">
          <textarea
            v-model="message"
            rows="2"
            class="w-full border rounded p-2 text-sm resize-none"
            placeholder="Ask a travel question..."
          ></textarea>
          <button
            @click="sendMessage"
            :disabled="loading"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded"
          >
            {{ loading ? "..." : "Send" }}
          </button>
          <button
            @click="clearChat"
            class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded"
          >
            Clear
          </button>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

