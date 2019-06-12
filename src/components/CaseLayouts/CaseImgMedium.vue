<template>
  <div class="medium-image-item">
<!--    <img class="case-medium-image" :src="imageMediumUrl">-->
    <img v-lazyload
         class="case-medium-image"
         :src="imageMediumThumbUrl"
         :data-src="imageMediumUrl"
         :data-err="imageMediumThumbUrl">
    <span v-if="imageMediumCaption != null" class="Caption case-medium-image-text">{{imageMediumCaption}}</span>
  </div>
</template>

<script>
  export default {
    name: "CaseImgMedium",
    props: ['imageMediumUrl', 'imageMediumCaption', 'imageMediumThumbUrl']
  }
</script>
