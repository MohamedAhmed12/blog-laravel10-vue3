<script setup>
import { computed } from "vue";
import { useStore } from "vuex";
import Header from "../components/dashboard/Header.vue";

const store = useStore();

const user = computed(() => store.getters["auth/getUser"]);
</script>

<template>
  <v-app class="dashboard__layout">
    <Header />
    <router-view></router-view>
  </v-app>
</template>

<style>
.dashboard__layout {
  padding-top: 100px;
  background-color: aliceblue;
}
</style>
