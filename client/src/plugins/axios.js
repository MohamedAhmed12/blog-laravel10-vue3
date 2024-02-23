import axios from "axios";
import store from "../store";

const axiosInstance = axios.create({
  baseURL: `${import.meta.env.VITE_APP_SERVER_URL}/api/`,
  timeout: 5000,
  headers: {
    "Content-Type": "application/json",
  },
});

axiosInstance.interceptors.request.use(
  function(config) {
    const token = store.getters["auth/getToken"];

    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`;
    }

    return config;
  },
  function(error) {
    return Promise.reject(error);
  }
);

export default axiosInstance;
