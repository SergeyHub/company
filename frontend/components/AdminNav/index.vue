<template>
  <div class="admin__nav">
    <div class="container">
      <ul>
        <li>
          <router-link :to="localePath('adminkas-verify')" :active="isCurrentPath('/adminkas/verify')">
            <i class="fas fa-envelope"></i> Верификация
          </router-link>
        </li>
        <li>
          <router-link :to="localePath('adminkas-applications')" :active="isCurrentPath('/adminkas/applications')">
            <i class="fas fa-envelope"></i> Заявки
          </router-link>
        </li>
        <li>
          <router-link :to="localePath('adminkas-users')" :active="isCurrentPath('/adminkas/users')">
            <i class="fas fa-users"></i> Пользователи
          </router-link>
        </li>
        <li>
          <router-link :to="localePath('adminkas-mans')" :active="isCurrentPath('/adminkas/mans')">
            <i class="fas fa-female"></i> Анкеты
          </router-link>
        </li>
        <!--
        <li>
          <router-link :to="localePath('adminkas-clients')" :active="isCurrentPath('/adminkas/clients')">
            <i class="fas fa-male"></i> Клиенты
          </router-link>
        </li>-->
        <li>
          <router-link :to="localePath('adminkas-reviews')" :active="isCurrentPath('/adminkas/reviews')">
            <i class="fas fa-comments"></i> Отзывы
          </router-link>
        </li>
        <li v-if="false">
          <router-link :to="localePath('adminkas-settings')" :active="isCurrentPath('/adminkas/settings')">
            <i class="fas fa-cogs"></i> Настройки
          </router-link>
        </li>
      </ul>

    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: {
      currentPath() {
        return this.$route.path.replace('/' + this.$i18n.locale, '');
      }
    },
    methods: {
      isCurrentPath(path) {
        return this.currentPath === path;
      }
    },
  }
</script>

<style lang="scss">
  .admin-nav {
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    margin: 20px 0;
    .nav-link {
      color: #000;
      i {
        margin-right: 2px;
      }
    }
  }
</style>
