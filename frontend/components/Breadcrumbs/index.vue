<template>
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <template v-for="(link,index) in breadcrumbsLinks">
          <li
            :key="index"
            :class="{current: (index == breadcrumbsLinks.length-1)}"
          >
            <router-link
              v-if="link.to && (index !== breadcrumbsLinks.length-1)"
              :to="link.to"
              :title="link.text"
            >
              {{ link.text }}
            </router-link>
            <span v-else>{{ link.text }}</span>
          </li>
          <li
            :key="index + 'divider'"
            v-if="index+1 < breadcrumbsLinks.length"
          >/</li>
        </template>
      </ul>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    props: {
      items: {
        type: Array,
        default: () => []
      }
    },
    computed: {
      ...mapGetters(['country', 'city']),
      ...mapGetters('girls', ['section', 'current_girl']),

      breadcrumbsLinks () {
        let tmp = [];
        tmp.push({
          text: this.$t('titles.home'),
          to: this.localePath('index')
        });

        let section = this.section
        if(!this.section && this.current_girl) {
          switch(this.current_girl.type) {
            case 'dating':
              section = 'dating'
              break
            case 'travels':
              section = 'travels'
              break
            case 'girls':
              if(this.current_girl.pornstar) {
                section = 'pornstars'
              }
              break
          }
        }

        switch (section) {
          case 'videos':
            tmp.push({
              to: this.localePath({name: 'videos'}),
              text: this.$t('links.videos')
            })
            if(this.country) {
              // country
              tmp.push({
                to: this.localePath({name: 'country-videos', params: {country: this.country.slug}}),
                text: this.country.name,
              });
            }
            if(this.$route.params.city && this.city) {
              // city
              tmp.push({
                to: this.localePath({
                  name: 'country-city-videos',
                  params: {country: this.country.slug, city: this.city.slug}
                }),
                text: this.city.name
              });
            }
            break;
          case 'dating':
            tmp.push({
              to: this.localePath({name: 'dating'}),
              text: this.$t('links.dating')
            });
            if(this.country) {
              // country
              tmp.push({
                to: this.localePath({name: 'country-dating', params: {country: this.country.slug}}),
                text: this.country.name,
              });
            }
            if(this.$route.params.city && this.city) {
              // city
              tmp.push({
                to: this.localePath({
                  name: 'country-city-dating',
                  params: {country: this.country.slug, city: this.city.slug}
                }),
                text: this.city.name
              });
            }
            break;
          case 'travels':
            if(this.country) {
              // country
              tmp.push({
                to: this.localePath({name: 'country-travels', params: {country: this.country.slug}}),
                text: this.country.name,
              });
            }

            if(this.$route.params.city && this.city) {
              // city
              tmp.push({
                to: this.localePath({
                  name: 'country-city-travels',
                  params: {country: this.country.slug, city: this.city.slug}
                }),
                text: this.city.name
              });
            }

            tmp.push({
              to: this.$route.params.geography && this.country ? this.localePath({name: 'country-travels', params: {country: this.country.slug}}) : this.localePath({name: 'travels'}),
              text: this.$t('links.travels')
            });
            break;
          case 'pornstars':
            tmp.push({
              to: this.localePath({name: 'pornstars'}),
              text: this.$t('links.pornstars')
            });
            if(this.country) {
              // country
              tmp.push({
                to: this.localePath({name: 'country-pornstars', params: {country: this.country.slug}}),
                text: this.country.name,
              });
            }
            if(this.$route.params.city && this.city) {
              // city
              tmp.push({
                to: this.localePath({
                  name: 'country-city-pornstars',
                  params: {country: this.country.slug, city: this.city.slug}
                }),
                text: this.city.name
              });
            }
            break;
          case 'top50':
            tmp.push({
              to: this.localePath({name: 'top50'}),
              text: this.$t('links.top50')
            });
            if(this.country) {
              // country
              tmp.push({
                to: this.localePath({name: 'country-top50', params: {country: this.country.slug}}),
                text: this.country.name,
              });
            }
            if(this.$route.params.city && this.city) {
              // city
              tmp.push({
                to: this.localePath({
                  name: 'country-city-top50',
                  params: {country: this.country.slug, city: this.city.slug}
                }),
                text: this.city.name
              });
            }
            break;
          case 'reviews':
            tmp.push({
              to: this.localePath({name: 'reviews'}),
              text: this.$t('links.reviews')
            });
            if(this.country) {
              // country
              tmp.push({
                to: this.localePath({name: 'country-reviews', params: {country: this.country.slug}}),
                text: this.country.name,
              });
            }
            if(this.$route.params.city && this.city) {
              // city
              tmp.push({
                to: this.localePath({
                  name: 'country-city-reviews',
                  params: {country: this.country.slug, city: this.city.slug}
                }),
                text: this.city.name
              });
            }
            break;
          default:
            if(this.country) {
              // country
              tmp.push({
                to: this.localePath({name: 'country', params: {country: this.country.slug}}),
                text: this.country.name,
              });
            }
            if(this.country && this.$route.params.city && this.city) {
              // city
              tmp.push({
                to: this.localePath({
                  name: 'country-city',
                  params: {country: this.country.slug, city: this.city.slug}
                }),
                text: this.city.name
              });
            }
            break;
        }
        tmp.push(...this.items);
        return tmp
      }
    }
  }
</script>
