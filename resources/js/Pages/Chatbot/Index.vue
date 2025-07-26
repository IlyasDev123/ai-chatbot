<script setup>
import { ref, nextTick } from "vue";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const message = ref("");
const chatHistory = ref([]);
const loading = ref(false);
const chatContainer = ref(null);

const sendMessage = async () => {
  if (!message.value.trim()) return;

  const userMessage = { role: "user", text: message.value };
  chatHistory.value.push(userMessage);
  loading.value = true;
  message.value = "";

  await nextTick();
  scrollToBottom();

  try {
    const res = await axios.post("/chatbot/message", {
      message: userMessage.text,
    });

    const botMessage = {
      role: "assistant",
      text: res.data.message || "No response from AI.",
    };
    chatHistory.value.push(botMessage);
  } catch (error) {
    chatHistory.value.push({
      role: "assistant",
      text: "Error: " + (error.response?.data?.message || "Unknown error"),
    });
  }

  loading.value = false;
  await nextTick();
  scrollToBottom();
};

const clearChat = () => {
  chatHistory.value = [];
  message.value = "";
};

const scrollToBottom = () => {
  if (chatContainer.value) {
    chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
  }
};
</script>

<template>

  <Head title="Chatbot" />
  <AuthenticatedLayout>
    <div class="flex justify-center items-start h-full p-4">
      <div class="w-full max-w-7xl bg-white rounded-2xl shadow-2xl flex flex-col h-[calc(90vh-100px)]">
        <!-- Chat Header -->
        <div class="p-4 border-b bg-gray-50 rounded-t-2xl flex items-center">
          <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2V10a2 2 0 012-2h8z" />
            </svg>
          </div>
          <div>
            <h1 class="text-xl font-bold text-gray-800">Travel Assistant</h1>
            <p class="text-sm text-gray-500">Online</p>
          </div>
        </div>

        <!-- Chat History -->
        <div ref="chatContainer" class="flex-1 p-6 overflow-y-auto bg-gray-100">
          <div v-for="(msg, index) in chatHistory" :key="index" class="mb-4 flex items-end" :class="{
            'justify-end': msg.role === 'user',
            'justify-start': msg.role === 'assistant',
          }">
            <div v-if="msg.role === 'assistant'" class="w-8 h-8 rounded-full bg-gray-300 mr-3"></div>
            <div class="prose max-w-7xl px-4 py-3 rounded-2xl shadow-md text-base" :class="{
              'bg-blue-500 text-white rounded-br-none': msg.role === 'user',
              'bg-white text-gray-800 rounded-bl-none': msg.role === 'assistant',
            }" v-html="msg.text"></div>
          </div>
          <div v-if="loading" class="flex items-end justify-start">
            <div class="w-8 h-8 rounded-full bg-gray-300 mr-3"></div>
            <div class="px-4 py-3 rounded-2xl shadow-md bg-white text-gray-800 rounded-bl-none">
              ...
            </div>
          </div>
        </div>

        <!-- Message Input -->
        <div class="p-4 bg-white border-t rounded-b-2xl">
          <div class="flex items-center gap-2">
            <textarea v-model="message" @keydown.enter.prevent="sendMessage" rows="1"
              class="flex-1 border-gray-300 rounded-full py-3 px-5 text-base focus:ring-blue-500 focus:border-blue-500 resize-none"
              placeholder="Ask a travel question..."></textarea>
            <button @click="sendMessage" :disabled="loading"
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3 rounded-full disabled:bg-blue-300">
              <span v-if="!loading">Send</span>
              <span v-else>...</span>
            </button>
            <button @click="clearChat"
              class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-3 rounded-full">
              Clear
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>