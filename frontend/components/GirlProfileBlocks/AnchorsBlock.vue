<template>
  <div class="profile__anchors">
    <div class="container">
      <nav>
        <a href="#photos">{{ $t('profile_nav.photo') }}</a>
        <a href="#about">{{ $t('profile_nav.description') }}</a>
        <a href="#video" v-show="current_girl && current_girl.videos.length">{{ $t('profile_nav.video') }}</a>
        <a href="#price">{{ $t('profile_nav.price') }}</a>
        <a href="#reviews">{{ $t('profile_nav.reviews') }}</a>
      </nav>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters('girls', ['current_girl'])
  },
  mounted() {
    $(window).scroll(function() {
      var $header = $('.header').height();
      var sT = $(this).scrollTop();

      if (sT > $header) {
        $('.profile__anchors').addClass('on');
      } else {
        $('.profile__anchors').removeClass('on');
      }
    });

    $("a[href^='#']").click(function(){
      let _href = $(this).attr("href");
      $("html, body").animate({scrollTop: ($(_href).offset().top-50)+"px"});
      return false;
    });
  }
}
</script>
