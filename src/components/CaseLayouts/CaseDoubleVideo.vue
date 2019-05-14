<template>
	<div class="case-video case-double-video" style="width: 100%;">
		<div class="case-video-item" style="background-color: red;">
			<div class="video-overlay" v-if="block.video_block_type1 === '0'">
				<iframe width="100%" height="350px"
						v-if="block.video_block_video_type_1 === '1'"
						:src="block.video_block_link1.replace('watch?v=', '/embed/')"
						frameborder="0"
						allow="autoplay; encrypted-media"
						hspace="0" vspace="0"
						allowtransparency="true"
						allowfullscreen="allowfullscreen"></iframe>

				<video v-if="block.video_block_video_type_1 === '0' && block.video_block_video1"
					   width="100%" height="100%"
					   muted playsinline autoplay loop>
					<source :src="block.video_block_video1">
				</video>
			</div>



			<div class="video-overlay" v-if="block.video_block_type1 === '1'">
				<img :src="block.video_block_image1" alt="">
			</div>
			<span v-if="block.description"
				  class="Caption case-video-text">{{block.description}}</span>
		</div>

		<div class="case-video-item" style="background-color: red;">
			<div class="video-overlay" v-if="block.video_block_type2 === '0'">
				<iframe width="100%" height="350px"
						v-if="block.video_block_video_type_2 === '1'"
						:src="block.video_block_link2.replace('watch?v=', '/embed/')"
						frameborder="0"
						allow="autoplay; encrypted-media"
						hspace="0" vspace="0"
						allowtransparency="true"
						allowfullscreen="allowfullscreen"></iframe>

				<video v-if="block.video_block_video_type_2 === '0' && block.video_block_video2"
					   width="100%" height="100%"
					   muted playsinline autoplay loop>
					<source :src="block.video_block_video2">
				</video>
			</div>
			<div class="video-overlay" v-if="block.video_block_type2 === '1'">
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
    props: ['block']
  }
</script>
