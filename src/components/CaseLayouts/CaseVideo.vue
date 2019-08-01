<template>
  <div class="case-video" style="width: 100%;">
    <div class="case-video-item">
      <div class="video-overlay">
        <div class="video__bg"
             v-if="block.block_image"
             :style="{ 'background-image': 'url(' + block.block_image + ')' }"
        ></div>
        <div class="video__bg"
             v-if="block.video">
          <video v-if="block.video"
                 width="100%" height="100%"
                 autoplay muted
                 playsinline loop>
            <source :src="block.video">
          </video>
        </div>
        <div class="video__bg"
             v-if="block.video_link && block. video_type == 1 && block.content_type == 1">
          <iframe width="100%" height="100%"
                  :src="block.video_link ? block.video_link.replace('watch?v=', 'embed/') : block.video_link.replace('watch?v=', 'embed/')"
          ></iframe>
        </div>

        <a v-if="block.popup"
           :href="block.popup_link"
           data-fancybox
           :data-cursor="block.cursor_color ? playText : ''"
           :data-cursor-color="block.cursor_color === '0' ? 'white' : 'black'"
           class="video__popup"></a>

        <a href="javascript:void(0);"
           v-if="block.this_block_video_link"
           :data-cursor="block.cursor_color ? playText : ''"
           :data-cursor-color="block.cursor_color === '0' ? 'white' : 'black'"
           @click="showVideoInBlock1 = !showVideoInBlock1"
           :class="{'is-active': showVideoInBlock1}"
           class="videoPlayInBlock">

          <iframe width="100%" height="100%"
                  v-if="block.this_block_video_link"
                  :src="showVideoInBlock1 ? block.this_block_video_link.replace('watch?v=', 'embed/') + '?autoplay=1' : block.this_block_video_link.replace('watch?v=', 'embed/')"
          ></iframe>
        </a>

        <a href="javascript:void(0);"
           v-if="block.this_block_video_url"
           :data-cursor="block.cursor_color && !showVideoInBlock2 ? playText : pauseText"
           :data-cursor-color="block.cursor_color === '0' ? 'white' : 'black'"
           @click="showVideoInBlock2 = !showVideoInBlock2"
           :class="{'is-active': showVideoInBlock2}"
           class="videoPlayInBlock videoPlayInBlock--videoInline">
          <video v-if="block.this_block_video_url"
                 width="100%" height="100%"
                 playsinline loop>
            <source :src="block.this_block_video_url">
          </video>
        </a>
      </div>
      <span v-if="block.description"
            class="Caption case-video-text">{{block.description}}</span>
    </div>
  </div>
</template>

<script>
  export default {
    name: "CaseVideo",
    props: ['block'],
    data: () => ({
      showVideoInBlock1: false,
      showVideoInBlock2: false
    }),
    computed: {
      playText() {
        return this.$route.params.lang === 'ru' ? 'ВКЛ' : 'PLAY'
      },
      pauseText() {
        return this.$route.params.lang === 'ru' ? 'ВЫКЛ' : 'PAUSE'
      }
    },
    mounted() {
      $('iframe').hover(function () {
        $('#cursor').addClass('is-hidden')
      }, function () {
        $('#cursor').removeClass('is-hidden')
      })
    }
  }
</script>
