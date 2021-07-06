<template>
  <router-link
    :to="modelLink"
    class="archive__card"
    :class="{twocollumn: archive_columns == 2}"
    v-lazy:background-image="model.avatar"
    :title="modelTitle"
    :alt="modelAlt"
  >
    <div class="profile__gallery-online" v-if="model.online == true">
      <div class="status"></div>
      <span>{{ $t('models.online') }}</span>
    </div>
    <div class="archive__card-title">
      <div class="archive__card-title-realphoto" v-if="model.verified==='yes'">
        <!--<img :src="cdn_assets_prefix + '/files/icons/svg/icon--verified.svg'" alt="">-->
        <span>{{ $t('models.real_photos') }}</span>
      </div>
      <div class="archive__card-title-realphoto" v-if="model.ready_for_travels == 1">
        <!--<img :src="cdn_assets_prefix + '/files/icons/svg/plane_around_world.svg'" alt="">-->
        <span>{{ $t('models.ready_for_travels') }}</span>
      </div>
      <div class="archive__card-title-wrap">
        <div class="archive__card-name"><span>{{ model.name }}</span></div>
        <div class="archive__card-city">
          {{ model.city }}
        </div>
      </div>
    </div>
    <div class="archive__card-thumb">
      <div
        v-if="showRemoveButton"
        @click.prevent="$emit('remove', model)"
        class="profile__remove"
      >✕</div>
      <div class="profile__bage">
        <div class="profile__bage-item new" v-if="model.profile_age < 14">
          <span>{{ $t('models.new') }}</span>
        </div>
        <div class="profile__bage-item pornstar" v-if="model.pornstar == true">
          <span>{{ $t('models.pornstar') }}</span>
          <!--  Для отображения звезды добавить див <div class="icon"></div> -->
        </div>
        <div class="profile__bage-item vip" v-if="model.vip == true">
          <span>{{ $t('models.vip') }}</span>
        </div>
        <div class="profile__bage-item top" v-if="model.is_top == true">
          <span>{{ $t('models.top') }}</span>
        </div>
      </div>
    </div>
  </router-link>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        props: {
            model: {
                type: Object,
                default: () => {}
            },
            showInfo: {
              type: Boolean,
              default: () => true
            },
            showRemoveButton: {
                default: false
            }
        },
        computed: {
            ...mapGetters(['archive_columns']),
            modelLink() {
                let name = 'country-city-mans-id'

                let link = this.localePath({
                    name: name,
                    params: {
                        id: this.model.id,
                        country: this.model.country_slug,
                        city: this.model.city_slug
                    }
                })
                return link
            },
            modelTitle() {
              return [
                this.model.name,
                this.model.city,
                this.model.age,
                this.$t('model_block.years_old')
              ].join(' ')
            },
            modelAlt() {
              return [
                this.$t('other.photo'),
                this.model.name,
                this.model.city,
                this.model.age,
                this.$t('model_block.years_old')
              ].join(' ')
            }
        }
    }
</script>
