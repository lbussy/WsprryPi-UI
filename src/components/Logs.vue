<template>
  <div class="container">
    <div>
      <h4>Log:&nbsp;&nbsp;{{ LogMessageStore.logFile }}</h4>

      <ul id="log">
        <li v-for="logMessage in LogMessageStore.logMessages" style="list-style-type: none;">
          {{ logMessage[0] }}:  {{ logMessage[1] }}
        </li>
      </ul>

    </div>
  </div>
</template>

<script>
let interval = 5000; // Log refresh interval

import { useLogMessageStore } from "@/stores/LogStore";

export default {
  name: "LogMessages",
  props: {
    logFile: {
      type: String,
      required: true,
      default: 'wspr.transmit.log',
    },
  },
  data() {
    return{
      intervalObject:null,
    };
  },
  setup() {
    return {
      LogMessageStore: useLogMessageStore(),
    }
  },
  watch: {
    logFile: function(newLogFile, oldLogFile) {
      console.log("DEBUG: Triggered: watch: logFile: function(" + newLogFile + ", " + oldLogFile + ")");
      clearInterval(this.intervalObject);
      this.LogMessageStore.logFile = newLogFile;
      this.LogMessageStore.getLogMessages();
      this.intervalObject =  setInterval(() => {
        this.LogMessageStore.getLogMessages();
      }, interval);
    }
  },
  mounted() {
    // Show loader
    let loader = this.$loading.show({});
    // Switch to proper log
    this.LogMessageStore.logFile = this.logFile;
    // Get initial data
    this.LogMessageStore.getLogMessages().then(() => {
      loader.hide();
    });
    // Set up periodic refreshes
    this.intervalObject =  setInterval(() => {
      this.LogMessageStore.getLogMessages();
    }, interval);
  },
  beforeUnmount() {
    console.log("DEBUG: Triggered: beforeDestroy: function()");
    clearInterval(this.intervalObject);
  }
}

// function changeLog() {
//   console.log("DEBUG: changeLog() fired.");
//   let loader = this.$loading.show({});
//   this.intervalObject = null;
//   this.intervalObject =  setInterval(() => {
//     this.LogMessageStore.logFile = this.logFile;
//     this.LogMessageStore.getLogMessages();
//   }, interval);
//   loader.hide();
// }

</script>

<style scoped>
</style>
