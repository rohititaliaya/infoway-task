<template>
    <nav class="bg-gray-800 text-white px-6 py-3 flex justify-between items-center shadow">
      <div class="flex items-center space-x-6">
        <h1 class="font-bold text-lg">Stock Manager</h1>
        <router-link to="/list" class="hover:underline">Stock List</router-link>
        <router-link to="/bulk" class="hover:underline">Bulk Entry</router-link>
      </div>
  
      <button
        @click="logout"
        class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded"
      >
        Logout
      </button>
    </nav>
  </template>
  
  <script setup>
  import { useStore } from "vuex";
  import { useRouter } from "vue-router";
  
  const store = useStore();
  const router = useRouter();
  
  function logout() {
    store.commit("auth/clearAuth");
    router.push("/login");
  }
  </script>
  