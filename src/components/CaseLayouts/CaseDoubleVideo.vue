<template>
  <div class="case-video case-double-video" style="width: 100%;">
    <div class="case-video-item">
      <div class="video-overlay">
        <iframe width="100%" height="350px" :src="videoDoubleUrl.replace('watch?v=', '/embed/')" frameborder="0"
                allow="autoplay; encrypted-media" hspace="0" vspace="0" allowtransparency="true"
                allowfullscreen="allowfullscreen"></iframe>
      </div>
      <span v-if="videoDoubleDescription != null" class="Caption case-video-text">{{videoDoubleDescription}}</span>
    </div>
    <div class="case-video-item">
      <div class="video-overlay">
        <iframe width="100%" height="350px" :src="videoDoubleUrl2.replace('watch?v=', '/embed/')" frameborder="0"
                allow="autoplay; encrypted-media" hspace="0" vspace="0" allowtransparency="true"
                allowfullscreen="allowfullscreen"></iframe>
      </div>
      <span v-if="videoDoubleDescription2 != null" class="Caption case-video-text">{{videoDoubleDescription2}}</span>
    </div>
  </div>
</template>

<script>
  export default {
    name: "CaseDoubleVideo",
    props: ['videoDoubleUrl', 'videoDoubleUrl2', 'videoDoubleDescription', 'videoDoubleDescription2']
  }
</script>
