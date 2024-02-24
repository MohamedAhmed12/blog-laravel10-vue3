<script setup>
import { ref } from "vue";
import axios from "../../plugins/axios";
import LoginForm from "../../components/LoginForm.vue";

import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();
const formData = ref({
  username: "",
  password: "",
});

const login = async () => {
  try {
    const response = await axios.post("login", formData.value);
    store.dispatch("auth/setAuthUser", response?.data);
    router.push({ path: "/dashboard/blogs" });
  } catch (error) {
    console.error("Login failed:", error?.response?.data || error);
  }
};
</script>

<template>
  <v-container fluid class="login-main-container fill-height flex-wrap pa-0">
    <v-row class="fill-height">
      <v-col cols="12" md="6" offset-md="6" class="bg-white">
        <LoginForm :login="login" :formData="formData" />
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped>
.login-main-container {
  background-image: url("../../assets/login-bg.jpg");
  background-size: cover;
  background-position: center;
}
</style>
