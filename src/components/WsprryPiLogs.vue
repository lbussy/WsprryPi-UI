<template>
  <div class="container">
    <div>
      <h4>Log:</h4>

      <ul id="log">
        <li v-for="logMessage in LogMessageStore.logMessages" style="list-style-type: none;">
          {{ logMessage[0] }}:  {{ logMessage[1] }}
        </li>
      </ul>

    </div>
  </div>
</template>

<script>
let interval = 5000;

import { useLogMessageStore } from "@/stores/WSPRLogStore";

export default {
  name: "LogMessages",
  setup() {
    return {
      LogMessageStore: useLogMessageStore()
    }
  },
  mounted() {
    // Retrieve initial data
    this.LogMessageStore.getLogMessages();
    // Set up periodic refreshes
    window.setInterval(() => {
      this.LogMessageStore.getLogMessages();
    }, interval)
  },
}

</script>

<style scoped>
</style>