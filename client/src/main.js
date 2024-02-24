import "vuetify/styles";
import "./assets/main.css";

import { createApp } from "vue";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import App from "./App.vue";
import toastify from "./plugins/toastify";
import router from "./router";
import store from "./store";

const vuetify = createVuetify({
  components,
  directives,
});

const app = createApp(App);
app.use(router);
app.use(store);
app.use(vuetify);
app.use(toastify);
app.mount("#app");
