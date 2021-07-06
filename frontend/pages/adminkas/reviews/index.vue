<template>
  <div>
    <AdminReviewsFilter @update="filterUpdated"/>
    <div>
      <div class="reviews__row">
        <div class="table-responsive">
          <Table
            :data="reviews"
            @sort-change="sortChanged"
          >
            <TableColumn
              prop="id"
              label="id"
              sortable="custom"
            />
            <TableColumn
              prop="created_at"
              label="Дата отправки"
              sortable="custom"
            >
              <template slot-scope="scope">
                {{ $dayjs(scope.row.created_at).format('YYYY-MM-DD HH:mm') }}
              </template>
            </TableColumn>
            <TableColumn
              prop="review"
              label="Текст"
            >
              <template slot-scope="scope">
                <a
                  @click.prevent="showReviewBody(scope.row)"
                  v-if="typeof scope.row.review == 'object'"
                  href="#"
                >
                  {{ reviewBodyPreview(scope.row) }}
                </a>
                <span v-else></span>
              </template>
            </TableColumn>
            <TableColumn label="Гео">
              <template slot-scope="scope">
                <span v-if="scope.row.girl != null">
                  {{ scope.row.girl.country_name ? scope.row.girl.country_name + ',' : '' }} {{ scope.row.girl.city }}
                </span>
              </template>
            </TableColumn>
            <TableColumn label="Профиль">
              <template slot-scope="scope">
                <GirlLink
                  v-if="scope.row.girl != null"
                  :model="scope.row.girl"
                >
                  <div class="row align-items-center">
                    <img :src="scope.row.girl.avatar" class="avatar-mini">
                    <span class="ml-10">
                        {{ scope.row.girl.name }}
                      </span>
                  </div>
                </GirlLink>
              </template>
            </TableColumn>
            <TableColumn>
              <template slot-scope="scope">
                <button
                  v-if="scope.row.published == 0"
                  @click="publish(scope.row)"
                  class="btn btn-mess"
                >Опубликовать</button>
                <button
                  v-if="scope.row.published == 1"
                  @click="unpublish(scope.row)"
                  class="btn btn-border"
                >Убрать</button>
              </template>
            </TableColumn>
            <TableColumn
              label=""
              prop="buttons"
            >
              <template slot-scope="scope">
                <a
                  @click.prevent="deleteReview(scope.row)"
                  href="#"
                  class="text-danger"
                >
                  Delete
                </a>
              </template>
            </TableColumn>
          </Table>
        </div>
        <div class="archive__btn">
          <button
            v-if="!isBusy"
            @click="loadMore(page+1)"
            :title="$t('load_more')"
            class="btn btn-border"
          >
            {{ $t('other.load_more') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { MessageBox, Message } from 'element-ui'
import AdminReviewsFilter from '~/components/AdminReviewsFilter'
import { Table, TableColumn } from 'element-ui'
import GirlLink from '~/components/GirlLink'

export default {
  components: {
    AdminReviewsFilter,
    Table,
    TableColumn,
    GirlLink
  },
  layout: 'admin',

  computed: {
    ...mapGetters('reviews', ['reviews']),
  },

  data() {
    return {
      page: 1,
      isBusy: true,
      filter: null,
      fields: ['id', 'model_id', 'email', 'created_at', 'actions'],
      sort: null,
      sortOrder: 'desc'
    }
  },
  asyncData({store}) {
    store.commit('reviews/RESET_REVIEWS')

    return store.dispatch('reviews/listReviews')
      .then((response) => {
        return {
          last_page: response.meta.last_page,
          total: response.meta.total,
          isBusy: false,
        }
      })
  },

  watch: {
    query: {
      deep: true,
      handler(newVal, oldVal) {
        this.loadMore(1)
      }
    }
  },

  methods: {
    filterUpdated(filter) {
      this.filter = filter
      this.loadMore(1)
    },
    sortChanged(e) {
      this.sort = e.prop
      this.sortOrder = e.order == 'ascending' ? 'asc' : 'desc'

      this.loadMore(1)
      return false;
    },
    async loadMore(page) {
      this.isBusy = true;
      let params = {page: page, ...this.filter, sort: this.sort, sortOrder: this.sortOrder};
      if(page == 1) {
        this.$store.commit('reviews/RESET_REVIEWS')
      }
      await this.$store.dispatch('reviews/listReviews', params)
      this.page = page;
      this.isBusy = false;
    },
    publish(model) {
      this.$store.dispatch('reviews/publish', model.id)
    },
    unpublish(model) {
      this.$store.dispatch('reviews/unpublish', model.id)
    },
    reset() {
      this.query = {
        query: null
      }
    },

    showReviewBody(review) {
      const body = review.review.ru + "<br><br>" + review.review.en
      MessageBox({message: body, dangerouslyUseHTMLString: true})
    },
    reviewBodyPreview(review) {
      let body = review.review.ru != null && review.review.ru.length ? review.review.ru : review.review.en
      if(body == null) body = ''
      return body.substr(0,35) + (body.length > 35 ? '..' : '')
    },

    deleteReview(review_id) {
      MessageBox.confirm('Отзыв нельзя будет восстановить!', 'Внимание', {
        confirmButtonText: 'Удалить',
        cancelButtonText: 'Отменить',
        type: 'warning'
      }).then(() => {
        this.isBusy = true;
        this.$store.dispatch('reviews/removeReview', review_id)
          .then((response) => {
            this.isBusy = false;
            Message.success({
              showClose: true,
              message: 'Отзыв удален'
            })
          })
          .catch((error) => {
            this.isBusy = false;
            Message.error({
              showClose: true,
              message: 'Ошибка удаления'
            })
          })
      }).catch(() => {
        //
      });
    }
  }
}
</script>
