import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/auth/Login.vue";
import BlogList from "../views/dashboard/blogs/BlogList.vue";
import DashboardLayout from "../layouts/DashboardLayout.vue";
import { authMiddleware } from "@/middlewares/authMiddleware";

const routes = [
  {
    path: "/auth/login",
    component: Login,
  },
  {
    path: "/dashboard",
    component: DashboardLayout,
    beforeEnter: authMiddleware,
    children: [
      {
        path: "blogs",
        component: BlogList,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
