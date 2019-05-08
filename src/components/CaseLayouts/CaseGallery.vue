<template>
    <div style="width: 100%;">
      <swiper class="image-gallery-slider" :options="swiperImageGalleryOption" ref="swiperImageGallery">
        <swiper-slide class="image-gallery-slide" v-for="gallery in galleryArr" :key="gallery.id">
          <!--<img class="img-for-slide" @click="nextSlideGallery"-->
               <!--style="width: 100%; height: auto; top: 0;"-->
               <!--:src="gallery.img">-->
          <div class="img-for-slide" @click="nextSlideGallery"
               style="width: 100%; height: 100%; position: absolute; top: 0;"
               :style="{backgroundImage: 'url('+ gallery.img +')'}"></div>
        </swiper-slide>
        <div class="image-gallery-button-prev swiper-button-prev none-outline" slot="button-prev"><span
          class="button-arrow-img"></span></div>
        <div class="image-gallery-button-next swiper-button-next none-outline" slot="button-next"><span
          class="button-arrow-img"></span></div>
      </swiper>
      <div class="image-gallery-pagination swiper-pagination"></div>
    </div>
</template>

<script>
  import {swiper, swiperSlide} from 'vue-awesome-swiper'

  export default {
    name: "CaseGallery",
    data() {
      return {
        swiperImageGallery: '',
        swiperTextGallery: '',
        swiperImageGalleryOption: {
          speed: 500,
          simulateTouch: false,
          keyboardControl: true,
          touchRatio: 0,
          slidesPerView: 'auto',
          spaceBetween: 96,
          // loop: false,
          centeredSlides: true,
          navigation: {
            nextEl: '.image-gallery-button-next',
            prevEl: '.image-gallery-button-prev'
          },
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          breakpoints: {
            1024: {
              spaceBetween: 0,
              slidesPerView: 1,
              touchRatio: 1
            }
          }
        }
      }
    },
    methods: {
      nextSlideGallery: function () {
        this.$refs.swiperImageGallery.swiper.slideNext();
      }
    },
    props: ['galleryArr'],
    components: {swiper, swiperSlide},
  }
</script>
