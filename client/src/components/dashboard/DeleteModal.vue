<script setup>
import { defineProps, inject } from "vue";

const axios = inject("axios");
const toast = inject("toast");

const props = defineProps({
  dialogDelete: Boolean,
  defaultObject: Object,
  editedObject: Object,
  editedIndex: Number,
  endPoint: String,
});

const emits = defineEmits([
  "update:dialogDelete",
  "update:editedObject",
  "update:editedIndex",
  "delete-success",
]);

const emitCloseDelete = () => {
  emits("update:dialogDelete");
  emits("update:editedObject", { ...props.defaultObject.value });
  emits("update:editedIndex", -1);
};
const deleteConfirm = async () => {
  try {
    await axios.delete(props.endPoint);
    emits("delete-success", "Deleted successfully");
    emitCloseDelete();
    toast.success("Deleted successfully");
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
  <v-dialog :modelValue="props.dialogDelete" max-width="700px">
    <v-card>
      <v-card-title class="text-h5">
        Are you sure you want to delete this item?
      </v-card-title>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue-darken-1" variant="text" @click="emitCloseDelete">
          Cancel
        </v-btn>
        <v-btn color="blue-darken-1" variant="text" @click="deleteConfirm">
          OK
        </v-btn>
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
