<template>
  <div class="case-video" style="width: 100%;">
    <div class="case-video-item">
      <div class="video-overlay">
        <iframe width="100%" height="350px" :src="videoUrl.replace('watch?v=', '/embed/')" frameborder="0"
                allow="autoplay; encrypted-media" hspace="0" vspace="0" allowtransparency="true"
                allowfullscreen="allowfullscreen"></iframe>
      </div>
      <span v-if="videoDescription != null" class="Caption case-video-text">{{videoDescription}}</span>
    </div>
  </div>
</template>

<script>
  export default {
    name: "CaseVideo",
    props: ['videoUrl', 'videoDescription']
  }
</script>
