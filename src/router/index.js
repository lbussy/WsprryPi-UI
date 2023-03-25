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
        name: "Config",
        component: WsprryPiSettings,
    },
    {
        path: "/wlog",
        name: "WStd",
        component: WsprryPiLogs,
        props: { logFile: 'wspr.transmit.log' }
    },
    {
        path: "/werr",
        name: "WErr",
        component: WsprryPiLogs,
        props: { logFile: 'wspr.error.log' }
    },
    {
        path: "/slog",
        name: "SStd",
        component: WsprryPiLogs,
        props: { logFile: 'shutdown-button.transmit.log' }
    },
    {
        path: "/serr",
        name: "SErr",
        component: WsprryPiLogs,
        props: { logFile: 'shutdown-button.error.log' }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;