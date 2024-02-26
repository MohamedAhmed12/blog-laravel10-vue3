<script setup>
import {
  computed,
  inject,
  nextTick,
  onMounted,
  ref,
  watch,
  reactive,
} from "vue";
import { mdiPencil, mdiDelete, mdiClose } from "@mdi/js";
import SvgIcon from "@jamescoyle/vue-icon";
import DeleteModal from "../../../components/dashboard/DeleteModal.vue";
import SearchModal from "../../../components/dashboard/SearchModal.vue";

const axios = inject("axios");
const toast = inject("toast");

const subscribers = ref([]);
const headers = ref([]);
const errors = ref([]);
const dialog = ref(false);
const dialogDelete = ref(false);
const searchModal = ref(false);
const editedIndex = ref(-1);
const editedSubscriber = ref({
  id: "",
  name: "",
  username: "",
  password: "",
  status: "",
});
const defaultSubscriber = reactive({
  id: "",
  name: "",
  username: "",
  password: "",
  status: "",
});
const searchQuery = reactive({
  name: "",
  username: "",
  status: "",
});
const isSearchActive = ref(false);

watch(
  searchQuery,
  async (newValue, oldValue) => {
    await search();
    if (
      newValue.name == "" &&
      newValue.username == "" &&
      newValue.status == ""
    ) {
      isSearchActive.value = false;
    }
  },
  { deep: true }
);

onMounted(async () => {
  try {
    const response = await axios.get("subscribers");
    subscribers.value = response.data;

    if (subscribers.value.length > 0) {
      const keys = Object.keys(subscribers.value[0]);
      headers.value = keys
        .filter(
          (key) =>
            !["id", "created_at", "updated_at", "deleted_at"].includes(key)
        )
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

const filteredSearchFields = computed(() =>
  Object.keys(searchQuery).filter((field) => field !== "name")
);

const editSubscriber = (subscriber) => {
  editedIndex.value = subscribers.value.indexOf(subscriber);
  editedSubscriber.value = { ...subscriber };
  dialog.value = true;
};

const deleteSubscriber = (subscriber) => {
  editedIndex.value = subscribers.value.indexOf(subscriber);
  editedSubscriber.value = { ...subscriber };
  dialogDelete.value = true;
};

const handleAdvancedSearch = (data) => {
  for (const key in data) {
    if (searchQuery.hasOwnProperty(key)) {
      searchQuery[key] = data[key];
    }
  }
};

const search = async () => {
  try {
    const { data } = await axios.post("subscribers/search", searchQuery);
    subscribers.value = data;
    isSearchActive.value = true;
  } catch (error) {
    console.log(error);
  }
};

const clearSearch = async () => {
  for (const key in searchQuery) {
    searchQuery[key] = "";
  }
};

const close = () => {
  dialog.value = false;
  nextTick(() => {
    editedSubscriber.value = { ...defaultSubscriber.value };
    editedIndex.value = -1;
  });
};

const createSubscriber = async () => {
  try {
    await axios.post(`subscribers`, editedSubscriber.value);

    subscribers.value.push({ ...editedSubscriber.value, role: "subscriber" });
    editSubscriber.value = [];
    errors.value = [];
    close();
    toast.success("Created successfully");
  } catch (error) {
    if (error?.response?.data?.errors) {
      errors.value = error.response.data.errors;
    }
  }
};

const updateSubscriber = async () => {
  try {
    await axios.post(
      `subscribers/${editedSubscriber.value.id}`,
      editedSubscriber.value
    );

    Object.assign(subscribers.value[editedIndex.value], editedSubscriber.value);
    editSubscriber.value = [];
    errors.value = [];
    close();
    toast.success("Updated successfully");
  } catch (error) {
    if (error?.response?.data?.errors) {
      errors.value = error.response.data.errors;
    }
  }
};

const save = () => {
  if (editedIndex.value > -1) {
    updateSubscriber();
  } else {
    createSubscriber();
  }
};
</script>
    
    <template>
  <v-container>
    <v-card>
      <!-- search bar  -->
      <template v-slot:text>
        <div class="d-flex align-center">
          <v-text-field
            v-model="searchQuery.name"
            label="Search by name"
            prepend-inner-icon="mdi-magnify"
            single-line
            variant="outlined"
            hide-details
            @keydown="search"
          ></v-text-field>
          <v-btn
            color="primary"
            dark
            variant="text"
            class="ml-6"
            @click="searchModal = true"
          >
            Advanced search
          </v-btn>
          <SearchModal
            :searchModal="searchModal"
            :fields="filteredSearchFields"
            @close="searchModal = false"
            @changed="handleAdvancedSearch"
          />
        </div>
        <div
          v-if="isSearchActive"
          class="d-flex align-center mt-2 search-results-indicator"
        >
          <span>Showing results for your search</span>
          <svg-icon
            type="mdi"
            :path="mdiClose"
            class="mr-2 pointer"
            @click="clearSearch"
          ></svg-icon>
        </div>
      </template>

      <v-data-table :headers="headers" :items="subscribers">
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Subscribers</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>

            <!-- edit dialog  -->
            <v-dialog v-model="dialog" max-width="700px">
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
                          v-model="editedSubscriber.name"
                          label="Name"
                          :error-messages="errors['name']"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedSubscriber.username"
                          label="Username"
                          :error-messages="errors['username']"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedSubscriber.password"
                          label="Password"
                          :error-messages="errors['password']"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-select
                          v-model="editedSubscriber.status"
                          :items="['active', 'inactive']"
                          label="Status"
                          :error-messages="errors['status']"
                        ></v-select>
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
            <DeleteModal
              :dialogDelete="dialogDelete"
              :defaultObject="defaultSubscriber"
              :editedObject="editedSubscriber"
              :editedIndex="editedIndex"
              :endPoint="`subscribers/${editedSubscriber?.id}`"
              @update:dialogDelete="dialogDelete = false"
              @update:editedObject="
                (val) => {
                  editedSubscriber = value;
                }
              "
              @update:editedIndex="
                (val) => {
                  editedIndex = value;
                }
              "
              @delete-success="subscribers.splice(editedIndex, 1)"
            />
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
                @click="editSubscriber(item)"
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