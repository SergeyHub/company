<template>
  <girls-archive
    v-if="otherGirls.length"
    :fourcolumns="true"
    titleTag="h5"
    :girls="otherGirls"
    :showSidebar="false"
    :showLoadMoreButton="false"
    :title="$t('archive.other_girls')"
  />
</template>
<script>
import GirlsArchive from '~/components/GirlsArchive';
import { mapGetters } from 'vuex';

export default {
  components: {
    GirlsArchive
  },
  computed: {
    ...mapGetters('girls', ['current_girl']),
    otherGirls() {
      return this.current_girl.another_girls
        ? this.current_girl.another_girls.filter(girl => girl.id !== this.current_girl.id)
        : [];
    }
  }
}
</script>
