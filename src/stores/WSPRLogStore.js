import { defineStore } from 'pinia';
import { mande } from 'mande';

export const useLogMessageStore = defineStore("LogMessagesStore", {
    state: () => {
        return {
            logFile: 'wspr.transmit.log',
            logMessages: [],
            logLock: false,
            lastRetrieved: Date.now(),
            logMessagesError: false,
        };
    },
    actions: {
        async getLogMessages() {
            try {
                if (!this.logLock) {
                    // Run only if we are not already running
                    this.logLock = true; // Turn on lock
                    console.log("DEBUG: Querying for data.");
                    const logAPI = mande("/wspr/wspr_log.php");
                    const logResponse = await logAPI.get('', {query: {logFile: this.logFile}});
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
                        if (this.logMessages.length > 1) {
                            console.log("DEBUG: Zeroing log and adding empty log message.");
                            this.logMessages = [];
                            this.lastRetrieved = Date.now();
                        }
                        if (this.logMessages.length == 0) {
                            console.log("DEBUG: Adding empty log message.");
                            this.lastRetrieved = Date.now();
                            this.logMessages.push([this.lastRetrieved, "Empty log."]);
                        } else if (this.logMessages.length == 1 && this.logMessages[0][1] != "Empty log.") {
                            console.log("DEBUG: One line but not empty log; adding empty log message.");
                            this.logMessages = [];
                            this.lastRetrieved = Date.now();
                            this.logMessages.push([this.lastRetrieved, "Empty log."]);
                        }
                    }
                    this.logLock = false; // Turn off lock
                } else {
                    console.log("DEBUG: Stubbornly refusing to query for data.");
                }
            } catch (error) {
                this.logLock = false; // Turn off lock
                this.logMessagesError = true;
            }
        },
        async clearLog() {
            this.lastRetrieved = Date.now();
            this.logMessages = [];
            this.logLock = false; // Turn off lock
        },
    },
});