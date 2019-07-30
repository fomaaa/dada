<template>
  <router-link :to="{name: 'CaseComponent', params: {case: url}}" tag="div"
               :style="{height: ratioForPreviewF + 'px'}"
               :class="['works-projects-card', index == 0 || index == 3 ? 'works-projects-card-big' : 'works-projects-card-small']">
    <div class="works-projects-card-overlay" @click="[animatetoCase($event), clickGtm('click', 'fromWorktoCase', title)]">
        <div :style="{height: ratioForPreviewF + 'px'}"
             class="works-card-in">
          <div :class="['my', index == 0 || index == 3 ? 'big' : 'small']" style="width: 100%; height: 100%;">
            <div class="projects-card-content">
              <div class="card-content-overlay">
                <h3 class="projects-card-title">{{title}}</h3>
                <span class="projects-card-text">{{campaign}}</span>
              </div>
            </div>
            <div class="overlay-card">
              <div class="projects-card-img"
                   v-if="previewType === '0' && preview"
                   :style="{backgroundImage: 'url('+ preview +')'}">
              </div>
              <div class="projects-card-img"
                   v-if="previewType === '1'">
                <video v-if="preview"
                       width="100%" height="100%"
                       muted playsinline autoplay loop>
                  <source :src="preview">
                </video>
              </div>
            </div>
          </div>
        </div>
      </div>
  </router-link>
</template>

<script>
  export default {
    name: "CasePreview",
    data() {
      return {
        istoCase: false,
        window: {
          width: 0,
          height: 0
        },
        fontGlobal: 0,
        ratioForPreview: 0,
        cardsPreviewOverlay: null,
        worksContentWhite: null,
        cardsPreviewOverlayTrigger: true
      }
    },
    computed: {
      ratioForPreviewF: function () {
        let q1 = this.screenWidth / 2;
        let q2 = this.screenWidth / ((this.screenHeight - Math.ceil(this.fontGlobalMy * 6.2)));
        return this.ratioForPreview = (q1 / q2);
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
      },
      returnHeightWidth: function () {
        return [this.screenHeight, this.screenWidth, this.fontGlobalMy]
      },
      getSrc: function () {
        return this.preview
      },
      getTrigger: function () {
        return this.cardsTrigger;
      },
      animatetoCase: function (event) {
        this.istoCase = true;
        this.$emit('goToCard');
        let overlayCard = event.currentTarget.querySelector('.overlay-card');

        let finishCardHeight = this.screenHeight - (Math.ceil(this.fontGlobalMy * 6.2)).toFixed(2);
        overlayCard.classList.add('card-img-active');
        let cardWidth = overlayCard.clientWidth;
        let cardHeight = overlayCard.clientHeight;

        let cardScaleX = (this.screenWidth / cardWidth);
        let cardScaleY = (finishCardHeight / cardHeight);
        console.log('finishCardHeight', finishCardHeight);
        console.log('cardWidth', cardWidth);
        console.log('cardHeight', cardHeight);
        console.log('cardScaleX', cardScaleX);
        console.log('cardScaleY', cardScaleY);
        let createdStyleTag = document.createElement("style");
        createdStyleTag.textContent = '@keyframes img-in {' +
          'from { transform: scale(1, 1) translate3d(0,0,0); }' +
          'to{ transform: scale(' + cardScaleX + ',' + cardScaleY + ');}' +
          '}';
        overlayCard.appendChild(createdStyleTag);

        let cardTopPoint = (overlayCard.getBoundingClientRect().top).toFixed(2);
        let cardRightPoint = (this.screenWidth - (overlayCard.getBoundingClientRect().right)).toFixed(2);
        let cardRightPointWidth = (overlayCard.getBoundingClientRect().right).toFixed(2);
        let h_c_height = finishCardHeight;
        let h_b_height = cardHeight;
        let k_height = 0, y_height = 0;
        let s_height = (cardTopPoint - (Math.ceil(this.fontGlobalMy * 6.2))).toFixed(2);
        k_height = (s_height * 100 / (h_c_height - h_b_height)).toFixed(2);
        // y_height = (h_b_height * k_height / 100 - 1.23);
        y_height = (h_b_height * k_height / 100).toFixed(2);

        let h_c_width = this.screenWidth;
        let h_b_width = cardWidth;
        let k_width = 0, x_width = 0;
        let s_width = (h_c_width - h_b_width - cardRightPoint);
        k_width = (s_width * 100 / (h_c_width - h_b_width));
        x_width = (h_b_width * k_width / 100 + 0.04).toFixed(2);
        console.log('x_width', x_width);
        console.log('y_height', y_height);
        overlayCard.setAttribute('style', `transform-origin: ${x_width}px ${y_height}px;`);
      }
    },
    beforeMount() {
      this.getTrigger();
      let isThis = this;
      this.cardsPreviewOverlay = document.querySelectorAll('.works-projects-card-overlay');
      this.worksContentWhite = document.getElementsByClassName('works-content')[0];
      if(this.cardsTrigger) {
        this.cardsPreviewOverlay.forEach(function (item) {
          item.classList.add('card-overlay-start');
          setTimeout(
            function () {
              item.classList.add('card-overlay-transition');
            }, 100
          );
        });
        setTimeout(function () {
          isThis.worksContentWhite.classList.add('works-content-white');
        }, 100);
        this.cardsPreviewOverlayTrigger = false;
        this.$root.$emit('cardsTriggerRes', this.cardsPreviewOverlayTrigger);
      }
    },
    mounted() {
      console.log('casePreview-mounted');

      this.returnHeightWidth();
    },
    beforeDestroy() {
      this.cardsPreviewOverlay.forEach(function (item) {
        item.classList.remove('card-overlay-transition');
      });
    },
    destroyed() {
      console.log('casePreview-destroyed');
    },
    props: ['cardsTrigger', 'fontGlobalMy', 'screenWidth', 'screenHeight', 'index', 'url', 'preview', 'previewType', 'title', 'campaign']
  }
</script>
