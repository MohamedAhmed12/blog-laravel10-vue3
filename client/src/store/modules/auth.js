import { ref } from "vue";

const state = {
  user: ref(null),
  token: ref(null),
};

const mutations = {
  setUser(state, payload) {
    state.user = payload;
  },
  setToken(state, payload) {
    state.token = payload;
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
    return state.user.value !== null;
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
