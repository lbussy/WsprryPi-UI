<template>
  <Logs log-file="wspr.transmit.log" />
</template>

<script>
import Logs from "@/components/Logs.vue";

export default {
  name: "WsprTransmitLog",
  components: {
    Logs,
  },
}
</script>
