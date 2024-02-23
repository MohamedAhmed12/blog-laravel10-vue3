import { ref } from "vue";

const state = {
  user: ref(JSON.parse(localStorage.getItem("user")) || null),
  token: ref(localStorage.getItem("token") || null),
};

const mutations = {
  setUser(state, payload) {
    state.user = payload;
    localStorage.setItem("user", JSON.stringify(payload));
  },
  setToken(state, payload) {
    state.token = payload;
    localStorage.setItem("token", payload);
  },
};

const actions = {
  setAuthUser({ commit }, { user, token }) {
    commit("setUser", user);
    commit("setToken", token);
  },
};

const getters = {
  isLoggedIn() {
    return state.user !== null && state.user.value !== null;
  },
  getToken() {
    return state.token.value;
  },
  getUser() {
    return state.user.value;
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
