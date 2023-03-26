import { defineStore } from 'pinia';
import { mande } from 'mande';

export const useConfigStore = defineStore("ConfigStore", {
    state: () => {
        return {
            hasSettings: false,
            settingsError: false,
            settingsUpdateError: false,
            transmit: false,
            use_led: false,
            callsign: "NXXX",
            gridsquare: "ZZ99",
            dbm: 10,
            frequencies: "0",
            useoffset: false,
            selfcal: true,
            ppm: 0.0,
            power_level: 7,
        };
    },
    actions: {
        async getSettings() {
            try {
                const remote_api = mande("/wspr/wspr_ini.php");
                const response = await remote_api.get();
                if (response) {
                    this.hasSettings = true;
                    this.settingsError = false;
                    this.transmit = response["Control"]["Transmit"];
                    this.use_led = response["Extended"]["Use LED"];
                    this.callsign = response["Common"]["Call Sign"];
                    this.gridsquare = response["Common"]["Grid Square"];
                    this.dbm = response["Common"]["TX Power"];
                    this.frequencies = response["Common"]["Frequency"];
                    this.useoffset = response["Extended"]["Offset"];
                    this.selfcal = response["Extended"]["Self Cal"];
                    this.ppm = response["Extended"]["PPM"];
                    this.power_level = response["Extended"]["Power Level"];
                } else {
                    await this.clearSettings();
                    this.settingsError = true;
                }
            } catch (error) {
                await this.clearSettings();
                this.extendedSettingsError = true;
            }
        },
        async clearSettings() {
            this.hasSettings = false;
            this.transmit = false;
            this.use_led = false;
            this.callsign = "NXXX";
            this.gridsquare = "ZZ99";
            this.dbm = 10;
            this.frequencies = "20m";
            this.useoffset = false;
            this.selfcal = true;
            this.ppm = 0.0;
            this.power_level = 7;
        },
        async setSettings(
            transmit,
            use_led,
            callsign,
            gridsquare,
            dbm,
            frequencies,
            useoffset,
            selfcal,
            ppm,
            power_level,
        ) {
            let Data = {};
            Data["Control"] = {};
            Data["Extended"] = {};
            Data["Common"] = {};
            Data["Control"]["Transmit"] = transmit;
            Data["Extended"]["Use LED"] = use_led;
            Data["Common"]["Call Sign"] = callsign;
            Data["Common"]["Grid Square"] = gridsquare;
            Data["Common"]["TX Power"] = parseInt(dbm);
            Data["Common"]["Frequency"] = frequencies;
            Data["Extended"]["Offset"] = useoffset;
            Data["Extended"]["Self Cal"] = selfcal;
            Data["Extended"]["PPM"] = parseFloat(ppm);
            Data["Extended"]["Power Level"] = parseInt(power_level);
            try {
                const remote_api = mande("/wspr/wspr_ini.php");
                const response = await remote_api.put(Data);
                if (response && response.message) {
                    this.settingsUpdateError = false;
                    await this.getSettings();
                } else {
                    await this.clearSettings();
                    this.settingsUpdateError = true;
                }
            } catch (error) {
                await this.clearSettings();
                this.settingsUpdateError = true;
            }
            await this.getSettings();
        }
    },
});