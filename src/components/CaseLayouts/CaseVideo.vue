<template>
	<div class="case-video" style="width: 100%;">
		<div class="case-video-item">
			<div class="video-overlay">
				<div class="video__bg"
					 :style="{ 'background-image': 'url(' + block.image + ')' }"
				></div>
				<a v-if="block.popup"
				   :href="block.popup_link"
				   data-fancybox
				   data-cursor="PLAY"
				   data-cursor-color="black"
				   class="video__popup"></a>
				<!--        <iframe width="100%" height="350px" :src="videoUrl.replace('watch?v=', '/embed/')" frameborder="0"-->
				<!--                allow="autoplay; encrypted-media" hspace="0" vspace="0" allowtransparency="true"-->
				<!--                allowfullscreen="allowfullscreen"></iframe>-->
			</div>
			<span v-if="block.description"
				  class="Caption case-video-text">{{block.description}}</span>
		</div>
	</div>
</template>

<script>
  export default {
    name: "CaseVideo",
    props: ['block']
  }
</script>
