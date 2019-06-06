<template>
  <div class="contacts-container">
    <div class="contacts-item contacts-item-russia">
      <div class="contact-city"><span>Moscow</span></div>
      <div class="contact-address"><span>2 Zvenigorodskaya, 13/41</span></div>
      <div class="contact-phone">Phone <a href="tel:+74953748814" class="phone-number">+7 (495) 374-88-14</a></div>
    </div>
    <div class="contacts-item contacts-item-america">
      <div class="contact-city"><span>Los Angeles</span></div>
      <div class="contact-address"><span>1120 S Grand Ave #1318<br>CA 90015</span></div>
      <!--<div class="contact-phone">Phone <a href="tel:+13103953500" class="phone-number">+1 (310) 395-3500</a></div>-->
    </div>
    <div class="contacts-item contacts-item-social">
      <div class="contact-email"><a class="email-link"
                                    href="mailto:ask@dadacreative.com">ask@dadacreative.com</a></div>
      <div class="contact-social">
        <a href="https://www.facebook.com/dada.agency" target="_blank"
           class="social-item social-item-facebook" @click="clickGtm('click', 'fromFooterToSocialNetwork', 'facebook')">Facebook</a>
        <span class="midpoint"> • </span>
        <a href="https://www.instagram.com/dada.agency/" target="_blank"
           class="social-item social-item-instagram"
           @click="clickGtm('click', 'fromFooterToSocialNetwork', 'instagram')">Instagram</a>
      </div>
    </div>
    <div class="contacts-item contacts-item-assessment" v-if="this.$route.name === 'AgencyComponent'">
      <a href="../../../static/media/DADA_SOUT.pdf" target="_blank">
        Специальная оценка условий труда
      </a>
    </div>
  </div>
</template>

<script>

  export default {
    data() {
      return {
        name: 'footer-block'
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
