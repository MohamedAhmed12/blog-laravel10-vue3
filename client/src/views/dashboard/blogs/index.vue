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
import { mdiPencil, mdiDelete, mdiClose, mdiCamera } from "@mdi/js";
import SvgIcon from "@jamescoyle/vue-icon";
import DeleteModal from "../../../components/dashboard/DeleteModal.vue";
import SearchModal from "../../../components/dashboard/SearchModal.vue";

const axios = inject("axios");
const toast = inject("toast");

const blogs = ref([]);
const headers = ref([]);
const errors = ref([]);
const dialog = ref(false);
const dialogDelete = ref(false);
const searchModal = ref(false);
const editedIndex = ref(-1);
const editedBlog = ref({
  id: "",
  title: "",
  image: null,
  content: "",
  published_at: null,
  status: "",
});
const defaultBlog = reactive({
  id: "",
  title: "",
  image: null,
  content: "",
  published_at: null,
  status: "",
});
const searchQuery = reactive({
  title: "",
  content: "",
  published_at: null,
  status: "",
});
const isSearchActive = ref(false);

watch(
  searchQuery,
  async (newValue, oldValue) => {
    await search();
    if (
      newValue.title == "" &&
      newValue.content == "" &&
      newValue.published_at == "" &&
      newValue.status == ""
    ) {
      isSearchActive.value = false;
    }
  },
  { deep: true }
);

onMounted(async () => {
  try {
    const response = await axios.get("blogs");
    blogs.value = response.data;

    if (blogs.value.length > 0) {
      const keys = Object.keys(blogs.value[0]);
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
  Object.keys(searchQuery).filter((field) => field !== "title")
);

const handleAdvancedSearch = (data) => {
  for (const key in data) {
    if (searchQuery.hasOwnProperty(key)) {
      let val = data[key];
      if (key == "published_at") {
        val = new Date(val).toISOString().split("T")[0];
      }
      searchQuery[key] = val;
    }
  }
};

const search = async () => {
  try {
    const { data } = await axios.post("blogs/search", searchQuery);
    blogs.value = data;
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
    editedBlog.value = { ...defaultBlog.value };
    editedIndex.value = -1;
  });
};

const convertToFormData = () => {
  const formData = new FormData();
  for (const key in editedBlog.value) {
    if (editedBlog.value[key] !== null && editedBlog.value[key] !== "") {
      let val = editedBlog.value[key];

      if (key === "image" && val) {
        val = val instanceof File ? val : val[0];
      } else if (key === "published_at" && val) {
        val = new Date(val).toISOString().split("T")[0];
      }

      formData.append(key, val);
    }
  }
  return formData;
};

const createBlog = async () => {
  try {
    const data = convertToFormData();
    const res = await axios.post(`blogs`, data, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    blogs.value.push({
      ...editedBlog.value,
      image: res.data.image,
      published_at: res.data.published_at,
    });
    editedBlog.value = {
      ...defaultBlog,
    };
    errors.value = [];
    close();
    toast.success("Created successfully");
  } catch (error) {
    if (error?.response?.data?.errors) {
      errors.value = error.response.data.errors;
    }
  }
};

const updateBlog = async () => {
  try {
    const data = convertToFormData();
    const res = await axios.post(`blogs/${editedBlog.value.id}`, data, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    Object.assign(blogs.value[editedIndex.value], {
      ...editedBlog.value,
      image: res.data.image,
      published_at: res.data.published_at,
    });
    editedBlog.value = {
      ...defaultBlog,
    };
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
    updateBlog();
  } else {
    createBlog();
  }
};

const editBlog = (blog) => {
  editedIndex.value = blogs.value.indexOf(blog);
  editedBlog.value = { ...blog, image: null, published_at: null };
  dialog.value = true;
};

const deleteBlog = (blog) => {
  editedIndex.value = blogs.value.indexOf(blog);
  editedBlog.value = { ...blog };
  dialogDelete.value = true;
};
</script>
    
<template>
  <v-container>
    <v-card>
      <!-- search bar  -->
      <template v-slot:text>
        <div class="d-flex align-center">
          <v-text-field
            v-model="searchQuery.title"
            label="Search by title"
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
            :statuses="['draft', 'published', 'archived']"
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

      <v-data-table :headers="headers" :items="blogs">
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Blogs</v-toolbar-title>
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
                          v-model="editedBlog.title"
                          label="Title"
                          :error-messages="errors['title']"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedBlog.content"
                          label="Content"
                          :error-messages="errors['content']"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-date-picker
                          v-model="editedBlog.published_at"
                          header="Published at"
                          type="date"
                          :error-messages="errors['published_at']"
                        ></v-date-picker>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-select
                          v-model="editedBlog.status"
                          :items="['draft', 'published', 'archived']"
                          label="Status"
                          :error-messages="errors['status']"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-file-input
                          label="Upload Image"
                          :prepend-icon="mdiCamera"
                          accept="image/*"
                          v-model="editedBlog.image"
                          :error-messages="errors['image']"
                        ></v-file-input>
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
              :defaultObject="defaultBlog"
              :editedObject="editedBlog"
              :editedIndex="editedIndex"
              :endPoint="`blogs/${editedBlog?.id}`"
              @update:dialogDelete="dialogDelete = false"
              @update:editedObject="
                (val) => {
                  editedBlog = val;
                }
              "
              @update:editedIndex="
                (val) => {
                  editedIndex = val;
                }
              "
              @delete-success="blogs.splice(editedIndex, 1)"
            />
          </v-toolbar>
        </template>

        <!-- table  -->
        <template v-slot:body="{ items }">
          <tr v-for="(item, index) in items" :key="index">
            <td>{{ item.title }}</td>
            <td>{{ item.image }}</td>
            <td>{{ item.content }}</td>
            <td>{{ item.status }}</td>
            <td>{{ item.published_at }}</td>
            <td class="actions-cell">
              <svg-icon
                type="mdi"
                :path="mdiPencil"
                @click="editBlog(item)"
                class="mr-2 pointer"
              ></svg-icon>
              <svg-icon
                type="mdi"
                :path="mdiDelete"
                @click="deleteBlog(item)"
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
.actions-cell {
  min-width: 100px;
}
</style>