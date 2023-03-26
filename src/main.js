import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { LoadingPlugin } from "vue-loading-overlay";
import './style.css'
import 'vue-loading-overlay/dist/css/index.css';
import App from './App.vue'

import router from './router'

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

const pinia = createPinia();

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
/* Add icons to the library */
library.add(faBook);
library.add(faGithub);
library.add(faTowerBroadcast);

const app = createApp(App);
app.use(pinia);
app.use(LoadingPlugin);
app.component('font-awesome-icon', FontAwesomeIcon);
app.use(router);
app.mount('#app');
