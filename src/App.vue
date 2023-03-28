<script setup>

</script>

<template>
  <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container">

      <router-link :to="{name: 'Config'}" v-slot="{ href, navigate, isActive }" custom>
        <a :href="href" class="navbar-brand" @click="navigate">
          <font-awesome-icon icon="fa-solid fa-tower-broadcast" />&nbsp;Wsprry Pi
        </a>
      </router-link>

      <button aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
              data-bs-target="#navbarResponsive" data-bs-toggle="collapse" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarResponsive" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link :to="{name: 'Config'}" v-slot="{ href, navigate, isActive }" custom>
              <a :href="href" :class="'nav-link active'" @click="navigate">Config</a>
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              Logs
            </a>
            <div class="dropdown-menu">
              <router-link :to="{name: 'WStd'}" v-bind="$props" v-slot="{ href, navigate, isActive }" custom>
                <a :href="href" class="dropdown-item" @click="navigate">WSPR Transmit</a>
              </router-link>
              <router-link :to="{name: 'WErr'}" v-bind="$props" v-slot="{ href, navigate, isActive }" custom>
                <a :href="href" class="dropdown-item" @click="navigate">WSPR Errors</a>
              </router-link>
              <div class="dropdown-divider"></div>
              <router-link :to="{name: 'SStd'}" v-bind="$props" v-slot="{ href, navigate, isActive }" custom>
                <a :href="href" class="dropdown-item" @click="navigate">Shutdown Transmit</a>
              </router-link>
              <router-link :to="{name: 'SErr'}" v-bind="$props" v-slot="{ href, navigate, isActive }" custom>
                <a :href="href" class="dropdown-item" @click="navigate">Shutdown Error</a>
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

  <router-view  />

  <div class="container">
    <footer id="footer">
      <div class="row">
        <div class="col-lg-12">
          <ul class="list-unstyled">
            <li><a href="http://wsprdocs.aa0nt.net" rel="noopener" target="_blank">Documentation</a></li>
            <li><a href="https://github.com/lbussy/WsprryPi" rel="noopener" target="_blank">GitHub</a></li>
            <li><a href="https://tapr.org/" rel="noopener" target="_blank">TAPR</a></li>
            <li><a href="https://www.wsprnet.org/" rel="noopener" target="_blank">WSPRNet</a></li>
          </ul>
          <p>Created by Lee Bussy, AA0NT.</p>
          <p>Released under <a href="https://github.com/lbussy/WsprryPi-UI/blob/main/LICENSE.md" rel="noopener" target="_blank">
            The MIT License (MIT)</a>.</p>
          <p>Based on <a href="https://getbootstrap.com/" rel="noopener" target="_blank">Bootstrap</a>.&nbsp;
            Icons from <a href="https://fontawesome.com/" rel="noopener" target="_blank">Font Awesome</a>.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>

</style>
