<template>
  <div class="big-image-item">
    <img class="case-big-image" :src="imageBigUrl">
    <span v-if="imageBigCaption != null" class="Caption case-big-image-text">{{imageBigCaption}}</span>
  </div>
</template>

<script>
  export default {
    name: "CaseImgBig",
    props: ['imageBigUrl', 'imageBigCaption']
  }
</script>
