<template>
  <div class="main-logo-container" style="z-index: 999999;">
    <router-link :to="{name: 'MainComponent'}" tag="div" class="main-logo-track">
      <div class="main-logo-img"></div>
      <div class="main-logo-img"></div>
      <div class="main-logo-img"></div>
      <div class="main-logo-img"></div>
      <div class="main-logo-img"></div>
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'logo-block'
}
</script>
