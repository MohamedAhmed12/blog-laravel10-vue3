import { useStore } from "vuex";

export function authMiddleware(to, from, next) {
  const store = useStore();
  const isAuthenticated = store.getters["auth/isLoggedIn"];

  if (!isAuthenticated) {
    next("/auth/login"); // Redirect to login page if not authenticated
  } else {
    next(); // Proceed to the requested route if authenticated
  }
}
