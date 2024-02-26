
<script setup>
import { ref } from "vue";

const emits = defineEmits(["search", "close"]);

const props = defineProps({
  searchModal: Boolean,
  fields: Array,
});

const formData = ref({});

const search = () => {
  emits("changed", formData.value);
  close();
};
const close = () => {
  emits("close");
};
console.log(props.fields);
</script>

<template>
  <v-dialog v-model="props.searchModal" max-width="500px">
    <v-card>
      <v-card-title>Search</v-card-title>
      <v-card-text>
        <v-form @submit.prevent="search">
          <v-row>
            <v-col
              v-for="(field, index) in props.fields"
              :key="index"
              cols="12"
            >
              <v-text-field
                v-if="field != 'status'"
                v-model="formData[field]"
                :label="field"
              ></v-text-field>
              <v-select
                v-else
                v-model="formData[field]"
                :items="['active', 'inactive']"
                :label="field"
              ></v-select>
            </v-col>
          </v-row>
          <v-card-actions>
            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" @click="search">Search</v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

