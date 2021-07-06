<template>
  <div class="sidebar">
    <div class="banners">
      <div class="banners__item">
        <img v-lazy="cdn_assets_prefix +  '/images/others/banner-1.jpg'" alt="">
      </div>
      <div class="banners__item">
        <img v-lazy="cdn_assets_prefix + '/images/others/banner-2.jpg'" alt="">
      </div>
      <div class="banners__item">
        <img v-lazy="cdn_assets_prefix + '/images/others/banner-3.jpg'" alt="">
      </div>
    </div>
  </div>
</template>
<script>
  export default {

  }
</script>
