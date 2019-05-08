<template>
  <nav class="menu">
    <router-link :to="{name: 'WorksComponent'}" tag="div"
                 class="menu-works menu-item">
      <div class="menu-item-overlay" @click="clickGtm('click', 'fromCaseToWorks', '')"></div>
      <div class="menu-item-block" style="width: 100%; height: 100%;">
        <span class="menu-title menu-mini-title menu-title-works">{{textWorks}}</span>
      </div>
    </router-link>
    <router-link :to="{name: 'AgencyComponent'}" tag="div"
                 class="menu-agency menu-item none-outline">
      <div class="menu-item-overlay" @click="clickGtm('click', 'fromCaseToAgency', '')"></div>
      <div class="menu-item-block" style="width: 100%; height: 100%;">
        <span class="menu-title menu-mini-title menu-title-agency">{{textAgency}}</span>
      </div>
    </router-link>
  </nav>
</template>

<script>

  export default {
    data() {
      return {
        name: 'header-mini',
        textAgency: (window.isru) ? 'Агентство' : 'Agency',
        textWorks: (window.isru) ? 'Работы' : 'Works'
      }
    },
    methods: {
      clickGtm: function (eventCategory, eventAction, eventLabel) {
        this.$gtm.trackEvent({
          event: 'gaEvent',
          category: eventCategory,
          action: eventAction,
          label: eventLabel,
        });
      }
    }
  }
</script>
