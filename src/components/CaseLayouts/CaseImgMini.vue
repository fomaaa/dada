<template>
  <div class="case-mini-images-in">
    <div class="mini-image-item">
<!--      <img class="case-mini-image" :src="imageMiniUrl[0]">-->
      <img v-lazyload
           class="case-mini-image"
           :src="imageMiniThumbUrl[0]"
           :data-src="imageMiniUrl[0]"
           :data-err="imageMiniThumbUrl[0]">
      <span v-if="imageMiniCaption[0] != null" class="Caption case-mini-image-text">{{imageMiniCaption[0]}}</span>
    </div>
    <div class="mini-image-item">
<!--      <img class="case-mini-image" :src="imageMiniUrl[1]">-->
      <img v-lazyload
           class="case-mini-image"
           :src="imageMiniThumbUrl[1]"
           :data-src="imageMiniUrl[1]"
           :data-err="imageMiniThumbUrl[1]">
      <span  v-if="imageMiniCaption[1] != null" class="Caption case-mini-image-text">{{imageMiniCaption[1]}}</span>
    </div>
  </div>
</template>

<script>
  export default {
    name: "CaseImgMini",
    props: ['imageMiniUrl', 'imageMiniCaption', 'imageMiniThumbUrl']
  }
</script>
