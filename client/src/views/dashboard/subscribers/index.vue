<script setup>
import { ref, onMounted, computed, inject } from "vue";
import { mdiPencil, mdiDelete } from "@mdi/js";
import axios from "../../../plugins/axios";
import SvgIcon from "@jamescoyle/vue-icon";

const toast = inject("toast");
const subscribers = ref([]);
const headers = ref([]);
const dialog = ref(false);
const dialogDelete = ref(false);
const editedIndex = ref(-1);
const editedItem = ref({
  name: "",
  calories: 0,
  fat: 0,
  carbs: 0,
  protein: 0,
});
const defaultItem = ref({
  name: "",
  calories: 0,
  fat: 0,
  carbs: 0,
  protein: 0,
});

onMounted(async () => {
  try {
    const response = await axios.get("subscribers");
    subscribers.value = response.data;

    if (subscribers.value.length > 0) {
      const keys = Object.keys(subscribers.value[0]);
      headers.value = keys
        .filter((key) => !["created_at", "updated_at"].includes(key))
        .map((key) => {
          return {
            title: key.charAt(0).toUpperCase() + key.slice(1),
            key: key,
          };
        });

      headers.value.push({ title: "Actions", key: "actions", sortable: false });
    }
  } catch (error) {
    toast.error(error);
  }
});

const formTitle = computed(() => {
  return editedIndex.value === -1 ? "New Item" : "Edit Item";
});

const initialize = () => {
  const subscribers = [
    { name: "Frozen Yogurt", calories: 159, fat: 6.0, carbs: 24, protein: 4.0 },
    {
      name: "Ice cream sandwich",
      calories: 237,
      fat: 9.0,
      carbs: 37,
      protein: 4.3,
    },
    { name: "Eclair", calories: 262, fat: 16.0, carbs: 23, protein: 6.0 },
    { name: "Cupcake", calories: 305, fat: 3.7, carbs: 67, protein: 4.3 },
    { name: "Gingerbread", calories: 356, fat: 16.0, carbs: 49, protein: 3.9 },
    { name: "Jelly bean", calories: 375, fat: 0.0, carbs: 94, protein: 0.0 },
    { name: "Lollipop", calories: 392, fat: 0.2, carbs: 98, protein: 0 },
    { name: "Honeycomb", calories: 408, fat: 3.2, carbs: 87, protein: 6.5 },
    { name: "Donut", calories: 452, fat: 25.0, carbs: 51, protein: 4.9 },
    { name: "KitKat", calories: 518, fat: 26.0, carbs: 65, protein: 7 },
  ];
  return subscribers;
};

const editItem = (item) => {
  editedIndex.value = subscribers.value.indexOf(item);
  editedItem.value = { ...item };
  dialog.value = true;
};

const deleteSubscriber = (item) => {
  editedIndex.value = subscribers.value.indexOf(item);
  editedItem.value = { ...item };
  dialogDelete.value = true;
};

const deleteSubscriberConfirm = async () => {
  try {
    await axios.delete(`subscribers/${editedItem.value.id}`);
    subscribers.value.splice(editedIndex.value, 1);
    closeDelete();
  } catch (error) {
    console.log(error);
  }
};

const close = () => {
  dialog.value = false;
  nextTick(() => {
    editedItem.value = { ...defaultItem.value };
    editedIndex.value = -1;
  });
};

const closeDelete = () => {
  dialogDelete.value = false;
  nextTick(() => {
    editedItem.value = { ...defaultItem.value };
    editedIndex.value = -1;
  });
};

const save = () => {
  if (editedIndex.value > -1) {
    Object.assign(subscribers.value[editedIndex.value], editedItem.value);
  } else {
    subscribers.value.push(editedItem.value);
  }
  close();
};
</script>

<template>
  <v-container>
    <v-card>
      <!-- search bar  -->
      <template v-slot:text>
        <v-text-field
          v-model="search"
          label="Search"
          prepend-inner-icon="mdi-magnify"
          single-line
          variant="outlined"
          hide-details
        ></v-text-field>
      </template>

      <v-data-table :headers="headers" :items="subscribers">
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>My CRUD</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>

            <!-- edit dialog  -->
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ props }">
                <v-btn color="primary" dark class="mb-2" v-bind="props">
                  New Item
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.name"
                          label="Dessert name"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.calories"
                          label="Calories"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.fat"
                          label="Fat (g)"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.carbs"
                          label="Carbs (g)"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.protein"
                          label="Protein (g)"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue-darken-1" variant="text" @click="close">
                    Cancel
                  </v-btn>
                  <v-btn color="blue-darken-1" variant="text" @click="save">
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

            <!-- delete dialog  -->
            <v-dialog v-model="dialogDelete" max-width="500px">
              <v-card>
                <v-card-title class="text-h5"
                  >Are you sure you want to delete this item?</v-card-title
                >
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="closeDelete"
                    >Cancel</v-btn
                  >
                  <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="deleteSubscriberConfirm"
                    >OK</v-btn
                  >
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>

        <!-- table  -->
        <template v-slot:body="{ items }">
          <tr v-for="(item, index) in items" :key="index">
            <td>{{ item.name }}</td>
            <td>{{ item.username }}</td>
            <td>{{ item.password }}</td>
            <td>{{ item.status }}</td>
            <td>{{ item.role }}</td>
            <td>
              <svg-icon
                type="mdi"
                :path="mdiPencil"
                @click="editItem(item)"
                class="mr-2 pointer"
              ></svg-icon>
              <svg-icon
                type="mdi"
                :path="mdiDelete"
                @click="deleteSubscriber(item)"
                class="pointer"
              ></svg-icon>
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>



<style scoped>
.pointer {
  cursor: pointer;
}
</style>