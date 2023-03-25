import { createWebHistory, createRouter } from "vue-router";

import WsprryPiSettings from "@/components/WsprryPiSettings.vue";
import WsprryPiLogs from "@/components/WsprryPiLogs.vue";

const routes = [
    {
        path: "/",
        name: "Config",
        component: WsprryPiSettings,
    },
    {
        path: "/config",
        name: "config",
        component: WsprryPiSettings,
    },
    {
        path: "/wstd",
        name: "wstd",
        component: WsprryPiLogs,
        props: { logFile: 'wspr.transmit.log' }
    },
    {
        path: "/werr",
        name: "werr",
        component: WsprryPiLogs,
        props: { logFile: 'wspr.error.log' }
    },
    {
        path: "/sstd",
        name: "sstd",
        component: WsprryPiLogs,
        props: { logFile: 'shutdown-button.transmit.log' }
    },
    {
        path: "/serr",
        name: "serr",
        component: WsprryPiLogs,
        props: { logFile: 'shutdown-button.error.log' }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
