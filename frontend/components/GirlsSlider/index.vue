<template>
  <div class="girls-slider-wrapper">
    <slick
      ref="slick"
      :options="slickOptions">
      <model-block :model="model" :show-info="false" v-for="model in models" :key="'girl/'+model.id"/>
    </slick>
  </div>
</template>

<script>
  import ModelBlock from '~/components/ModelBlock'

  export default {
    props: {
      models: {
        type: Array,
        default: () => []
      }
    },

    data() {
      return {
        slickOptions: {
          slidesToShow: 3,
          arrows: true,
          infinite: true,
          centerMode: false,
          responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: false,
                slidesToShow: 1,
                centerMode: true,
              }
            },
          ]
        },
      }
    },

    components: {
      ModelBlock
    }
  }
</script>

<style>
  .girls-slider-wrapper .slick-slide {
    display: block;
    margin: 0 10px;
  }

  @media(max-width: 768px) {
    .girls-slider-wrapper {
      margin-top: 20px;
    }
    .girls-slider-wrapper .slick-list {
      overflow: visible;
    }
    .girls-slider-wrapper .slick-slide .girl-block {
      transition: all 0.5s ease-in-out;
    }
    .girls-slider-wrapper .slick-center .girl-block {
      -moz-transform: scale(1.08);
      -ms-transform: scale(1.08);
      -o-transform: scale(1.08);
      -webkit-transform: scale(1.08);
      color: #e67e22;
      opacity: 1;
      transform: scale(1.08);
    }
    .girls-slider-wrapper .girls-item, .girls-slider-wrapper .girl-item {
      height: calc(100vh/2.2);
    }
  }

  @media(min-width: 769px) {
    .girls-slider-wrapper .slick-track {
      width: 100%!important;
    }
  }
</style>
