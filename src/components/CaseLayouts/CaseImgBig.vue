<template>
  <div class="big-image-item">
<!--    <img class="case-big-image" :src="imageBigUrl">-->

    <img v-lazyload
         class="case-big-image"
         :src="imageBigThumbUrl"
         :data-src="imageBigUrl"
         :data-err="imageBigThumbUrl">
    <span v-if="imageBigCaption != null" class="Caption case-big-image-text">{{imageBigCaption}}</span>
  </div>
</template>

<script>
  export default {
    name: "CaseImgBig",
    props: ['imageBigUrl', 'imageBigCaption', 'imageBigThumbUrl']
  }
</script>
