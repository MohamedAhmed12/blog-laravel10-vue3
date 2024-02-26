<script setup>
import { ref } from "vue";

const props = defineProps({
  login: Function,
  formData: Object,
  errors: Object,
});

const onSubmit = () => {
  props.login();
};
</script>

<template>
  <v-container class="fill-height pa-0">
    <v-row justify="center" align="center" class="fill-height">
      <v-col cols="12">
        <div class="d-flex align-center justify-center">
          <v-sheet width="400" class="mx-auto">
            <v-form fast-fail @submit.prevent="login">
              <v-text-field
                variant="underlined"
                v-model="formData.username"
                label="username"
                type="text"
                required
                :error-messages="errors['username']"
              ></v-text-field>

              <v-text-field
                variant="underlined"
                v-model="formData.password"
                label="Password"
                type="password"
                required
                :error-messages="errors['password']"
              ></v-text-field>
              <a href="#" class="text-body-2 font-weight-regular">
                Forgot Password?
              </a>

              <v-btn
                type="submit"
                variant="outlined"
                color="primary"
                block
                class="mt-2"
                >Sign in</v-btn
              >
            </v-form>
            <div class="mt-2">
              <p class="text-body-2">
                Don't have an account? <a href="#">Sign Up</a>
              </p>
            </div>
          </v-sheet>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped>
</style>
