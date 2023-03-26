import { createApp } from 'vue'
const app = createApp(App);
import App from './App.vue';

// Pinia
import { createPinia } from 'pinia'
const pinia = createPinia();
app.use(pinia);

// Loading Overlay
import { LoadingPlugin } from "vue-loading-overlay";
import 'vue-loading-overlay/dist/css/index.css';
app.use(LoadingPlugin);

// Vue Rouer
import router from './router';
app.use(router);

// Font Awesome:
//
// Import the fontawesome core
import { library } from '@fortawesome/fontawesome-svg-core'
// Import font awesome icon component
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// Import specific icons
import { faTowerBroadcast } from "@fortawesome/free-solid-svg-icons";
import { faBook } from "@fortawesome/free-solid-svg-icons";
import { faGithub } from "@fortawesome/free-brands-svg-icons";
// Add icons to the library
library.add(faBook);
library.add(faGithub);
library.add(faTowerBroadcast);
app.component('font-awesome-icon', FontAwesomeIcon);

// Bootstrap
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";

// Local Style
import './style.css'

app.mount('#app');
