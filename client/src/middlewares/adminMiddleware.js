import { useStore } from "vuex";

export function adminMiddleware(to, from, next) {
  const store = useStore();
  const authUser = store.getters["auth/getUser"];

  if (!authUser || authUser.role != "admin") {
    next("/dashboard/blogs");
  } else {
    next();
  }
}
