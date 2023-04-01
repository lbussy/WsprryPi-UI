import { defineStore } from 'pinia';
import { mande } from 'mande';

let iniFile = "wspr_log.php";

export const useLogMessageStore = defineStore("LogMessagesStore", {
    state: () => {
        return {
            logFile: '',
            lastLogFile: '',
            logMessages: [],
            logLock: false,
            lastRetrieved: Date.now(),
            logMessagesError: false,
        };
    },
    actions: {
        async getLogMessages() {
            try {
                console.log("DEBUG: Current path = " + window.location.href + ", opening " + this.logFile);
                if (!this.logLock) {
                    // Run only if we are not already running
                    this.logLock = true; // Turn on lock
                    // Clear the log if we switched log files
                    if (this.lastLogFile != this.logFile) {
                        this.logMessages = [];
                        this.lastLogFile = this.logFile
                    }
                    const logAPI = mande(iniFile);
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
                            // Handle incomplete or empty results

                            if (
                                this.logMessages.length == 0 ||
                                (this.logMessages.length == 1 && this.logMessages[0][1] != "Empty log.")
                            ) {
                                // Adding empty log message
                                this.lastRetrieved = Date.now();
                                let dts = new Date();
                                let text = dts.toISOString().slice(0, 19).replace('T', ' ') + "Z";
                                this.logMessages.push([text, "Empty log."]);
                            }
                        } else {
                            // Log length has not changed
                        }
                        this.logMessagesError = false;
                    } else {
                        this.logMessagesError = true;
                        let dts = new Date();
                        let text = dts.toISOString().slice(0, 19).replace('T', ' ') + "Z";
                        this.logMessages.push([text, "Failed to get a response."]);
                    }
                    this.logLock = false; // Turn off lock
                } else {
                    // Skipping query due to lock
                }
            } catch (error) {
                this.logLock = false; // Turn off lock
                this.logMessagesError = true;
                let dts = new Date();
                let text = dts.toISOString().slice(0, 19).replace('T', ' ') + "Z";
                this.logMessages.push([text, "Caught an error getting log."]);
            }
        },
        async clearLog() {
            this.lastRetrieved = Date.now();
            this.logMessages = [];
            this.logLock = false; // Turn off lock
        },
    },
});
