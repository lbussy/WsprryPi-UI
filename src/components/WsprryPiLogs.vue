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

import { useLogMessageStore } from "@/stores/WSPRLogStore";

export default {
  name: "LogMessages",
  props: {
    logFile: {
      type: String,
      required: true,
      default: 'wspr.transmit.log',
    },
  },
  setup() {
    return {
      LogMessageStore: useLogMessageStore(),
    }
  },
  mounted() {
    // User Loader
    let loader = this.$loading.show({});
    // Switch to proper log
    this.LogMessageStore.logFile = this.logFile;
    // Retrieve initial data
    this.LogMessageStore.getLogMessages();
    // Set up periodic refreshes
    window.setInterval(() => {
      this.LogMessageStore.getLogMessages();
    }, interval)
    loader.hide();
  },
}

</script>

<style scoped>
</style>