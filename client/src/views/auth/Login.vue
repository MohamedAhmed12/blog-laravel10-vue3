<script setup>
import { ref, inject, onMounted } from "vue";
import LoginForm from "../../components/LoginForm.vue";

import { useStore } from "vuex";
import { useRouter } from "vue-router";
import FingerprintJS from "@fingerprintjs/fingerprintjs";

const axios = inject("axios");
const toast = inject("toast");
const store = useStore();
const router = useRouter();

const formData = ref({
  username: "",
  password: "",
  fingerprint: "",
});
const errors = ref([]);

onMounted(async () => {
  formData.value.fingerprint = await getFingerprint();
});

const login = async () => {
  errors.value = [];

  try {
    const response = await axios.post("login", formData.value);
    if (response?.data?.user) {
      store.dispatch("auth/setAuthUser", response?.data);
      router.push({ path: "/dashboard/blogs" });
    }
  } catch (error) {
    if (error?.response?.data?.errors) {
      return (errors.value = error.response.data.errors);
    }

    if (error?.response?.status == 401) {
        console.log(error?.response?.data);
      toast.error(error?.response?.data);
    } else {
      toast.error("Something went wrong!");
    }
  }
};
async function getFingerprint() {
  const fp = await FingerprintJS.load();
  const result = await fp.get();
  return result.visitorId;
}
</script>

<template>
  <v-container fluid class="login-main-container fill-height flex-wrap pa-0">
    <v-row class="fill-height">
      <v-col cols="12" md="6" offset-md="6" class="bg-white">
        <LoginForm :login="login" :formData="formData" :errors="errors" />
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
