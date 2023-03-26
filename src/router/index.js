import { createWebHistory, createRouter } from "vue-router";

import Config from "@/components/Config.vue";
import Logs from "@/components/Logs.vue";

const routes = [
    {
        path: "/",
        name: "",
        component: Config,
    },
    {
        path: "/config",
        name: "Config",
        component: Config,
    },
    {
        path: "/wstd",
        name: "WStd",
        component: Logs,
        props: { logFile: 'wspr.transmit.log' }
    },
    {
        path: "/werr",
        name: "WErr",
        component: Logs,
        props: { logFile: 'wspr.error.log' }
    },
    {
        path: "/sstd",
        name: "SStd",
        component: Logs,
        props: { logFile: 'shutdown-button.transmit.log' }
    },
    {
        path: "/serr",
        name: "SErr",
        component: Logs,
        props: { logFile: 'shutdown-button.error.log' }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
