import { defineStore } from 'pinia';
import { mande } from 'mande';

export const useLogMessageStore = defineStore("LogMessagesStore", {
    state: () => {
        return {
            logMessages: [],
            lastRetrieved: Date.now(),
            logMessagesError: false,
        };
    },
    actions: {
        async getLogMessages() {
            try {
                const logAPI = mande("/wspr/wspr_log.php");
                const logResponse = await logAPI.get('', { query: { logFile: 'wspr.transmit.log' } });
                if (logResponse) {
                    this.lastRetrieved = Date.now();
                    if (logResponse.length > this.logMessages.length) {
                        let startpoint = 0;
                        if (logResponse.length < this.logMessages.length) {
                            // If the received log is shorter than the buffer, reset
                            startpoint = 0;
                        } else {
                            // If the received log is longer than the buffer, start at the end
                            startpoint = this.logMessages.length;
                        }
                        for (let i = startpoint; i < logResponse.length; i++) {
                            if (logResponse[i].timestamp && logResponse[i].logentry) {
                                // This time conversion is required because the entry received is
                                // a string in GMT and browser interprets it as local
                                let split = logResponse[i].timestamp.split(' ');
                                let newDTS = split[0] + "T" + split[1] + "Z";
                                let timeStampUTC = new Date(newDTS);
                                // Convert to ISO string
                                let thisTimeStamp = timeStampUTC.toISOString().slice(0, 19).replace('T', ' ') + "Z";
                                this.logMessages.push([thisTimeStamp, logResponse[i].logentry]);
                            }
                        }
                    } else {
                        // Log length has not changed
                    }
                    this.logMessagesError = false;
                } else {
                    // We got a zero length message
                    // TODO: Maybe make a timer here to set an error after a while
                }
            } catch (error) {
                this.logMessagesError = true;
            }
        },
        async clearLog() {
            lastRetrieved: Date.now();
            this.logMessages = [];
        }
    },
});