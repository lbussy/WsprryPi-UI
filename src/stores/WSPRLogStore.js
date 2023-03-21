import { defineStore } from 'pinia';
import { mande } from 'mande';

export const useLogMessageStore = defineStore("LogMessagesStore", {
    state: () => {
        return {
            logMessages: [],
            lastRetrieved: Date.now(),
            hasLogMessages: false,
            logMessagesError: false,
            logMessagesUpdateError: false,
        };
    },
    actions: {
        async getLogMessages() {
            try {
                const logAPI = mande("/wspr/wspr_log.php");
                const logResponse = await logAPI.get('', { query: { logFile: 'wspr.transmit.log' } });
                if (logResponse) {
                    this.hasLogMessages = true;
                    this.logMessagesError = false;
                    this.logMessages = [];

                    // Modify timestamp
                    for (let i = 0, len = logResponse.length; i < len; i++) {
                        if (logResponse[i].timestamp && logResponse[i].logentry) {
                            // This time conversion is required because the entry received is
                            // a string in GMT and browser interprets it as local
                            let timeStampUTC = logResponse[i].timestamp.split(' ');
                            timeStampUTC = timeStampUTC[0] + "T" + timeStampUTC[1] + "Z";
                            timeStampUTC = new Date(timeStampUTC);
                            // Convert to ISO string
                            logResponse[i].timestamp = timeStampUTC.toISOString().slice(0, 19).replace('T', ' ') + "Z";
                        }
                    }
                    this.logMessages = logResponse;
                } else {
                    await this.clearLog();
                    this.logMessagesError = true;
                }
            } catch (error) {
                await this.clearLog();
            }
        },
        async clearLog() {
            this.hasLogMessages = false;
            this.logMessages = [];
        }
    },
});