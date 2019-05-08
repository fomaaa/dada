<template>
<transition :name='transition' :duration='{enter: 600, leave: 500}'>
  <div class="agency clearfix">
    <div class="overlay-white-left"></div>
    <div class="overlay-white-right"></div>
    <div class="agencyScroll agency-custom-scroll-js" ref="agencyScrollPage"
         v-bar="{preventParentScroll: false, useScrollbarPseudo: false, overrideFloatingScrollbar: true}">
      <div class="agencyScroll-in clearfix container-agency-scroll-js" id="container-scroll-js"
           v-on:scroll="agencyScrollPage" ref="scrollWrapper">
        <div class="agency-page">
          <header class="header">
            <header-block></header-block>
          </header>
          <div class="menu-offset-agency-page"></div>
          <div class="agency-page-in">
            <div class="agency-content">
              <router-link :to="{name: 'WorksComponent'}" tag="div"
                           class="menu-works menu-item none-outline menu-transform"
                           v-show="$route.name == 'AgencyComponent'">
                <div class="menu-content menu-content-works" @click="clickGtm('click', 'fromAgencyToWork', '')">
                  <h2 class="menu-title">{{textWorks}}</h2>
                </div>
              </router-link>
              <section class="agency-content-block agency-intro-text first-block-js">
                <div class="intro-text-block-overlay">
                  <div class="intro-text-block">
                    <p v-html="intro_text_block"></p>
                  </div>
                </div>
              </section>
              <section class="agency-content-block agency-nav-block">
                <nav class="agency-nav">
                  <div class="agency-nav-overlay nav-container-js">
                    <div class="agency-nav-container">
                      <div class="agency-anchors">
                        <div class="agency-nav-anchor">
                          <div v-scroll-to="{el: '#services', offset: isOffset}" class="nav-item">
                            <h3>{{agency_nav1}}</h3>
                          </div>
                          <div v-scroll-to="{el: '#principle', offset: isOffset}" class="nav-item">
                            <h3>{{agency_nav2}}</h3>
                          </div>
                          <div v-scroll-to="{el: '#command', offset: isOffset}" class="nav-item">
                            <h3>{{agency_nav3}}</h3>
                          </div>
                          <div v-scroll-to="{el: '#contacts', offset: isOffset}" class="nav-item nav-text-point-js">
                            <h3>{{agency_nav4}}</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </nav>
                <div class="nav-bottom-point-js"
                     style="width: 100%; height: 1px; opacity: 0;"></div>
              </section>
              <section class="agency-content-block agency-animate-block">
                <div class="agency-animate">
                  <img class="agency-animate-img" src="../../../static/media/flag.png"
                       alt="agency-animate-img">
                  <video class="agency-animate-video" style="object-fit: cover;" width="100%" height="100%" muted
                         playsinline autoplay loop
                         poster="/static/media/flag.png">
                    <source src="/static/media/flag.mp4" type="video/mp4">
                    <source src="/static/media/flag.webm" type="video/webm">
                    <source src="/static/media/flag.ogg" type="video/ogg">
                  </video>
                  <img class="agency-animate-img-text" src="/static/img/agency-animate-img-text.svg"
                       alt="agency-animate-img-text">
                </div>
              </section>
              <section id="services" class="agency-content-block agency-services-block agency-content-block-transform">
                <div class="agency-block-overlay"></div>
                <div class="agency-block-in">
                  <div class="agency-paragraph-item">
                    <span class="agency-title-anim"><span class="agency-title">{{agency_title}}</span></span>
                    <div class="agency-list">
                      <ul>
                        <li class="agency-text">{{agencytext}}</li>
                        <li class="agency-text">{{agencytext2}}</li>
                        <li class="agency-text">{{agencytext3}}</li>
                        <li class="agency-text">{{agencytext4}}</li>
                        <li class="agency-text">{{agencytext5}}</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </section>
              <section id="principle"
                       class="agency-content-block agency-principle-block agency-content-block-transform">
                <div class="agency-block-overlay"></div>
                <div class="agency-block-in">
                  <div class="agency-paragraph-item">
                    <span class="agency-title">{{principle_agency_title}}</span>
                    <p class="agency-text">{{principle_agency_text}}</p>
                  </div>
                </div>
              </section>
              <section id="command" class="agency-content-block agency-command-block agency-content-block-transform">
                <div class="agency-block-overlay"></div>
                <div class="agency-block-in">
                  <span class="agency-title">{{command_agency_title}}</span>
                </div>
                <team :screenWidth='window.width'></team>
              </section>
              <section id="partners" class="agency-content-block agency-partners-block agency-content-block-transform">
                <div class="agency-block-overlay"></div>
                <div class="agency-block-in">
                  <span class="agency-title">{{partners_agency_title}}</span>
                </div>
                <img class="agency-clients" src="/static/img/clients.png" alt="clients">
              </section>
            </div>
            <footer id="contacts" class="footer footer-column">
              <footer-block></footer-block>
            </footer>
          </div>
        </div>
      </div>
    </div>
  </div>
</transition>

</template>


<script>
  import enableInlineVideo from 'iphone-inline-video';
  import Team from '../../components/Team/Team'

  let pointFixMenu, menuTransformTitleTopPoint, menuOffsetActivePageBottomPoint, firstBlockJsTopPoint,
    navTextPointJsTopPoint;
  let menuTransformHeight, menuContentActiveHeight, menuTitleActiveHeight, menuActiveHeight;
  let verticalPosition = 0;
  let verticalPositionPrev = 0;
  export default {
    name: 'AgencyComponent',
    data() {
      return {
        transition: 'agency',
        menuLogoTextAgency: null,
        menuLogoTextWorks: null,
        customScrollJs: null,
        isOffset: 0,
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
        containerScrollJs: '',
        blockNav: null,
        textWorks: (window.isru) ? 'Работы' : 'Works',
        intro_text_block: (window.isru) ? 'Вы — клиент, готовый к другим решениям. Мы\xa0—\xa0ДАДА. Вместе мы создаём, упаковываем и\xa0представляем новый опыт этому миру. <br> Делаем\xa0по-другому.' : 'You – kick-ass-cool client. We – DADA. Let’s collaborate to create, pack and deliver cutting edge experience to the world. Let’s do something completely different.',
        agency_title: (window.isru) ? 'Что мы делаем?' : 'What do we do?',
        agencytext: (window.isru) ? 'Креативный консалтинг' : 'Creative Consulting',
        agencytext2: (window.isru) ? 'Коммуникационная и бренд стратегия' : 'Communication & Brand Strategy',
        agencytext3: (window.isru) ? 'Брендинг и дизайн' : 'Branding & Design',
        agencytext4: (window.isru) ? 'Коммуникация и продвижение' : 'Communications & Promotion',
        agencytext5: (window.isru) ? 'Разработка продукта / UI/UX' : 'Product development / UI/UX',
        principle_agency_title: (window.isru) ? 'КАК МЫ ДЕЛАЕМ' : 'HOW WE DO',
        principle_agency_text: (window.isru) ? 'Мы сами себе беспощадные цензоры. Мы даем жизнь только тем проектам, которые нравятся нам. Мы делаем не как принято, а как будет работать. Мы делаем по-другому.' : 'We are the most strict judges of our works.We only release projects we love ourselves.We turn conventional industry patterns upside down to make things work. We do something completely different.',
        command_agency_title: (window.isru) ? 'Кто все это делает?' : 'Team',
        partners_agency_title: (window.isru) ? 'Для кого мы \x0A' + 'это делаем?' : 'Clients',
        agency_nav1: (window.isru) ? 'Услуги' : 'Services',
        agency_nav2: (window.isru) ? 'Принцип' : 'Principle',
        agency_nav3: (window.isru) ? 'Команда' : 'Team',
        agency_nav4: (window.isru) ? 'Контакты' : 'Contacts'
      }
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
      agencyScrollPage: function () {
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
          this.blockNav = document.querySelector('.agency-nav');
          let wrNav = document.querySelector('.agency-nav-container');
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
          verticalPosition = document.querySelector('.agencyScroll-in').scrollTop;

          let wayScroll = Math.abs(verticalPosition - verticalPositionPrev);

          //fix nav and header menu
          //-------------------------------------------------------------
          this.navBottomPointTopPoint = this.navBottomPoint.getClientRects()[0].top;
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
      agencyScrollPageReset: function () {
        if (this.menuOffsetActivePage !== null && this.menuOffsetActivePage !== undefined) {
          this.menuOffsetActivePage.setAttribute('style', '');
        }
        if (this.menuActive !== null && this.menuActive !== undefined) {
          this.menuActive.setAttribute('style', '');
        }
        if (this.MainContainer !== null && this.MainContainer !== undefined) {
          this.MainContainer.setAttribute('style', '');
        }
        if (this.navContainer !== null && this.navContainer !== undefined) {
          this.navContainer.setAttribute('style', '');
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
      agencyResize: function () {
        this.window.width = window.innerWidth;
        this.window.height = window.innerHeight;

        this.menuFixedMax = this.menuFixed.offsetHeight;

        this.fontGlobal = (1.8 * this.window.width / 100).toPrecision(5);
        if ((this.window.width >= this.wideWidth) && (this.window.width / this.window.height >= 2)) {
          this.fontGlobal = (3.5 * this.window.height / 100).toPrecision(5);
        }
        this.isOffset = 7.67 * -this.fontGlobal;

        if (this.window.width < this.wideWidth) {
          if (this.isOffset !== 0) {
            this.isOffset = 0;
          }
          this.agencyScrollPageReset();
          this.isScrollTopPage = false;
        } else {
          if (!this.isScrollTopPage) {
            this.containerScrollJs.scrollTo(0, 0);
          }
          this.isScrollTopPage = true;
        }
      }
    },
    beforeRouteLeave(to, from, next) {
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
    },
    mounted() {
      console.log('agency-mounted');
      let video = document.querySelector('video');
      enableInlineVideo(video, {
        iPad: true
      });
      video.addEventListener('touchstart', function () {
        video.play();
      });
      this.containerScrollJs = document.getElementsByClassName('container-agency-scroll-js')[0];
      this.agencyResize();
      let customScrollJs = document.querySelector('.agency-custom-scroll-js');
      // setTimeout(function () {
      //   isThis.$vuebar.refreshScrollbar(customScrollJs);
      // }, 1500);

      setTimeout(() => {
        this.menuFixed = document.querySelector('.header-not-main .menu-fixed');
        this.agencyResize();
      }, 300);
    },
    beforeCreate() {
      this.customScrollJs = document.querySelector('.main-custom-scroll-js');
    },
    created() {
      console.log('agency-created');
      // this.$vuebar.destroyScrollbar(this.customScrollJs);
      window.addEventListener('resize', this.agencyResize);
    },
    updated() {
      console.log('agency-updated');
    },
    destroyed() {
      console.log('agency-destroyed');
      let isThis = this;

      setTimeout(function () {
        isThis.agencyScrollPageReset();
      }, 500);
      window.removeEventListener('resize', this.agencyResize);
    },
    components: {
      Team
    }
  }
</script>

<style lang='scss' scoped>
  .agency {
    width: 100%; position: absolute; top: 0; z-index: 7; background-color: transparent
  }
  .agency-page-in {
    height: 100%; width: 100%;
  }
  .agency-page {
    background-color: transparent;
  }
</style>
