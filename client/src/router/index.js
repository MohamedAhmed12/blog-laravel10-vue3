import { authMiddleware } from "@/middlewares/authMiddleware";
import { createRouter, createWebHistory } from "vue-router";
import DashboardLayout from "../layouts/DashboardLayout.vue";
import Login from "../views/auth/Login.vue";
import BlogList from "../views/dashboard/blogs/BlogList.vue";
import SubscriberIndex from "../views/dashboard/subscribers/index.vue";

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
      {
        path: "subscribers",
        component: SubscriberIndex,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
