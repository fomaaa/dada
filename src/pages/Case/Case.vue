<template>
	<div class="case"
		 style="height: 100%; width: 140%; z-index: 3; overflow: hidden; position: absolute; top: 0; left: 0;">
		<div class="case-for-overlay"
			 style="height: 100%; width: 100vw; z-index: 3; position: absolute; top: 0; left: 0;"
			 ref="mainScroll"
			 v-bar="{preventParentScroll: false, useScrollbarPseudo: false, overrideFloatingScrollbar: true}">
			<div class="case-page case-custom-scroll-js" id="container-scroll-js">
				<div class="case-overlay--purple"></div>
				<div class="case-content" id="case-content-js">
					<div class="case-section-first container-100vh">
						<logo-block></logo-block>
						<header class="header-mini header-mini-top">
							<header-mini></header-mini>
						</header>
						<div class="case-head-image-overlay">
							<a :href="headBlock.popup_video_link"
							   v-if="headBlock && headBlock.popup_video_link"
							   class="case-head-image"
							   data-fancybox
							   :data-cursor="headBlock.cursor_color === '0' || headBlock.cursor_color === '1' ? 'PLAY' : ''"
							   :data-cursor-color="headBlock.cursor_color === '0' ? 'white' : 'black'"
							   :style="{backgroundImage: 'url('+ headBlock.head_block_image +')'}">
								<video v-if="headBlock.head_block_video_type === '0'"
									   width="100%" height="100%"
									   muted playsinline autoplay loop>
									<source :src="headBlock.head_block_video">
								</video>
							</a>

              <div
                v-else-if="headBlock && headBlock.head_block_video_type === '0' && headBlock.head_block_video"
                class="case-head-image">
                <video v-if="headBlock.head_block_video_type === '0'"
                       width="100%" height="100%"
                       muted playsinline autoplay loop>
                  <source :src="headBlock.head_block_video">
                </video>
              </div>

							<div v-else-if="headBlock && !headBlock.popup_video_link"
								 class="case-head-image"
								 :style="{backgroundImage: 'url('+ headBlock.head_block_image +')'}"></div>

							<div v-else
								 class="case-head-image"
								 :style="{backgroundImage: 'url('+ caseData.preview +')'}"></div>
						</div>
						<div class="wrapper">
							<div class="case-head-text" style="pointer-events: none">
								<span class="MainLetterhead">{{caseData.title}}</span>
								<span class="Campaign">{{caseData.campaign}}</span>
							</div>
						</div>
					</div>
					<div class="container-case-content">
						<section class="case-section wrapper case-text-container"
								 v-for="block in blocks" v-if="block.type == '1'">
							<div class="case-text-content"
								 @click="clickGtm('click', 'fromCaseToWorks', 'byTag')">
								<div class="case-links clearfix">
                  <span class="NavigationLinks-wr" v-for="tag in caseData.tags" :key="tag.id"><router-link
						  :to="{name: 'WorksComponent'}" tag="a"
						  class="NavigationLinks">{{tag}}</router-link><span
						  class="place">,&nbsp;</span></span>
									<div class="SiteLink-wr" v-if="block.site_url">
                    <span class="site-link-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="9"
						   viewBox="0 0 18 9">
                          <g fill="#8200E6" fill-rule="evenodd">
                              <path
									  d="M7.412 4.198A3.2 3.2 0 0 0 4.198.983 3.2 3.2 0 0 0 .983 4.198a3.2 3.2 0 0 0 3.215 3.214 3.2 3.2 0 0 0 3.214-3.214M0 4.198A4.203 4.203 0 0 1 4.198 0a4.202 4.202 0 0 1 4.197 4.198 4.201 4.201 0 0 1-4.197 4.197A4.203 4.203 0 0 1 0 4.198"/>
                              <path d="M4.28 4.654h9.45v-.936H4.28z"/>
                              <path
									  d="M17.026 4.198A3.2 3.2 0 0 0 13.811.983a3.2 3.2 0 0 0-3.213 3.215 3.2 3.2 0 0 0 3.213 3.214 3.2 3.2 0 0 0 3.215-3.214m-7.412 0A4.202 4.202 0 0 1 13.811 0a4.202 4.202 0 0 1 4.198 4.198 4.202 4.202 0 0 1-4.198 4.197 4.202 4.202 0 0 1-4.197-4.197"/>
                          </g>
                      </svg>
                    </span>
										<a class="SiteLink" :href="block.site_url" target="_blank">{{block.site_url.replace('https://',
											'').replace('http://', '').replace('www.', '')}}</a>
									</div>
								</div>
								<case-lead :leadText="block.text"></case-lead>
								<case-text :textText="block.text2"></case-text>
							</div>
						</section>
						<section :class="['case-section',
                block.indent ? 'zero-offset-bottom': '',
                block.type == '8' ? 'case-image-gallery' : '',
                block.type == '7' ? 'wrapper case-medium-image-container' : '',
                block.type == '6' ? 'case-mini-images-container' : '',
                block.type == '5' ? 'case-big-image-container' : '',
                block.type == '4' ? 'case-video-container' : '',
                block.type == '9' ? 'case-video-container' : '',
                (block.type == '4' && !block.wide) ? 'case-video-container wrapper' : '',
                block.type == '2' || block.type == '3' ? 'wrapper case-text-container' : '',]"
								 v-for="(block, key) in blocks" v-if="blocks.length !== 0">
							<case-lead v-if="block.type == '2'" :leadText="block.text"></case-lead>
							<case-text v-if="block.type == '3'" :textText="block.text"></case-text>
							<case-video v-if="block.type == '4'" :block="block"></case-video>
							<case-img-big v-if="block.type == '5'" :imageBigUrl="block.image"
										  :imageBigThumbUrl="block.image_thumb"
										  :imageBigCaption="block.description"></case-img-big>
							<case-img-mini v-if="block.type == '6'"
										   :imageMiniThumbUrl="[block.image_thumb, block.image2_thumb]"
										   :imageMiniUrl="[block.image, block.image2]"
										   :imageMiniCaption="[block.description, block.description2]"></case-img-mini>
							<case-img-medium v-if="block.type == '7'"
											 :imageMediumThumbUrl="block.image_thumb"
											 :imageMediumUrl="block.image"
											 :imageMediumCaption="block.description"></case-img-medium>
							<case-gallery v-if="block.type == '8'"
										  :galleryArr="block.gallery"></case-gallery>
							<case-double-video
									v-if="block.type == '9'"
									:block="block">
							</case-double-video>
						</section>
						<div class="case-selector wrapper">
							<div class="case-selector-container case-selector-container-mb">
								<router-link v-scroll-to="{el: '#app', duration: 200}"
											 :to="{name: 'CaseComponent', params: {case : this.caseData.urlPrev}}"
											 tag="div"
											 class="case-selector-item selector-item-prev none-outline"
											 @click="clickGtm('click', 'fromCaseToPrevCase',tag.id)">
									<span class="selector-arrow">←</span>
									<span>{{textPrev}}</span>
									<span>{{textWork}}</span>
								</router-link>
								<router-link v-scroll-to="{el: '#app', duration: 200}"
											 :to="{name: 'CaseComponent', params: {case : this.caseData.urlNext}}"
											 tag="div"
											 class="case-selector-item selector-item-next none-outline"
											 @click="clickGtm('click', 'fromCaseToNextCase','')">
									<span>→</span>
									<span class="selector-arrow">{{textNext}}</span>
									<span>{{textWork}}</span>
								</router-link>
							</div>
							<div class="case-selector-container case-selector-container-pc">
								<router-link
										:to="{name: 'CaseComponent', params: {case : this.caseData.urlPrev}}"
										tag="div"
										class="case-selector-item selector-item-prev none-outline"
										@click="clickGtm('click', 'fromCaseToPrevCase',tag.id)">
									<div class="case-prev">
										<span class="selector-arrow">←</span>
										<span>{{textPrev}}</span>
										<span>{{textWork}}</span>
									</div>
									<div class="prev-info clearfix">
										<span class="prev-title">■ {{caseData.titlePrev}}</span><br>
										<span class="prev-campaign">{{caseData.campaignPrev}}</span>
									</div>
								</router-link>
								<router-link
										:to="{name: 'CaseComponent', params: {case : this.caseData.urlNext}}"
										tag="div"
										class="case-selector-item selector-item-next none-outline"
										@click="clickGtm('click', 'fromCaseToNextCase','')">
									<div class="case-next">
										<span class="selector-arrow">{{textNext}}</span>
										<span>{{textWork}}</span>
										<span>→</span>
									</div>
									<div class="next-info">
										<span class="next-title">{{caseData.titleNext}} ■</span><br>
										<span class="next-campaign">{{caseData.campaignNext}}</span>
									</div>
								</router-link>
							</div>
						</div>
					</div>
				</div>
				<header class="header-mini header-mini-bottom">
					<header-mini></header-mini>
				</header>
				<footer class="footer footer-black" style="z-index: 5;">
					<footer-block></footer-block>
				</footer>
			</div>
		</div>
	</div>
</template>

<script>
  import CaseText from '../../components/CaseLayouts/CaseText'
  import CaseLead from '../../components/CaseLayouts/CaseLead'
  import CaseVideo from '../../components/CaseLayouts/CaseVideo'
  import CaseDoubleVideo from '../../components/CaseLayouts/CaseDoubleVideo'
  import CaseImgBig from '../../components/CaseLayouts/CaseImgBig'
  import CaseImgMini from '../../components/CaseLayouts/CaseImgMini'
  import CaseImgMedium from '../../components/CaseLayouts/CaseImgMedium'
  import CaseGallery from '../../components/CaseLayouts/CaseGallery'

  export default {
    name: 'CaseComponent',
    components: {
      CaseText,
      CaseLead,
      CaseDoubleVideo,
      CaseVideo,
      CaseImgBig,
      CaseImgMini,
      CaseImgMedium,
      CaseGallery
    },
    data() {
      return {
        curUrl: '',
        window: {
          width: 0,
          height: 0
        },
        wideWidth: 1025,
        bodyDom: document.getElementsByTagName('body'),
        htmlDom: document.getElementsByTagName('html'),
        container100vh: '',
        fontGlobal: null,
        caseData: [],
        headBlock: [],
        blocks: [],
        textWork: (window.isru) ? 'работа' : 'work',
        textPrev: (window.isru) ? 'Предыдущая' : 'Previous',
        textNext: (window.isru) ? 'Следующая' : 'Next',
      }
    },
    watch: {
      $route: function (to, from) {
        this.$http.get('/api/' + this.$route.params.lang + '/' + this.$route.params.case).then(response => {
          this.caseData = response.data.cases;
          this.blocks = response.data.blocks;
          this.headBlock = response.data.headBlock;
        }, response => {
          // error callback
        });
      }
    },
    methods: {
      clickGtm: function (eventCategory, eventAction, eventLabel) {
        this.$gtm.trackEvent({
          event: 'gaEvent',
          category: eventCategory,
          action: eventAction,
          label: eventLabel,
        });
      },
      handleResize: function () {
        this.window.width = window.innerWidth;
        this.window.height = window.innerHeight;
        let isThis = this;
        if ((this.window.width >= this.wideWidth) && (this.window.width / this.window.height >= 2)) {
          if (this.bodyDom[0].style.fontSize !== '3.5vh') {
            this.bodyDom[0].style.fontSize = '3.5vh';
          }
        } else if ((this.window.width < this.wideWidth) && (this.window.width / this.window.height >= 0.64)) {
          if (this.bodyDom[0].style.fontSize !== '3.2vh') {
            this.bodyDom[0].style.fontSize = '3.2vh';
          }
        } else {
          this.bodyDom[0].style.fontSize = '';
        }

        this.fontGlobal = (1.8 * this.window.width / 100).toPrecision(5);
        if ((this.window.width >= this.wideWidth) && (this.window.width / this.window.height >= 2)) {
          this.fontGlobal = (3.5 * this.window.height / 100).toPrecision(5);
        }

        let topMenu = document.querySelectorAll('.header-mini-top');
        if (this.window.width >= this.wideWidth) {
          topMenu.forEach(function (item, index) {
            item.setAttribute('style', 'height: ' + Math.ceil(isThis.fontGlobal * 6.2) + 'px;');
          })
        } else {
          topMenu.forEach(function (item, index) {
            item.setAttribute('style', '');
          })
        }

        this.$root.$emit('scaleimg', this.fontGlobal);

      },
      safariResize: function () {
        // console.log('safariResize');

        if (this.window.width >= this.wideWidth) {
          let context = this;
          setTimeout(function () {
            context.container100vh[0].style.height = window.innerHeight + 'px';
          }, 100);
        } else {
          let context = this;
          setTimeout(function () {
            context.container100vh[0].style.height = '';
          }, 100);
        }

      },
    },
    beforeCreate() {
      console.log('beforeCreate');
      this.$http.get('/api/' + this.$route.params.lang + '/' + this.$route.params.case).then(response => {
        this.caseData = response.data.cases;
        this.blocks = response.data.blocks;
        this.headBlock = response.data.headBlock;
        this.curUrl = this.caseData.url;
      }, response => {

        // error callback
      });
    },
    created() {
      console.log('case-created');

      window.addEventListener('resize', this.handleResize);
    },
    beforeRouteLeave(to, from, next) {

      let scrollCase = document.getElementsByClassName('case-page');

      let wrScrollJsTop = scrollCase[0].scrollTop;
      if (wrScrollJsTop >= 1) {
        let start = Date.now();
        let timer = setInterval(function () {
          let timePassed = Date.now() - start;
          if (timePassed >= 200) {
            clearInterval(timer);
            return;
          }
          draw(timePassed);
        }, 20);

        function draw(timePassed) {
          scrollCase.scrollTo(0, wrScrollJsTop - (timePassed / (100 / wrScrollJsTop)));
        }

        setTimeout(function () {
          next();
        }, 190);
      } else {
        next();
      }
    },
    mounted() {
      console.log('case-mounted');
      this.handleResize();
      this.container100vh = document.getElementsByClassName('container-100vh');
      let md = new MobileDetect(window.navigator.userAgent);
      let isMobile = md.mobile();
      if (isMobile !== null) {
        this.safariResize();
        window.addEventListener('resize', this.safariResize);
      }

      let isThis = this;
      let customScrollJs = document.querySelector('.case-custom-scroll-js');
      // setTimeout(function () {
      //   isThis.$vuebar.refreshScrollbar(customScrollJs);
      // }, 1500);


    },
    updated() {
      console.log('case-updated');
    },
    destroyed() {
      console.log('case-destroyed');
      window.removeEventListener('resize', this.safariResize);
      window.removeEventListener('resize', this.handleResize);
    }
  }
</script>
