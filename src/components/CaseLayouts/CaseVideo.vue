<template>
	<div class="case-video" style="width: 100%;">
		<div class="case-video-item">
			<div class="video-overlay">
				<div class="video__bg"
					 :style="{ 'background-image': 'url(' + block.block_image + ')' }"
				></div>
				<a v-if="block.popup"
				   :href="block.popup_link"
				   data-fancybox
				   :data-cursor="block.cursor_color ? 'PLAY' : ''"
				   :data-cursor-color="block.cursor_color === '0' ? 'white' : 'black'"
				   class="video__popup"></a>

				<a href="javascript:void(0);"
				   v-if="block.this_block_video_link"
				   :data-cursor="block.cursor_color ? 'PLAY' : ''"
				   :data-cursor-color="block.cursor_color === '0' ? 'white' : 'black'"
				   @click="showVideoInBlock = !showVideoInBlock"
				   :class="{'is-active': showVideoInBlock}"
				   class="videoPlayInBlock">

					<iframe width="100%" height="100%"
							v-if="block.this_block_video_link"
							:src="showVideoInBlock ? block.this_block_video_link.replace('watch?v=', 'embed/') + '?autoplay=1' : block.this_block_video_link.replace('watch?v=', 'embed/')"
							></iframe>

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
      showVideoInBlock: false
    }),
	mounted() {
      $('iframe').hover(function () {
        $('#cursor').addClass('is-hidden')
      }, function () {
        $('#cursor').removeClass('is-hidden')
      })
    }
  }
</script>
