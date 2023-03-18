import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { LoadingPlugin } from "vue-loading-overlay";
import './style.css'
import 'vue-loading-overlay/dist/css/index.css';
import './custom.css'
import './bootstrap.css'
import ConfigApp from './App.vue'

const pinia = createPinia();
const configapp = createApp(ConfigApp);
configapp.use(pinia);
configapp.use(LoadingPlugin);
configapp.mount('#configapp');
