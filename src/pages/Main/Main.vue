<template>
  <div style="height: 100%; width: 100%; z-index: 1; position: absolute;
	top: 0;
	left: 0;">
    <div class="scroll-container" style="position:relative; z-index: 2;">
      <div class="overlay-white-left"></div>
      <div class="overlay-white-right"></div>
      <div class="main-custom-scroll-js" style="height: 100%; width: 100%; z-index: 3;" ref="mainScroll"
           v-bar="{preventParentScroll: false, useScrollbarPseudo: false, overrideFloatingScrollbar: true}">
        <div class="scroll main-scroll-flex" style="z-index: 4;">
          <div class="container-100vh" style="z-index: 5;">
            <header class="header header-main"
                    :class="{'header-not-main': $route.name === 'WorksComponent' || $route.name === 'AgencyComponent'}">
              <header-block></header-block>
            </header>
            <transition name="show-cookie">
              <div v-show="isCookieShow && isCookies !== '1' && $route.name == 'MainComponent'"
                   :class="['cookie-block', isCookieInfoShow ? 'cookie-show-info': '', isCookieDelTransition ? 'cookie-del-transition' : '']">
                <div class="cookie-overlay"></div>
                <div class="closeWrapper" @click="cookieClose()">
                  <span class="close"></span>
                </div>
                <div class="cookie-first">
                  <span>Сайт использует файлы cookie.</span>
                  <transition name="cookie-fade">
                    <div class="cookie-info" v-show="isCookieInfoShow">
                      <p>
                        Они позволяют узнавать вас и&nbsp;получать информацию о&nbsp;вашем пользовательском опыте. Это
                        нужно, чтобы улучшать сайт. Посещая страницы сайта и&nbsp;предоставляя свои данные, вы&nbsp;позволяете
                        нам предоставлять их&nbsp;сторонним партнерам. Если согласны, продолжайте пользоваться сайтом.
                        Если нет&nbsp;&mdash; установите специальные настройки в&nbsp;браузере или обратитесь в&nbsp;техподдержку.
                      </p>
                      <span class="cookie-explicitly" @click="cookieClose()">Понятно</span>
                    </div>
                  </transition>
                  <span class="cookie-more-info" @click="cookieInfoShow()">Что это значит?</span>
                </div>
              </div>
            </transition>
            <div class="main" style="z-index: -1;"
                 :class="{'main-not-main': $route.name === 'WorksComponent' || $route.name === 'AgencyComponent'}">
              <div class="main-container"
                   :class="{'main-container-not-main': $route.name !== 'MainComponent'}">
                <canvas id="canvas" resize ref="canvasik" style="z-index: 5;"></canvas>
                <div class="chess-board-container">
                  <div class="chess-board-items chess-board-items-mobile">
                    <div id="00" class="chess-item chess-item-black"></div>
                    <div id="01" class="chess-item"></div>
                    <div id="02" class="chess-item chess-item-black"></div>
                    <div id="03" class="chess-item"></div>
                    <div id="04" class="chess-item"></div>
                    <div id="05" class="chess-item chess-item-black"></div>
                    <div id="06" class="chess-item"></div>
                    <div id="07" class="chess-item chess-item-black"></div>
                    <div id="08" class="chess-item chess-item-black"></div>
                    <div id="09" class="chess-item"></div>
                    <div id="010" class="chess-item chess-item-black"></div>
                    <div id="011" class="chess-item"></div>
                    <div id="012" class="chess-item"></div>
                    <div id="013" class="chess-item chess-item-black"></div>
                    <div id="014" class="chess-item"></div>
                    <div id="015" class="chess-item chess-item-black"></div>
                    <div id="016" class="chess-item chess-item-black add-chess-item"></div>
                    <div id="017" class="chess-item add-chess-item"></div>
                    <div id="018" class="chess-item chess-item-black add-chess-item"></div>
                    <div id="019" class="chess-item add-chess-item"></div>
                  </div>
                  <div class="chess-board-items chess-board-items-desktop" id="transformBoard">
                    <div id="0" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="1" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="2" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="3" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="4" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="5" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="6" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="7" class="chess-item chess-item-black indexMax">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="8" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="9" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="10" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="11" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="12" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="13" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="14" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="15" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="16" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="17" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="18" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="19" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="20" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="21" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="22" class="chess-item indexMax">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="23" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="24" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="25" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="26" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="27" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="28" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="29" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="30" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="31" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="32" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="33" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="34" class="chess-item">
                      <div class="chess-item-color"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-purple"></div>
                    </div>
                    <div id="35" class="chess-item chess-item-black">
                      <div class="chess-item-color"></div>
                      <div class="item-in-white"></div>
                      <div class="item-in-black"></div>
                      <div class="item-in-purple"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <router-view></router-view>
          </div>
          <footer v-if="$route.name == 'MainComponent'" class="footer footer-black" style="z-index: 5;">
            <footer-block></footer-block>
          </footer>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  let boardItemsMobile;

  export default {
    name: 'MainComponent',
    data() {
      return {
        init: false,
        isCookies: '',
        isCookieShow: false,
        isCookieInfoShow: false,
        isCookieDelTransition: false,
        window: {
          width: 0,
          height: 0
        },
        wideWidth: 1025,
        isWorksScroll: false,
        isAgencyScroll: false,
        bodyDom: document.getElementsByTagName('body'),
        htmlDom: document.getElementsByTagName('html'),
        container100vh: '',
        isAnimateFlag: false,
        isMainPage: true,
        intervalID: '',
        path: '',
        newLayer: '',
        eventMouseChain: '',
        setIntervalTime: 2000,

        //for animate
        menuLogoTextAgency: null,
        menuLogoTextWorks: null,

      }
    },
    watch: {
      '$route'(to, from) {
      }
    },

    methods: {
      cookieClose: function () {
        this.isCookieShow = false;
        this.isCookieDelTransition = false;
        this.$cookie.set('has_cookies', '1');
      },
      cookieInfoShow: function () {
        this.isCookieInfoShow = true;
        var isThis = this;

        setTimeout(function () {
          isThis.isCookieDelTransition = true;
        }, 500);
      },
      onClickGtm: function () {
        this.$gtm.trackEvent({
          event: null, // Event type [default = 'interaction'] (Optional)
          category: 'Calculator',
          action: 'click',
          label: 'Home page SIP calculator',
          value: 5000,
          noninteraction: false // Optional
        });
      },
      add: function () {
        if (!this.init) {
          paper.setup(this.$refs.canvasik);
          this.init = true;
        }

        let points = 40;
        let length = 35;
        let isThis = this;
        this.path = new paper.Path();
        this.path.strokeColor = 'rgba(130, 0, 230, 0.99)';
        this.path.strokeCap = 'round';
        this.path.strokeWidth = 20 * this.window.width / 1025;
        let tool = new paper.Tool();
        tool.activate();
        this.eventMouseChain = function (event) {
          // console.log('this.eventMouseChain');
          isThis.path.firstSegment.point = event.point;
          for (let i = 0; i < points - 1; i++) {
            let segment = isThis.path.segments[i];
            let nextSegment = segment.next;
            let vector = segment.point.subtract(nextSegment.point);
            vector.length = length;
            nextSegment.point = segment.point.subtract(vector);
          }
          isThis.path.smooth({type: 'continuous'});
        };

        let start = [500, 500];

        for (let i = 0; i < points; i++) {
          this.path.add(start + new Point(i * length, 2 * length));
        }
        this.newLayer = new Layer({
          children: [this.path]
        });
        this.newLayer.activate();
        tool.on('mousemove', function (event) {
          isThis.eventMouseChain(event);
        });

        paper.view.onResize = function (event) {
          isThis.path.strokeWidth = 20 * isThis.window.width / 1025;
          isThis.stopStartChain();
        };
      },
      getRandomNew: function (setIntervalTime = 2000) {

        let isThis = this;
        let countTransform = 0;
        let countPurpleColor = 0;
        let minCountPurpleColor = 0;
        let maxCountPurpleColor = 5;
        let maxSetIntervalTime = 10000;
        let minSetIntervalTime = 7000;
        let maxCountTransform = 8;
        let minCountTransform = 3;
        let maxCountBlock = 35;
        let axisTransform = 0;
        let colorActive = '';
        let colorOut = '';
        let colorRandom = 0;

        let blocks = document.querySelectorAll('#transformBoard .chess-item');

        // this.intervalID = setInterval(function () {
        this.intervalID = setTimeout(() => {

          //Случайным образом задаем кол-во одновременных обменов 3~8
          countTransform = Math.floor(Math.random() * (maxCountTransform - minCountTransform + 1)) + minCountTransform;

          //Случайным образом выбираем неповторяющиеся блоки для трансформации 0~35 (по индексу)
          let numReserve = [];

          while (numReserve.length < countTransform) {
            let randomNumber = Math.ceil(Math.random() * maxCountBlock);
            let found = false;
            for (let i = 0; i < numReserve.length; i++) {
              if (numReserve[i] == randomNumber) {
                found = true;
                break;
              }
            }
            if (!found) {
              numReserve[numReserve.length] = randomNumber;
            }
          }

          let numColorActive = [];
          let numColorOut = [];

          numReserve.forEach(function (item, i) {
            // console.log('item', item);

            //Случайным образом задаем ось перемещения и перемещаем
            axisTransform = Math.floor(Math.random() * 4) + 1;

            // console.log('colorRandom', colorRandom);

            //Узнаем какой цвет нам добавить
            if (blocks[item].classList.contains('chess-item-black')) {
              if (blocks[item].classList.contains('index-active-black')) {
                countPurpleColor = Math.floor(Math.random() * (maxCountPurpleColor - minCountPurpleColor + 1)) + minCountPurpleColor;
                if (countPurpleColor == 1) {
                  colorActive = 'purple';
                } else {
                  colorActive = 'white';
                }
                numColorActive.push(colorActive);
              }
              else if (blocks[item].classList.contains('index-active-white')) {
                countPurpleColor = Math.floor(Math.random() * (maxCountPurpleColor - minCountPurpleColor + 1)) + minCountPurpleColor;
                if (countPurpleColor == 1) {
                  colorActive = 'purple';
                } else {
                  colorActive = 'black';
                }
                numColorActive.push(colorActive);
              }
              else if (blocks[item].classList.contains('index-active-purple')) {
                colorRandom = Math.floor(Math.random() * 2) + 1;
                if (colorRandom == 1) {
                  colorActive = 'black';
                } else {
                  colorActive = 'white';
                }
                numColorActive.push(colorActive);
              }
              else {
                countPurpleColor = Math.floor(Math.random() * (maxCountPurpleColor - minCountPurpleColor + 1)) + minCountPurpleColor;
                if (countPurpleColor == 1) {
                  colorActive = 'purple';
                } else {
                  colorActive = 'white';
                }
                numColorActive.push(colorActive);
              }
            }
            else {
              if (blocks[item].classList.contains('index-active-black')) {
                countPurpleColor = Math.floor(Math.random() * (maxCountPurpleColor - minCountPurpleColor + 1)) + minCountPurpleColor;
                if (countPurpleColor == 1) {
                  colorActive = 'purple';
                } else {
                  colorActive = 'white';
                }
                numColorActive.push(colorActive);
              }
              else if (blocks[item].classList.contains('index-active-white')) {
                countPurpleColor = Math.floor(Math.random() * (maxCountPurpleColor - minCountPurpleColor + 1)) + minCountPurpleColor;
                if (countPurpleColor == 1) {
                  colorActive = 'purple';
                } else {
                  colorActive = 'black';
                }
                numColorActive.push(colorActive);
              }
              else if (blocks[item].classList.contains('index-active-purple')) {
                colorRandom = Math.floor(Math.random() * 2) + 1;
                if (colorRandom == 1) {
                  colorActive = 'black';
                } else {
                  colorActive = 'white';
                }
                numColorActive.push(colorActive);
              }
              else {
                countPurpleColor = Math.floor(Math.random() * (maxCountPurpleColor - minCountPurpleColor + 1)) + minCountPurpleColor;
                if (countPurpleColor == 1) {
                  colorActive = 'purple';
                } else {
                  colorActive = 'black';
                }
                numColorActive.push(colorActive);
              }
            }

            // console.log('colorActive', colorActive);
            //tobottom
            if (axisTransform == 1) {

              if (colorActive == 'black') {
                blocks[item].classList.remove('index-active-white');
                blocks[item].classList.remove('index-active-purple');
              }
              else if (colorActive == 'white') {
                blocks[item].classList.remove('index-active-black');
                blocks[item].classList.remove('index-active-purple');
              }
              else {
                blocks[item].classList.remove('index-active-white');
                blocks[item].classList.remove('index-active-black');
              }

              blocks[item].classList.add('index-active-' + colorActive + '');

              blocks[item].classList.add('active-tobottom-' + colorActive + '');

            }
            //totop
            else if (axisTransform == 2) {
              if (colorActive == 'black') {
                blocks[item].classList.remove('index-active-white');
                blocks[item].classList.remove('index-active-purple');
              }
              else if (colorActive == 'white') {
                blocks[item].classList.remove('index-active-black');
                blocks[item].classList.remove('index-active-purple');
              }
              else {
                blocks[item].classList.remove('index-active-white');
                blocks[item].classList.remove('index-active-black');
              }

              blocks[item].classList.add('index-active-' + colorActive + '');

              blocks[item].classList.add('active-totop-' + colorActive + '');
            }
            //toleft
            else if (axisTransform == 3) {
              if (colorActive == 'black') {
                blocks[item].classList.remove('index-active-white');
                blocks[item].classList.remove('index-active-purple');
              }
              else if (colorActive == 'white') {
                blocks[item].classList.remove('index-active-black');
                blocks[item].classList.remove('index-active-purple');
              }
              else {
                blocks[item].classList.remove('index-active-white');
                blocks[item].classList.remove('index-active-black');
              }

              blocks[item].classList.add('index-active-' + colorActive + '');

              blocks[item].classList.add('active-toleft-' + colorActive + '');
            }
            //toright
            else {
              if (colorActive == 'black') {
                blocks[item].classList.remove('index-active-white');
                blocks[item].classList.remove('index-active-purple');
              }
              else if (colorActive == 'white') {
                blocks[item].classList.remove('index-active-black');
                blocks[item].classList.remove('index-active-purple');
              }
              else {
                blocks[item].classList.remove('index-active-white');
                blocks[item].classList.remove('index-active-black');
              }

              blocks[item].classList.add('index-active-' + colorActive + '');

              blocks[item].classList.add('active-toright-' + colorActive + '');
            }
          });
          setTimeout(function () {
            numReserve.forEach(function (item, i) {
              if (numColorActive[i] == 'black') {
                blocks[item].classList.remove('active-tobottom-white');
                blocks[item].classList.remove('active-totop-white');
                blocks[item].classList.remove('active-toleft-white');
                blocks[item].classList.remove('active-toright-white');

                blocks[item].classList.remove('active-tobottom-purple');
                blocks[item].classList.remove('active-totop-purple');
                blocks[item].classList.remove('active-toleft-purple');
                blocks[item].classList.remove('active-toright-purple');
              }
              else if (numColorActive[i] == 'purple') {
                blocks[item].classList.remove('active-tobottom-white');
                blocks[item].classList.remove('active-totop-white');
                blocks[item].classList.remove('active-toleft-white');
                blocks[item].classList.remove('active-toright-white');

                blocks[item].classList.remove('active-tobottom-black');
                blocks[item].classList.remove('active-totop-black');
                blocks[item].classList.remove('active-toleft-black');
                blocks[item].classList.remove('active-toright-black');
              } else {
                blocks[item].classList.remove('active-tobottom-purple');
                blocks[item].classList.remove('active-totop-purple');
                blocks[item].classList.remove('active-toleft-purple');
                blocks[item].classList.remove('active-toright-purple');

                blocks[item].classList.remove('active-tobottom-black');
                blocks[item].classList.remove('active-totop-black');
                blocks[item].classList.remove('active-toleft-black');
                blocks[item].classList.remove('active-toright-black');
              }

            });
          }, 1050);

          isThis.setIntervalTime = Math.floor(Math.random() * (maxSetIntervalTime - minSetIntervalTime + 1)) + minSetIntervalTime;
          this.getRandomNew(isThis.setIntervalTime);
        }, isThis.setIntervalTime);
      },
      handleResize: function () {
        this.window.width = window.innerWidth;
        this.window.height = window.innerHeight;

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
        if (this.window.width / this.window.height <= 0.5) {
          boardItemsMobile = document.getElementsByClassName('chess-board-items-mobile');
          boardItemsMobile[0].classList.add('add-line-board');
        } else {
          boardItemsMobile = document.getElementsByClassName('chess-board-items-mobile');
          boardItemsMobile[0].classList.remove('add-line-board');
        }
        this.stopStartAnimate();
      },
      safariResize: function () {
        let context = this;
        setTimeout(function () {
          context.container100vh[0].style.height = window.innerHeight + 'px';
        }, 100);
      },
      stopStartAnimate: function () {
        if (!this.isMainPage) {
          if (this.isAnimateFlag) {
            clearTimeout(this.intervalID);
            this.isAnimateFlag = false;
          }
        } else {
          if (!this.isAnimateFlag && this.window.width >= this.wideWidth) {
            // console.log('start-animate');
            this.isAnimateFlag = true;
            let isThis = this;
            setTimeout(function () {
              isThis.getRandomNew(1500);
            }, 500);
          } else if (this.isAnimateFlag && this.window.width < this.wideWidth) {
            clearTimeout(this.intervalID);
            this.isAnimateFlag = false;
          }
        }
      },
      stopStartChain: function () {
        let isThis = this;
        if (!this.isMainPage) {
          if (tool.responds('mousemove')) {
            isThis.newLayer.visible = false;
            // console.log('stop-chain');
            tool.off('mousemove');
          }
        } else if (this.isMainPage && this.window.width >= this.wideWidth && !('ontouchstart' in window || navigator.maxTouchPoints)) {
          if (!tool.responds('mousemove')) {
            // console.log('start-chain');
            isThis.newLayer.visible = true;
            tool.on('mousemove', function (event) {
              isThis.eventMouseChain(event);
            });
          }
        } else {
          if (tool.responds('mousemove')) {
            isThis.newLayer.visible = false;
            // console.log('stop-chain');
            tool.off('mousemove');
          }
        }
      },
      checkPage: function () {
        if (this.$route.name !== 'MainComponent') {
          // console.log('not main page');
          this.isMainPage = false;
        } else {
          console.log('main page');
          this.isMainPage = true;
        }
      }
    },
    created() {
      window.addEventListener('resize', this.handleResize);
      this.checkPage();
      paper.install(window);
    },
    mounted() {
      this.isCookies = this.$cookie.get('has_cookies');
      console.log(' this.isCookies',  this.isCookies);
      var isThis = this;
      this.handleResize();
      this.container100vh = document.getElementsByClassName('container-100vh');

      let md = new MobileDetect(window.navigator.userAgent);
      let isMobile = md.mobile();

      if (isMobile !== null) {
        this.safariResize();
        window.addEventListener('resize', this.safariResize);
      }
      this.add();
      this.stopStartChain();

      setTimeout(function () {
        isThis.isCookieShow = true;
      }, 1000);

    },
    updated() {

      this.isAgencyScroll = false;
      this.isWorksScroll = false;

      this.checkPage();
      this.stopStartAnimate();
      this.stopStartChain();
    },
    destroyed() {
      console.log('main-destroyed');
      window.removeEventListener('resize', this.safariResize);
      window.removeEventListener('resize', this.handleResize);
    }
  }
</script>
