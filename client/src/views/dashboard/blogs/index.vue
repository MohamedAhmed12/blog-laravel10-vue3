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

const axios = inject("axios");
const toast = inject("toast");

const blogs = ref([]);
const headers = ref([]);
const dialogDelete = ref(false);
const editedIndex = ref(-1);
const editedBlog = ref({
  id: "",
  title: "",
  image: "",
  content: "",
  published_at: "",
  status: "",
});
const defaultBlog = reactive({
  id: "",
  title: "",
  image: "",
  content: "",
  published_at: "",
  status: "",
});

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

const deleteBlog = (blog) => {
  editedIndex.value = blogs.value.indexOf(blog);
  editedBlog.value = { ...blog };
  dialogDelete.value = true;
};
</script>
    
<template>
  <v-container>
    <v-card>
      <v-data-table :headers="headers" :items="blogs">
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Blogs</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>

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
                  editedBlog = value;
                }
              "
              @update:editedIndex="
                (val) => {
                  editedIndex = value;
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