<script setup>
</script>

<template>
  <v-app-bar  scroll-behavior="hide" scroll-threshold="5">
    <v-toolbar-title>My App</v-toolbar-title>
    <v-spacer></v-spacer>
    <router-link to="/dashboard/blogs">Blogs</router-link>
    <router-link to="/dashboard/subscribers">Subscribers</router-link>
    <v-btn text @click="logout">Logout</v-btn>
  </v-app-bar>
</template>