<template>
  <div>
    <Navbar v-if="isLoggedIn" />
    <router-view />
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";
import Navbar from "./components/Navbar.vue";

const store = useStore();
const isLoggedIn = computed(() => !!store.state.auth.token);
</script>
