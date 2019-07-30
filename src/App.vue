<template>
  <div id="app">
    <transition :name="transitionName" :duration="transitionDuration" appear>
      <router-view :key="keyForCase"></router-view>
    </transition>
  </div>
</template>

<script>
  import './assets/scss/_default/normalize.css'

  if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
  }
  export default {
    name: 'App',
    data() {
      return {
        transitionDuration: 0,
        transitionName: '',
        keyForCase: '',
        window: {
          width: 0,
          height: 0
        },
        wideWidth: 1025,
        fontGlobal: 0
      }
    },
    watch: {
      '$route'(to, from) {
        this.window.width = window.innerWidth;

        const fromDepth = from.path.split('/');
        const toDepth = to.path.split('/');

        console.log('app-fromDepth', fromDepth);
        console.log('app-toDepth', toDepth);

        if (this.window.width >= this.wideWidth) {
          if (!/(agency|works)/.test(fromDepth[2]) && fromDepth[2]) {
            if (!/(agency|works)/.test(toDepth[2]) && toDepth[2]) {
              console.log('app-case2case !!!!');
              this.keyForCase = this.$route.path;
              this.transitionName = 'case2case';
              this.transitionDuration = 1000;
            }
            if (toDepth[2] === 'works') {
              console.log('app-case2works !!!!');
              this.transitionName = 'case2works';
              this.transitionDuration = 800;
            }
            if (toDepth[2] === 'agency') {
              console.log('app-case2agency !!!!');
              this.transitionName = 'case2agency';
              this.transitionDuration = {enter: 1100, leave: 900};
            }
            if (!toDepth[2]) {
              console.log('app-case2main !!!!');
              this.transitionName = 'case2main';
              this.transitionDuration = 900;
            }
          }
          else if (fromDepth[2] === 'works' && !/(agency|works)/.test(toDepth[2]) && toDepth[2]) {
            console.log('app-works2case !!!!');
            this.transitionName = 'works2case';
            this.transitionDuration = 800;
          }
          else {
            console.log('app-none !!!!');
            this.transitionDuration = 0;
          }
        }
      }
    },
    methods: {
      eventsHover() {
        $(document).on({
          mouseenter: function () {
            let self = $(this);

            $('#cursor').addClass('showing-text');
            $('.cursor__text').html(self.data('cursor'));

            if (self.data('cursor-color') === 'black') {
              $('#cursor').addClass('color-black');
            }

            if (self.data('cursor-color') === 'white') {
              $('#cursor').addClass('color-white');
            }
          },
          mouseleave: function () {
            $('#cursor').removeClass('showing-text color-white color-black');
          }
        }, "[data-cursor]");

        $('#canvas, .chess-item').hover(function () {
          $('#cursor').addClass('is-hidden')
          console.log(123);
        }, function () {
          $('#cursor').removeClass('is-hidden')
        })

        $(document).mouseleave(function () {
          $('#cursor').addClass('is-hidden')
        });

        $(document).mouseenter(function () {
          $('#cursor').removeClass('is-hidden')
        });
      }
    },
    updated() {
      console.log('app-updated');
      this.eventsHover();

      let isThis = this;

      setTimeout(function () {

        isThis.transitionName = null;
        isThis.transitionDuration = 0;

      }, this.transitionDuration);

    },
    mounted() {
      this.eventsHover();
    }
  }
</script>

<style lang="css">
  #app {
    width: 100%;
    height: 100%;
    overflow: hidden;
    position: fixed;
    top: 0;
    left: 0;
  }
</style>
