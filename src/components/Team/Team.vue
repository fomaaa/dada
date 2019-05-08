<template>
  <div class="agency-team-new">
    <div v-for="(peopl, index) in people"
         :style="{height: cardHeight + 'px'}"
         :class="['team-item-block', (Array.isArray(peopl) && peopl[0] == null) || peopl == null ? 'team-item-block-null' : '', (countBlock == 2 && ((Array.isArray(peopl) && peopl[0] == null) || peopl == null)) ? 'team-item-block-null-all' : '']">
      <!--<span>{{howNullBlock}}</span>-->
      <div @click="cardsClick($event.currentTarget)"
           @mouseover="cardsHover($event.currentTarget)"
           @mouseleave="cardsLeave($event.currentTarget)"
           :class="['block-big', index % 16 == 0 || index % 16 == 3 || index % 16 == 5 || index % 16 == 8 || index % 16 == 13 ? 'black' : 'white', peopl == null ? 'zero-block' : '']"
           v-if="index % 16 == 0 || index % 16 == 2 || index % 16 == 3 ||
             index % 16 == 4 || index % 16 == 5 || index % 16 == 7 || index % 16 == 8 || index % 16 == 10 || index % 16 == 13 || index % 16 == 15">
        <div class="content" v-if="peopl !== null">
          <span class="info-fio">{{peopl.name}}</span>
          <span class="info-profession">{{peopl.position}}</span>
        </div>
        <div class="block-for-img" v-if="peopl !== null">
          <div class="img-team img-white" :style="{backgroundImage: 'url('+ peopl.photo_white +')'}"></div>
          <div class="img-team img-black" :style="{backgroundImage: 'url('+ peopl.photo_black +')'}"></div>
        </div>
        <span class="star" v-if="peopl !== null" @click.stop="starColor($event.currentTarget.parentNode)">
          <star-icon></star-icon>
        </span>
      </div>
      <div @mouseover="cardsHover($event.currentTarget)"
           @mouseleave="cardsLeave($event.currentTarget)"
           :class="['block-small', key == 0 || key == 3 ? 'black' : 'white', item == null ? 'zero-block' : '']"
           v-for="(item, key) in peopl" v-if="index % 16 !== 0 && index % 16 !== 2 && index % 16 !== 3 &&
             index % 16 !== 4 && index % 16 !== 5 && index % 16 !== 7 && index % 16 !== 8 && index % 16 !== 10 && index % 16 !== 13 && index % 16 !== 15">
        <div class="content" v-if="item !== null">
          <span class="info-fio">{{item.name}}</span>
          <span class="info-profession">{{item.position}}</span>
        </div>
        <div class="block-for-img" v-if="item !== null" @click="cardsClick($event.currentTarget.parentNode)">
          <div class="img-team img-white" :style="{backgroundImage: 'url('+ item.photo_white +')'}"></div>
          <div class="img-team img-black" :style="{backgroundImage: 'url('+ item.photo_black +')'}"></div>
        </div>
        <span class="star" v-if="item !== null" @click.stop="starColor($event.currentTarget.parentNode)">
          <star-icon></star-icon>
        </span>
      </div>
    </div>
  </div>
</template>
<script>
  import StarIcon from '../../components/StarIcon/StarIcon'

  export default {
    name: "team",
    components: {
      StarIcon
    },
    data() {
      return {
        window: {width: 0},
        wideWidth: 1025,
        people: [],
        countBlock: 0
      }
    },
    computed: {
      cardHeight: function () {
        if (this.screenWidth >= this.wideWidth) {
          if (((12.5 * this.screenWidth / 100) / .75).toFixed(0) % 2 == 0) {
            return ((12.5 * this.screenWidth / 100) / .75).toFixed(0)
          } else {
            return ((12.5 * this.screenWidth / 100) / .75 + 1).toFixed(0)
          }
        } else {
          if (((50 * this.screenWidth / 100) / .75).toFixed(0) % 2 == 0) {
            return ((50 * this.screenWidth / 100) / .75).toFixed(0)
          } else {
            return ((50 * this.screenWidth / 100) / .75 + 1).toFixed(0)
          }
        }
      }
    },
    methods: {
      starColor: function (event) {
        if (!event.classList.contains('zero-block')) {
          if (event.classList.contains('black')) {
            event.classList.remove('black');
            event.classList.add('white');
          } else {
            event.classList.remove('white');
            event.classList.add('black');
          }
        }
      },
      cardsClick: function (event) {
        if (this.screenWidth < this.wideWidth && !event.classList.contains('zero-block')) {
          event.classList.toggle('hovered');
          if (!event.classList.contains('hover-index')) {
            event.classList.add('hover-index');
          } else {
            setTimeout(function () {
              event.classList.remove('hover-index');
            }, 200);
          }
        }
      },
      cardsHover: function (event) {
        if (this.screenWidth >= this.wideWidth && !event.classList.contains('zero-block') && !event.classList.contains('block-big')) {
          event.classList.add('hovered');
          event.classList.add('hover-index');
        }
      },
      cardsLeave: function (event) {
        if (this.screenWidth >= this.wideWidth && !event.classList.contains('zero-block') && !event.classList.contains('block-big')) {
          event.classList.remove('hovered');
          setTimeout(function () {
            event.classList.remove('hover-index');
          }, 100);
        }
      }
    },
    mounted() {
      return this.screenWidth;
    },
    beforeCreate() {
      this.$http.get('/api/' + this.$route.params.lang + '/team').then(response => {
        this.people = response.data;
        console.log('PEEPS', this.people);
        let isThis = this;
        this.people.forEach(function (item, index) {
          if ((Array.isArray(item) && item[0] == null) || item == null) {
            isThis.countBlock += 1;
          }
        });
        console.log('countBlock', isThis.countBlock);
        // return countBlock;

      }, response => {
        // error callback
      });
    },
    props: {
      screenWidth: {type: Number}
    }
  }
</script>
