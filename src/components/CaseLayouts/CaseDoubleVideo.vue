<template>
	<div class="case-video case-double-video" style="width: 100%;">
		<div class="case-video-item">

			<a v-if="block.popup_video1 && block.video_block_type1 === '0'"
			   class="popupVideoLink"
			   :data-cursor="block.video_cursor_1 === '0' || block.video_cursor_1 === '1' ? playText : ''"
			   :data-cursor-color="block.video_cursor_1 === '0' ? 'white' : 'black'"
			   :class="{'cursorColorBlack': block.video_cursor_1 === '1', 'cursorColorWhite': block.video_cursor_1 === '0'}"
			   data-fancybox
			   :href="block.video_url1 || block.video_block_video1">
				<div class="video-overlay">
					<iframe width="100%" height="350px"
							v-if="block.video_block_video_type_1 === '1' && block.video_block_link1.indexOf('youtube')"
							:src="block.video_block_link1.replace('watch?v=', 'embed/') + '?mute=1&showinfo=0&controls=0&rel=0&autoplay=1'"
							frameborder="0"
							allow="autoplay; encrypted-media"
							hspace="0"
							vspace="0"
							allowtransparency="true"
							allowfullscreen="allowfullscreen"></iframe>
					<video v-if="block.video_block_video_type_1 === '0' && block.video_block_video1"
						   width="100%" height="100%"
						   muted playsinline autoplay loop>
						<source :src="block.video_block_video1">
					</video>
				</div>
			</a>
			<div class="video-overlay" v-else-if="block.video_block_type1 === '0'">
				<iframe width="100%" height="350px"
						v-if="block.video_block_video_type_1 === '1' && block.video_block_link1.indexOf('youtube')"
						:src="block.video_block_link1.replace('watch?v=', 'embed/') + '?mute=1&showinfo=0&controls=0&rel=0&autoplay=1'"
						frameborder="0"
						allow="autoplay; encrypted-media"
						hspace="0"
						vspace="0"
						allowtransparency="true"
						allowfullscreen="allowfullscreen"></iframe>
				<video v-if="block.video_block_video_type_1 === '0' && block.video_block_video1"
					   width="100%" height="100%"
					   muted playsinline autoplay loop>
					<source :src="block.video_block_video1">
				</video>
			</div>

			<a v-if="block.popup_video1 && block.video_block_type1 === '1'"
			   class="popupVideoLink"
			   :data-cursor="block.video_cursor_1 === '0' || block.video_cursor_1 === '1' ? playText : ''"
			   :data-cursor-color="block.video_cursor_1 === '0' ? 'white' : 'black'"
			   data-fancybox
			   :href="block.video_url1 || block.video_block_video1">
				<div class="video-overlay">
					<img :src="block.video_block_image1" alt="">
				</div>
			</a>
			<div class="video-overlay" v-else-if="block.video_block_type1 === '1'">
				<img :src="block.video_block_image1" alt="">
			</div>

			<span v-if="block.description"
				  class="Caption case-video-text">{{block.description}}</span>
		</div>
		<div class="case-video-item">

			<a v-if="block.popup_video2 && block.video_block_type2 === '0'"
			   class="popupVideoLink"
			   :data-cursor="block.video_cursor_2 === '0' || block.video_cursor_2 === '1' ? playText : ''"
			   :data-cursor-color="block.video_cursor_2 === '0' ? 'white' : 'black'"
			   :class="{'cursorColorBlack': block.video_cursor_2 === '1', 'cursorColorWhite': block.video_cursor_2 === '0'}"
			   data-fancybox
			   :href="block.video_url2 || block.video_block_video2">
				<div class="video-overlay">
					<iframe width="100%" height="350px"
							v-if="block.video_block_video_type_2 === '1' && block.video_block_link2.indexOf('youtube')"
							:src="block.video_block_link2.replace('watch?v=', 'embed/') + '?mute=1&showinfo=0&controls=0&rel=0&autoplay=1'"
							frameborder="0"
							allow="autoplay; encrypted-media"
							hspace="0"
							vspace="0"
							allowtransparency="true"
							allowfullscreen="allowfullscreen"></iframe>
					<video v-if="block.video_block_video_type_2 === '0' && block.video_block_video1"
						   width="100%" height="100%"
						   muted playsinline autoplay loop>
						<source :src="block.video_block_video2">
					</video>
				</div>
			</a>
			<div class="video-overlay" v-else-if="block.video_block_type2 === '0'">
				<iframe width="100%" height="350px"
						v-if="block.video_block_video_type_2 === '1' && block.video_block_link2.indexOf('youtube')"
						:src="block.video_block_link2.replace('watch?v=', 'embed/') + '?mute=1&showinfo=0&controls=0&rel=0&autoplay=1'"
						frameborder="0"
						allow="autoplay; encrypted-media"
						hspace="0"
						vspace="0"
						allowtransparency="true"
						allowfullscreen="allowfullscreen"></iframe>
				<video v-if="block.video_block_video_type_2 === '0' && block.video_block_video2"
					   width="100%" height="100%"
					   muted playsinline autoplay loop>
					<source :src="block.video_block_video2">
				</video>
			</div>

			<a v-if="block.popup_video2 && block.video_block_type2 === '1'"
			   class="popupVideoLink"
			   data-fancybox
			   :data-cursor="block.video_cursor_2 === '0' || block.video_cursor_2 === '1' ? playText : ''"
			   :data-cursor-color="block.video_cursor_2 === '0' ? 'white' : 'black'"
			   :href="block.video_url2">
				<div class="video-overlay">
					<img :src="block.video_block_image2" alt="">
				</div>
			</a>
			<div class="video-overlay" v-else-if="block.video_block_type2 === '1'">
				<img :src="block.video_block_image2" alt="">
			</div>

			<span v-if="block.description"
				  class="Caption case-video-text">{{block.description}}</span>
		</div>
	</div>

</template>

<script>


  export default {
    name: "CaseDoubleVideo",
    props: ['block'],
    computed: {
      playText() {
        return this.$route.params.lang === 'ru' ? 'ВКЛ' : 'PLAY'
      },
      pauseText() {
        return this.$route.params.lang === 'ru' ? 'ВЫКЛ' : 'PAUSE'
      }
    },
  }
</script>
