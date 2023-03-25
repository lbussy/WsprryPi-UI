<template>
  <div class="container">

    <div class="card border-primary mb-3">
      <div class="card-header">
        WSPRrry Pi Configuration
      </div>
      <div class="card-body">

        <form id="wsprform">
          <fieldset id="wsprconfig" :disabled="!SettingsStore.hasSettings" class="form-group">
            <!-- First Row -->
            <legend class="mt-4">Control</legend>
            <div class="was-validated container">
              <div class="row">
                <div class="col-md-6">
                  <div class="row gx-1 ">
                    <div class="col-md-4 text-end">
                      <label class="form-check-label" for="transmit">Enable
                        Transmission:&nbsp;</label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-check form-switch">
                        <input id="transmit" v-model="transmit" class="form-check-input"
                               data-form-type="other" type="checkbox">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row gx-1 ">
                    <div class="col-md-4 text-end">
                      <label class="form-check-label" for="use_led">Enable LED:&nbsp;</label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-check form-switch">
                        <input id="use_led" v-model="use_led" class="form-check-input"
                               data-form-type="other" type="checkbox">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- First Row -->

            <!-- Second Row -->
            <legend class="mt-4">Operator Information</legend>
            <div class="was-validated container">
              <div class="row">
                <div class="col-md-6">
                  <div class="row gx-1 ">
                    <div class="col-md-3 text-end">
                      Call Sign:&nbsp;
                    </div>
                    <div class="col-md-9">
                      <input id="callsign" v-model="callsign" class="form-control"
                             minlength="4" pattern="[-a-zA-Z0-9\/]+" placeholder="Enter callsign"
                             required type="text">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please enter your callsign.</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row gx-1 ">
                    <div class="col-md-3 text-end">
                      Grid Square:&nbsp;
                    </div>
                    <div class="col-md-9">
                      <input id="gridsquare" v-model="gridsquare" class="form-control"
                             maxlength="4" minlength="4" pattern="[a-z,A-Z]{2}[0-9]{2}"
                             placeholder="Enter gridsquare" required type="text">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please enter your four-character grid square.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Second Row -->

            <!-- Third Row -->
            <legend class="mt-4">Station Information</legend>
            <div class="container">
              <div class="row">

                <div class="col-md-6">
                  <div class="row gx-1 ">
                    <div class="col-md-3 text-end">
                      Transmit Power:&nbsp;
                    </div>
                    <div class="was-validated col-md-9">
                      <input id="dbm" v-model="dbm" class="form-control" max="62" min="-10"
                             placeholder="Enter transmit power" required step="1" type="number">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Please enter your transmit power in dBm
                        (without the 'dBm' suffix.)
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row gx-1 ">
                    <div class="col-md-3 text-end">
                      Frequency:&nbsp;
                    </div>
                    <div class="col-md-9">
                      <input id="frequencies" v-model="frequencies" :class="computedCheckFreq"
                             placeholder="Enter frequency" type="text">
                      <div class="valid-feedback">Ok.</div>
                      <div class="invalid-feedback">Add a single frequency or a space-delimited
                        list (see <a
                            href="https://wsprry-pi.readthedocs.io/en/latest/Operations/index.html"
                            rel="noopener noreferrer" target="_blank">documentation</a>.)
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row Split -->

                <div class="was-validated row">
                  <div class="col-md-6">
                    <div class="row gx-1 ">
                      <div class="col-md-4 text-end">
                        <!-- Empty -->
                      </div>
                      <div class="col-md-8">
                        <!-- Empty -->
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row gx-1 ">
                      <div class="col-md-4 text-end">
                        <label class="form-check-label" for="useoffset">Random
                          Offset:&nbsp;</label>
                      </div>
                      <div class="col-md-8">
                        <div class="form-check form-switch">
                          <input id="useoffset" v-model="useoffset" class="form-check-input"
                                 data-form-type="other" type="checkbox">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Third Row -->

            <!-- Fourth Row -->
            <legend class="mt-4">Advanced Information</legend>
            <div class="container">
              <div class="was-validated row">
                <div class="col-md-6">
                  <div class="row gx-1 ">
                    <div class="col-md-4 text-end">
                      <label class="form-check-label" for="selfcal">Self
                        Calibration:&nbsp;</label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-check form-switch">
                        <input id="selfcal" v-model="selfcal" class="form-check-input"
                               data-form-type="other" type="checkbox">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row gx-1 ">
                    <div class="col-md-3 text-end">
                      PPM Offset:&nbsp;
                    </div>
                    <div class="col-md-9">
                      <input id="ppm" v-model="ppm" :disabled="selfcal" class="form-control" max="200"
                             min="-200" placeholder="Enter PPM" required step=".000001" type="number">
                      <div class="valid-feedback">Valid.</div>
                      <div class="invalid-feedback">Enter a positive or negative decimal number
                        for frequency correction.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Fourth Row -->

            <!-- Fifth Row -->
            <legend class="mt-4">Transmit Power</legend>
            <p>This sets power on the Pi GPIO only; any amplification must be taken into account.</p>
            <div class="container">
              <div class="was-validated row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="range-wrap">
                    <input id="power_level" v-model="power_level" class="range" max="7" min="0" type="range"
                           v-on:change="changeBubbleLeft">
                    <output id="rangeText" class="bubble text-center" v-bind:style="{ left: computedBubbleLeft }"
                            v-html="rangeValues[power_level]" :key="bubble_left"></output>
                  </div>
                </div>
                <div class="col-md-2"></div>
              </div>
            </div>
            <p></p>

            <!-- End Fifth Row -->

            <div id="buttons" class="modal-footer justify-content-center">
              <button id="submit" :disabled="!validatePage" class="btn btn-primary" type="button" @click="submitForm">
                &nbsp;Save&nbsp;
              </button>
              &nbsp;
              <button id="reset" :disabled="!!validatePage" class="btn btn-secondary" type="button"
                      @click="updateCachedSettings">Reset
              </button>
            </div>
          </fieldset>
        </form>

      </div>
    </div>

  </div>
</template>

<script>
import {useSettingsStore} from "@/stores/WSPRSettingsStore";
import {getElementFromSelector} from "bootstrap/js/src/util";

export default {
  name: "WsprryPi Settings",
  props: {
    msg: String,
  },
  setup() {
    return {
      SettingsStore: useSettingsStore(),  // Updated in Settings.vue
      rangeValues,
    }
  },
  data() {
    return {
      hasSettings: false,
      transmit: false,
      use_led: false,
      callsign: "NXXX",
      gridsquare: "ZZ99",
      dbm: 10,
      frequencies: "20m",
      useoffset: false,
      selfcal: true,
      ppm: 0.0,
      power_level: 7,
      bubble_left: '50%',
    }
  },
  mounted() {
    // Retrieve initial data
    let loader = this.$loading.show({});
    this.SettingsStore.getSettings().then(() => {
      this.updateCachedSettings();
      this.changeBubbleLeft();
      loader.hide();
    });

    // Set up periodic refreshes
    // window.setInterval(() => {
    //   this.ExtendedSettingsStore.getExtendedSettings();
    // }, 30000)  // Do we really want to update this? Probably not.
  },
  computed: {
    computedBubbleLeft: function () {
      return this.bubble_left;
    },
    computedCheckFreq: function () {
      if (this.checkFreq()) {
        return ["is-valid", "form-control"];
      } else {
        return ["is-invalid", "form-control"];
      }
    }
  },
  methods: {
    submitForm: function () {
      if (this.validatePage()) {
        let loader = this.$loading.show({});
        this.SettingsStore.setSettings(
            this.transmit,
            this.use_led,
            this.callsign.toUpperCase(),
            this.gridsquare.toUpperCase(),
            this.dbm,
            this.frequencies.toLowerCase(),
            this.useoffset,
            this.selfcal,
            this.ppm,
            this.power_level,
        ).then(() => {
          this.updateCachedSettings();
          loader.hide();
        });
      }
    },
    updateCachedSettings: function () {
      this.transmit = this.SettingsStore.transmit;
      this.use_led = this.SettingsStore.use_led;
      this.callsign = this.SettingsStore.callsign.toUpperCase();
      this.gridsquare = this.SettingsStore.gridsquare.toUpperCase();
      this.dbm = this.SettingsStore.dbm;
      this.frequencies = this.SettingsStore.frequencies.toLowerCase();
      this.useoffset = this.SettingsStore.useoffset;
      this.selfcal = this.SettingsStore.selfcal;
      this.ppm = this.SettingsStore.ppm;
      this.power_level = this.SettingsStore.power_level;
    },
    checkFreq: function () {
      let freqString = this.frequencies.toLowerCase();

      // Min length would be one of 2m, 4m, 6m, = 2
      if (freqString.length < 2) return false;

      // Check for alphanumerics, spaces or hyphens only
      let compareRegEx = "^[a-zA-Z0-9 -]*$";
      if (!freqString.match(compareRegEx)) return false;

      // Split on whitespace (duplicates are merged)
      let freqArray = freqString.split(/\s+/);
      let freqArrayLength = freqArray.length;
      for (let i = 0; i < freqArrayLength; i++) {
        let freqWord = freqArray[i];
        // Make sure this is not an empty string
        if (!freqArray[i] == " ") {
          // Check if all numbers (also catches exponents)
          if (isNumeric(freqWord)) {
            // Ok
          }
          // Check for LF or MF
          else if (freqWord == "lf" || freqWord == "mf") {
            // Ok
          }
          // Check for "-15" on the end
          else if (freqWord.endsWith("-15") && !freqWord.endsWith("--15")) {
            // If removing the "-15" does not yield a number
            if (isNaN(trimLast(freqWord, 3)) || trimLast(freqWord, 1) < 3) {
              // See if it indicates a band plan
              if (!trimLast(freqWord, 3).endsWith("m")) {
                // Not a number but does not end in 'm'
                if (trimLast(freqWord, 3) == "lf" || trimLast(freqWord, 3) == "mf") {
                  // Ol, LF or MF
                } else {
                  return false;
                }
              } else if (isNumeric(trimLast(freqWord, 4))) {
                // It's numeric, is it a band plan?
                if (!isBand(trimLast(freqWord, 4))) {
                  // Not a band plan
                  return false;
                } else {
                  let band = parseInt(trimLast(freqWord, 4));
                  if (band == 160) {
                    // Ok - 160m is good with -15
                  } else {
                    return false;
                  }
                }
              } else {
                // All letters
                return false;
              }
            } else {
              // Straight frequency, no -15 available
              return false;
            }
          }
          // Check for "m" on the end
          else if (freqWord.endsWith("m")) {
            // Check to see if it's a number
            if (isNaN(trimLast(freqWord, 1)) || trimLast(freqWord, 1) < 1) {
              // Not a valid number
              return false;
            } else if (!isBand(trimLast(freqWord, 1))) {
              // Not a valid band plan
              return false;
            }
            // Ok
          }
          // Anything else is invalid
          else {
            // Not Ok
            return false;
          }
        }
      }
      return true;
    },
    validatePage: function () {
      let thisForm = document.querySelector('#wsprform');
      let failcount = 0;
      if (!thisForm.reportValidity()) failcount++;
      if (!this.checkFreq) failcount++;
      return (failcount > 0 ? false : true);
    },
    changeBubbleLeft: function () {
      const val = this.power_level;
      // This "calibrates" the bubble to the slider.
      let valPct = (val / 7);
      const min = 0.0095;
      const max = .984;
      const range = max - min;
      valPct = ((valPct * range) + min) * 100;
      valPct = valPct.toString() + "%";
      this.bubble_left = valPct;
    },
  }
};

const rangeValues =
    {
      // Define range labels for slider
      "0": "2mA<br>-3.4dBm",
      "1": "4mA<br>2.1dBm",
      "2": "6mA<br>4.9dBm",
      "3": "8mA<br>6.6dBm",
      "4": "10mA<br>8.2dBm",
      "5": "12mA<br>9.2dBm",
      "6": "14mA<br>10.0dBm",
      "7": "16mA<br>10.6dBm"
    };

function isNumeric(num) {
  return !isNaN(num)
}

function trimLast(string, num) {
  return string.substring(0, string.length - num);
}

function isBand(num) {
  const bandArray = [160, 80, 60, 40, 30, 20, 17, 15, 12, 10, 6, 4, 2];
  return bandArray.includes(parseInt(num));
}

</script>

<style scoped>
</style>
