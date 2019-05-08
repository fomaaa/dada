<template>
  <div class="medium-image-item">
    <img class="case-medium-image" :src="imageMediumUrl">
    <span v-if="imageMediumCaption != null" class="Caption case-medium-image-text">{{imageMediumCaption}}</span>
  </div>
</template>

<script>
  export default {
    name: "CaseImgMedium",
    props: ['imageMediumUrl', 'imageMediumCaption']
  }
</script>
