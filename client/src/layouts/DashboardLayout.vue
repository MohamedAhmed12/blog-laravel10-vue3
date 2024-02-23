<script setup>
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

const user = computed(() => store.getters["auth/getUser"]);
console.log(user);
</script>


<template>
  <div>
    <nav>
      <router-link to="/dashboard">Home</router-link>
      <router-link to="/dashboard/settings">Settings</router-link>
      <router-link to="/dashboard/profile">Profile</router-link>
    </nav>
    {{ user }}
    <router-view></router-view>
  </div>
</template>

<style>
/* Component styles */
</style>
