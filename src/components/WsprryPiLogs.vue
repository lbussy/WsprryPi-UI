<template>
  <div>
    <h4>Log:</h4>
    <div id="log" v-for="logMessage in LogMessageStore.logMessages">
      <pre>{{ logMessage[0] }}\t{{ logMessage[1] }}\n</pre>
    </div>
    <div id="scrollLock">
      <input class="disableScrollLock" type="button" value="Disable Scroll Lock">
      <input class="enableScrollLock" style="display: none;" type="button" value="Enable Scroll Lock">
    </div>
  </div>
</template>

<script>
let scrollLock = true;
let interval = 5000;

import { useLogMessageStore } from "@/stores/WsprryPiLogs";
import {getElementFromSelector} from "bootstrap/js/src/util";

export default {
  name: "LogMessages",
  setup() {
    return {
      LogMessageStore: useLogMessageStore()
    }
  },
  mounted() {
    // Retrieve initial data
    this.LogMessageStore.getLogMessages().then(() => {
      // If we need to do anything like display an error if we can't get the log messages, we can do it here
    });
    // Set up periodic refreshes
    window.setInterval(() => {
      this.LogMessageStore.getLogMessages();
      if(scrollLock == true) { $('html,body').animate({scrollTop: $("#scrollLock").offset().top}, interval) };
    }, interval)
  },
}

$(document).ready(function(){
  $('.disableScrollLock').click(function(){
    $("html,body").clearQueue()
    $(".disableScrollLock").hide();
    $(".enableScrollLock").show();
    scrollLock = false;
  });
  $('.enableScrollLock').click(function(){
    $("html,body").clearQueue()
    $(".enableScrollLock").hide();
    $(".disableScrollLock").show();
    scrollLock = true;
  });
});
</script>

<style scoped>
</style>