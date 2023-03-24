import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { LoadingPlugin } from "vue-loading-overlay";
import './style.css'
import 'vue-loading-overlay/dist/css/index.css';
import ConfigApp from './App.vue'
// Bootstrap
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
// Local stuff
import './custom.css'

const pinia = createPinia();

const configapp = createApp(ConfigApp);
configapp.use(FontAwesomeIcon);
configapp.use(pinia);
configapp.use(LoadingPlugin);
configapp.mount('#configapp');

import { library } from "@fortawesome/fontawesome-svg-core";
import { faBook } from "@fortawesome/free-solid-svg-icons";
import { faGithub } from "@fortawesome/free-brands-svg-icons";
import { faTowerBroadcast } from "@fortawesome/free-solid-svg-icons";

library.add(faBook);
library.add(faGithub);
library.add(faTowerBroadcast);
