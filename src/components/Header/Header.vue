<template>
  <div class="header-container">
    <logo-block></logo-block>
    <div class="menu">
      <div class="menu-wr">
        <router-link :to="{name: 'WorksComponent'}" tag="div" class="menu-works menu-item none-outline"
                     :class="{'menu-fixed' : $route.name === 'WorksComponent' || $route.name === 'AgencyComponent'}">
          <div class="menu-works-color" ref='menuWorks'  :class='menuWorksClass'>
            <div class="menu-offset menu-offset-works"></div>
            <div class="menu-content-overlay">
              <div class="menu-content menu-content-works" @click="clickGtm('click', 'fromMainToWorks', '')">
                <div class="menu-title-overlay">
                  <h2 class="menu-title menu-title-works">{{textWorks}}</h2>
                </div>
                <div class="menu-logo-wr-overlay">
                  <div class="menu-logo-wr menu-logo-works">
                    <h3 class="works-logo menu-logo">Works</h3>
                    <h3 class="works-logo menu-logo">Works</h3>
                    <h3 class="works-logo menu-logo">Works</h3>
                    <h3 class="works-logo menu-logo mb-hidden">Works</h3>
                    <h3 class="works-logo menu-logo mb-hidden">Works</h3>
                  </div>
                </div>
              </div>
            </div>
          </div >
        </router-link>
        <router-link :to="{name: 'AgencyComponent'}" tag="div" class="menu-agency menu-item none-outline"
                     :class="{'menu-fixed' : $route.name === 'WorksComponent' || $route.name === 'AgencyComponent'}">
          <div class="menu-agency-color" ref='menuAgency' :class='menuAgencyClass'>
            <div class="menu-offset menu-offset-agency"
                 :class="{'menu-offset-agency-active': $route.name === 'AgencyComponent'}"></div>
            <div class="menu-content-overlay">
              <div class="menu-content menu-content-agency" @click="clickGtm('click', 'fromMainToAgency', '')">
                <div class="menu-title-overlay">
                  <h2 class="menu-title menu-title-agency">{{textAgency}}</h2>
                </div>
                <div class="menu-logo-wr-overlay">
                  <div class="menu-logo-wr menu-logo-agency">
                    <h3 class="agency-logo menu-logo">Agency</h3>
                    <h3 class="agency-logo menu-logo">Agency</h3>
                    <h3 class="agency-logo menu-logo">Agency</h3>
                    <h3 class="agency-logo menu-logo mb-hidden">Agency</h3>
                    <h3 class="agency-logo menu-logo mb-hidden">Agency</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    data() {
      return {
        menuLogoTextWorks: null,
        menuLogoTextAgency: null,
        textAgency: (window.isru) ? 'Агентство' : 'Agency',
        textWorks: (window.isru) ? 'Работы' : 'Works'
      }
    },

    computed: {
      menuWorksClass () {
        return [
          'menu-out',
          {
            'menu-in': this.$route.name !== 'AgencyComponent'
          }
        ]
      },
      menuAgencyClass () {
        return [
          'menu-out',
          {
            'menu-in': this.$route.name !== 'WorksComponent'
          }
        ]
      }
    },
    methods: {
      clickGtm: function (eventCategory, eventAction, eventLabel) {
        this.$gtm.trackEvent({
          event: 'gaEvent',
          category: eventCategory,
          action: eventAction,
          label: eventLabel
        });
      }
    }
  }
</script>
