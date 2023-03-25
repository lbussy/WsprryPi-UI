<script setup>
import WsprSettings from './components/WsprryPiSettings.vue'
import WsprLog from './components/WsprryPiLogs.vue'
</script>

<template>
  <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="../">
        <font-awesome-icon icon="fa-solid fa-tower-broadcast" />&nbsp;Wsprry Pi
      </a>
      <button aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
              data-bs-target="#navbarResponsive" data-bs-toggle="collapse" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarResponsive" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link to="Config" v-slot="{ href }" custom>
              <a :href="href" :class="[active ? 'nav-link active' : '', 'nav-link']" @click="navigate">Config</a>
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              Logs
            </a>
            <div class="dropdown-menu">
              <router-link to="WStd" v-slot="{ href }" custom>
                <a :href="href" :class="[active ? 'dropdown-item' : '', 'dropdown-item']" @click="navigate">WSPR Transmit</a>
              </router-link>
              <router-link to="WErr" v-slot="{ href }" custom>
                <a :href="href" :class="[active ? 'dropdown-item' : '', 'dropdown-item']" @click="navigate">WSPR Errors</a>
              </router-link>
              <div class="dropdown-divider"></div>
              <router-link to="SStd" v-slot="{ href }" custom>
                <a :href="href" :class="[active ? 'dropdown-item' : '', 'dropdown-item']" @click="navigate">Shutdown Transmit</a>
              </router-link>
              <router-link to="SErr" v-slot="{ href }" custom>
                <a :href="href" :class="[active ? 'dropdown-item' : '', 'dropdown-item']" @click="navigate">Shutdown Error</a>
              </router-link>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav ms-md-auto">
          <li class="nav-item">
            <a class="nav-link" href="https://github.com/lbussy/WsprryPi/" style="color:white" rel="noopener" target="_blank">
              <font-awesome-icon icon="fa-brands fa-github"/>&nbsp;GitHub
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://wsprdocs.aa0nt.net" style="color:white" rel="noopener" target="_blank">
              <font-awesome-icon icon="fa-solid fa-book"/>&nbsp;Documentation
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!--  <WsprLog msg="Wsprry Pi Web " />-->
  <!-- <WsprSettings msg="Wsprry Pi Web " /> -->
  <router-view  />

  <div class="container">
    <footer id="footer">
      <div class="row">
        <div class="col-lg-12">
          <ul class="list-unstyled">
            <li><a href="http://wsprdocs.aa0nt.net">Documentation</a></li>
            <li><a href="https://github.com/lbussy/WsprryPi">GitHub</a></li>
            <li><a href="https://tapr.org/">TAPR</a></li>
            <li><a href="https://www.wsprnet.org/">WSPRNet</a></li>
          </ul>
          <p>Created by Lee Bussy, AA0NT.</p>
          <p>Released under <a href="https://github.com/lbussy/WsprryPi-UI/blob/main/LICENSE.md">
            The MIT License (MIT)</a>.</p>
          <p>Based on <a href="https://getbootstrap.com/" rel="nofollow">Bootstrap</a>.&nbsp;
            Icons from <a href="https://fontawesome.com/" rel="nofollow">Font Awesome</a>.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>

</style>
