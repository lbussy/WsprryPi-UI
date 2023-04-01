import { createWebHistory, createRouter } from "vue-router";

import Config from "@/components/Config.vue";
import Logs from "@/components/Logs.vue";
import WsprTransmitLog from "@/components/WsprTransmitLog.vue";

const routes = [
    {
        path: "/",
        name: "Config",
        component: Config,
    },
    {
        path: "/wstd",
        name: "WStd",
        component: WsprTransmitLog,
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
    history: createWebHistory("/wspr"),
    routes,
});

export default router;
