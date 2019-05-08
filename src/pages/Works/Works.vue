<template>
<transition :name='transition' :duration='{enter: 600, leave: 500}'>
  <div class="works"
       style= "width: 100%; position: absolute; top: 0; z-index: 7; background-color: transparent">
    <div class="overlay-white-left"></div>
    <div class="overlay-white-right"></div>
    <div class="worksScroll works-custom-scroll-js" ref="worksScrollPage"
         v-bar="{preventParentScroll: false, useScrollbarPseudo: false, overrideFloatingScrollbar: true}">
      <div class="worksScroll-in clearfix container-works-scroll-js" id="perfect-scroll-wrapper" ref="scrollWrapper"
           infinite-wrapper v-on:scroll="worksScrollPage">
        <div class="works-page">
          <header class="header">
            <header-block></header-block>
          </header>
          <div class="menu-offset-works-page"></div>
          <div class="works-page-in" style="height: 100%; width: 100%;">
            <div class="works-content">
              <router-link :to="{name: 'AgencyComponent'}" tag="div"
                           class="menu-agency menu-item none-outline menu-transform"
                           v-show="$route.name == 'WorksComponent'">
                <div @click="clickGtm('click', 'fromWorksToAgency', '')" class="menu-content menu-content-agency">
                  <h2 class="menu-title">{{textAgency}}</h2>
                </div>
              </router-link>
              <section class="works-content-block works-intro-text first-block-js">
                <div class="intro-text-block-overlay">
                  <div class="intro-text-block">{{works_intro_text}}</div>
                </div>
              </section>
              <section class="works-content-block works-projects">
                <nav class="works-projects-nav">
                  <div class="projects-nav-overlay nav-container-js">
                    <div class="works-projects-nav-container">
                      <div class="works-projects-filtration">
                      <span class="projects-filtration-item filtration-item-creative"
                            :class="{ active: tabSelect == 'creative' }"
                            @click="tabSelect = 'creative'; tagsTake()"><h3>Creative</h3></span>
                        <span class="projects-filtration-item filtration-item-branding"
                              :class="{ active: tabSelect == 'branding' }"
                              @click="tabSelect = 'branding'; tagsTake()"><h3>Branding</h3></span>
                        <span class="projects-filtration-item filtration-item-digital"
                              :class="{ active: tabSelect == 'digital' }"
                              @click="tabSelect = 'digital'; tagsTake()"><h3>Digital</h3></span>
                        <span class="projects-filtration-item filtration-item-video"
                              :class="{ active: tabSelect == 'video' }"
                              @click="tabSelect = 'video'; tagsTake()"><h3>Video</h3></span>
                        <span class="projects-filtration-item filtration-item-all"
                              :class="{ active: tabSelect == 'all' }"
                              @click="tabSelect = 'all'; tagsTake()"><h3
                          class="nav-text-point-js">All</h3></span>
                      </div>
                    </div>
                  </div>
                </nav>
                <div class="nav-bottom-point-js"
                     style="width: 100%; height: 1px; opacity: 0;"></div>
                <div class="works-projects-container">
                  <div class="projects-overlay">
                    <case-preview v-for="(card, index) in cards" :fontGlobalMy='fontGlobal'
                         :screenWidth='window.width'
                         :screenHeight='window.height' :cardsTrigger="cardsPreviewOverlayTrigger" :index="index"
                         :preview="card.preview" :title="card.title"
                         :campaign="card.campaign" :url="card.url" :key='index'>
                    </case-preview>
                  </div>
                </div>
                <infinite-loading @distance="1" @infinite="infiniteCards" ref="infiniteLoading"></infinite-loading>
              </section>
            </div>
          </div>
          <footer class="footer footer-column">
            <footer-block></footer-block>
          </footer>
        </div>
      </div>
    </div>
  </div>
</transition>
</template>


<script>
  import CasePreview from '../../components/CasePreview/CasePreview'

  let menuTransformHeight;
  let menuTransformTitleTopPoint;
  let menuOffsetActivePageBottomPoint;
  let firstBlockJsTopPoint;
  let navTextPointJsTopPoint;
  let pointFixMenu;
  let menuContentActiveHeight;
  let menuTitleActiveHeight;
  let menuActiveHeight;
  let verticalPosition = 0;
  let verticalPositionPrev = 0;
  export default {
    name: 'WorksComponent',
    data() {
      return {
        transition: 'works',
        cardsPreviewOverlayTrigger: true,
        cardsWait: 0,
        customScrollJs: null,
        page: 1,
        hasMoreCards: true,
        istoCase: false,
        tabSelect: 'all',
        nameIsTags: 'all',
        tabActive: 'all',
        window: {
          width: 0,
          height: 0
        },
        wideWidth: 1025,
        menuTransform: null,
        menuOffsetActivePage: null,
        firstBlock: null,
        navTextPoint: null,
        navContainer: null,
        navBottomPoint: null,
        menuFixed: '',
        menuFixedMax: null,
        navBottomPointTopPoint: null,
        MainContainer: null,
        menuActive: null,
        menuContentActive: null,
        menuTransformTitle: null,
        menuTitleActive: null,
        fontGlobal: null,
        isScrollTopPage: false,
        containerScrollJs: null,
        blockNav: null,
        cards: [],
        textAgency: (window.isru) ? 'Агентство' : 'Agency',
        works_intro_text: (window.isru) ? 'Наши работы, которые нам нравятся' : 'Our works we really like',
      }
    },
    components: {
      'case-preview': CasePreview
    },

    computed: {
      wideBreakpoint () {
        return this.window.width >= this.wideWidth
      },
      // transitionDuration () {
      //   if (this.wideBreakpoint) {
      //     return {enter: 600, leave: 500}
      //   }
      //   return 0
      // }
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
      infiniteCards: function ($state) {
        // console.log('inifite');
        if (this.hasMoreCards) {
          // console.log('infiniteCards');
          let vm = this;
          this.$http.get('/api/' + this.$route.params.lang + '/' + this.nameIsTags + '/works?page=' + this.page).then(response => {
            if (response.data.length < 4) {
              this.hasMoreCards = false;
              $state.complete();
            }
            response.data.forEach(function (value, key) {
              vm.cards.push(value);
            });
            $state.loaded();
            console.log('this.page', this.page);
            if (this.page == 2 && this.cardsWait == 1) {
              this.cardsPreviewOverlayTrigger = true;
              this.cardsWait = 0;
            } else {
              this.cardsPreviewOverlayTrigger = false;
            }

          }, response => {
            // error callback
          });
          this.page += 1;
        }


      },
      tagsTake: function () {
        this.hasMoreCards = true;
        this.page = 1;

        if (this.tabSelect === 'all') {
          this.nameIsTags = null;
        } else {
          this.nameIsTags = this.tabSelect;
        }
        this.$refs.infiniteLoading.stateChanger.reset();
        this.cards = [];
      },
      worksScrollPage: function () {
        if (this.$route.name !== 'MainComponent' && this.window.width >= this.wideWidth) {
          this.MainContainer = document.getElementsByClassName('main-container-not-main')[0];
          this.menuTitleActive = document.querySelector('.header-not-main .router-link-active .menu-title');
          this.menuContentActive = document.querySelector('.header-not-main .router-link-active .menu-content');
          this.menuTransformTitle = document.querySelector('.menu-transform .menu-title');
          this.menuTransform = document.getElementsByClassName('menu-transform')[0];
          this.menuOffsetActivePage = document.querySelector('.router-link-active .menu-offset');
          this.firstBlock = document.getElementsByClassName('first-block-js')[0];
          this.navTextPoint = document.getElementsByClassName('nav-text-point-js')[0];
          this.navContainer = document.getElementsByClassName('nav-container-js')[0];
          this.menuFixed = document.getElementsByClassName('menu-fixed')[0];
          this.navBottomPoint = document.getElementsByClassName('nav-bottom-point-js')[0];
          this.menuActive = document.querySelector('.header-not-main .router-link-active.menu-item');
          this.blockNav = document.querySelector('.works-projects-nav');
          let wrNav = document.querySelector('.works-projects-container');
          navTextPointJsTopPoint = this.navTextPoint.getClientRects()[0].top;
          menuTransformTitleTopPoint = this.menuTransformTitle.getClientRects()[0].top;

          //fix mini menu
          //-------------------------------------------------------------
          menuTransformHeight = this.menuTransform.offsetHeight;
          menuTitleActiveHeight = this.menuTitleActive.offsetHeight;
          menuContentActiveHeight = this.menuContentActive.offsetHeight;
          menuActiveHeight = this.menuActive.offsetHeight;
          menuOffsetActivePageBottomPoint = this.menuOffsetActivePage.getClientRects()[0].bottom;
          firstBlockJsTopPoint = this.firstBlock.getClientRects()[0].top;
          pointFixMenu = firstBlockJsTopPoint + menuTransformHeight;
          if (pointFixMenu <= menuOffsetActivePageBottomPoint) {
            if (!this.menuTransform.classList.contains('menu-transform-fixed')) {
              this.menuTransform.classList.add('menu-transform-fixed');
            }
          } else {
            if (this.menuTransform.classList.contains('menu-transform-fixed')) {
              this.menuTransform.classList.remove('menu-transform-fixed');
            }
          }
          //-------------------------------------------------------------

          verticalPositionPrev = verticalPosition;
          verticalPosition = document.querySelector('.worksScroll-in').scrollTop;

          let wayScroll = Math.abs(verticalPosition - verticalPositionPrev);

          //fix nav and header menu
          //-------------------------------------------------------------
          this.navBottomPointTopPoint = wrNav.getClientRects()[0].top;
          // console.log('this.navBottomPointTopPoint', this.navBottomPointTopPoint);
          // console.log('this.menuFixedMax', this.menuFixedMax);
          let wayBoost = ((this.navBottomPointTopPoint - menuContentActiveHeight) + (menuTitleActiveHeight * 0.37 / 2)).toFixed(2);
          let wayForStop;

          if (this.navBottomPointTopPoint <= this.menuFixedMax) {
            if (!this.navContainer.classList.contains('nav-fixed')) {
              this.navContainer.classList.add('nav-fixed');
            }
          } else {
            if (this.navContainer.classList.contains('nav-fixed')) {
              this.blockNav.setAttribute('style', '');
              this.navContainer.classList.remove('nav-fixed');
            }
          }

          wayForStop = menuTransformTitleTopPoint - wayBoost;
          let wayForStopEm = wayForStop / this.fontGlobal;
          let navBottomPointTopPointEm = (this.navBottomPointTopPoint / this.fontGlobal).toFixed(2);

          if (this.navBottomPointTopPoint <= this.menuFixedMax) {

            if (wayBoost >= menuTransformTitleTopPoint) {
              this.menuOffsetActivePage.setAttribute('style', 'height: calc(' + navBottomPointTopPointEm + 'em - 1em * 0.3 * 2 - 1em * 5.2);');
              this.menuActive.setAttribute('style', 'height: calc(' + navBottomPointTopPointEm + 'em);');
              this.MainContainer.setAttribute('style', 'height: calc(100% - ' + navBottomPointTopPointEm + 'em); top: auto; bottom: 0;');
              this.navContainer.setAttribute('style', 'height: calc(' + navBottomPointTopPointEm + 'em);');
              this.blockNav.setAttribute('style', 'margin-top: -1px;');
            }
            else if (wayBoost < menuTransformTitleTopPoint && wayForStop <= wayScroll) {
              this.menuOffsetActivePage.setAttribute('style', 'height: calc(' + navBottomPointTopPointEm + 'em - 1em * 0.3 * 2 - 1em * 5.2 + ' + wayForStopEm + 'em);');
              this.menuActive.setAttribute('style', 'height: calc(' + navBottomPointTopPointEm + 'em + ' + wayForStopEm + 'em);');
              this.MainContainer.setAttribute('style', 'height: calc(100% - ' + navBottomPointTopPointEm + 'em - ' + wayForStopEm + 'em); top: auto; bottom: 0;');
              this.navContainer.setAttribute('style', 'height: calc(' + navBottomPointTopPointEm + 'em + ' + wayForStopEm + 'em);');
              this.blockNav.setAttribute('style', 'margin-top: -1px;');
            }
          } else {
            this.menuOffsetActivePage.setAttribute('style', '');
            this.menuActive.setAttribute('style', '');
            this.MainContainer.setAttribute('style', '');
            this.navContainer.setAttribute('style', '');
            this.blockNav.setAttribute('style', '');
          }
          //-------------------------------------------------------------
        }
      },
      worksScrollPageReset: function () {
        if (this.menuOffsetActivePage !== null && this.menuOffsetActivePage !== undefined) {
          this.menuOffsetActivePage.setAttribute('style', 'height: ;');
        }
        if (this.menuActive !== null && this.menuActive !== undefined) {
          this.menuActive.setAttribute('style', 'height: ;');
        }
        if (this.MainContainer !== null && this.MainContainer !== undefined) {
          this.MainContainer.setAttribute('style', 'height: ;');
        }
        if (this.navContainer !== null && this.navContainer !== undefined) {
          this.navContainer.setAttribute('style', 'height: ;');
        }
        if (this.menuTransform !== null && this.menuTransform !== undefined) {
          if (this.menuTransform.classList.contains('menu-transform-fixed')) {
            this.menuTransform.classList.remove('menu-transform-fixed');
          }
        }
        if (this.navContainer !== null && this.navContainer !== undefined) {
          if (this.navContainer.classList.contains('nav-fixed')) {
            this.navContainer.classList.remove('nav-fixed');
          }
        }
        if (this.blockNav !== null && this.blockNav !== undefined) {
          this.blockNav.setAttribute('style', '');
        }
      },
      worksResize: function () {
        this.window.width = window.innerWidth;
        this.window.height = window.innerHeight;

        this.menuFixedMax = this.menuFixed.offsetHeight;

        this.fontGlobal = (1.8 * this.window.width / 100).toPrecision(5);
        if ((this.window.width >= this.wideWidth) && (this.window.width / this.window.height >= 2)) {
          this.fontGlobal = (3.5 * this.window.height / 100).toPrecision(5);
        }
        if (this.window.width < this.wideWidth) {
          this.worksScrollPageReset();
          this.isScrollTopPage = false;
        } else {
          if (!this.isScrollTopPage) {
            this.containerScrollJs.scrollTo(0, 0);
          }
          this.isScrollTopPage = true;
        }
      },
    },
    beforeCreate() {
      console.log('works-beforeCreate');
      this.$root.$emit('transitionWorks', 'main2works');

      this.customScrollJs = document.querySelector('.main-custom-scroll-js');
    },
    created() {
      console.log('works-created');
      // this.$vuebar.destroyScrollbar(this.customScrollJs);
      window.addEventListener('resize', this.worksResize);

    },
    beforeRouteLeave(to, from, next) {
      const toDepth = to.path.split('/');
      if(!/(agency|works)/.test(toDepth[2]) && toDepth[2]) {
        this.transition = ''
        next()
      }else {
        let scrollCase = this.$refs.scrollWrapper;

        let wrScrollJsTop = scrollCase.scrollTop;
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
        }
        else {
          next();
        }
      }
    },
    mounted() {
      console.log('works-mounted');
      this.cardsWait += 1;
      this.$root.$on('cardsTriggerRes', (status) => {
        this.cardsPreviewOverlayTrigger = status;
      });

      this.$root.$on('scaleimg', (status) => {
        this.fontGlobal = status;
      });

      this.containerScrollJs = document.querySelector('.container-works-scroll-js');
      let isThis = this;
      let customScrollJs = document.querySelector('.works-custom-scroll-js');
      setTimeout(function () {

        isThis.menuFixed = document.querySelector('.header-not-main .menu-fixed');
        isThis.worksResize();
      }, 300);
    },
    beforeDestroy() {

      // this.$root.$on('goToCard', () => {
      //   this.istoCase = true;
      // });
      this.$on('goToCard', () => {
        this.istoCase = true;
      });
    },
    destroyed() {
      console.log('works-destroyed');

      let isThis = this;
      this.istoCase = true;
      if (this.istoCase) {
        setTimeout(function () {
          isThis.worksScrollPageReset();
        }, 500);
      } else {
        this.worksScrollPageReset();
      }
      window.removeEventListener('resize', this.worksResize);
    }
  }
</script>
