<template>
  <div>
    <div class="row">
      <div class="col-6 col-xs-12">
        <div class="admin__profile-item">
          <label
            class="input-lable"
          >
            {{ $t('profile.language') }}
            <AppTooltip :content="$t('profile.language_tooltip')"/>
          </label>
          <div class="admin__profile-select">
            <select-with-search
              v-if="languages.length"
              :options="languages"
              @input="selectedAction"
              text-field="name"
              value-field="id"
            />
          </div>
        </div>
      </div>

      <div class="col-6 col-xs-12">
        <div class="admin__profile-item">
          <label
            class="input-lable"
          >&nbsp;</label>
          <div class="admin__profile-lang">
            <div
              v-for="(country, index) in selected"
              :key="index+country.name"
              class="admin__profile-lang-item"
            >
              <span>{{ country.name }}</span>
              <div
                @click="remove(index)"
                class="delet"
              ></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!--
  <div>
    <div v-for="(country, index) in selected" :key="index+country.name" class="form-row mb-2 working-country">
      <b-col cols="4" class="text-right">{{ $t('profile.language') }} {{ index + 1 }}</b-col>
      <b-col>
        <div class="inputContainer">
          {{ country.name }}
          <b-button @click="remove(index)" variant="primary" class="remove-selected-btn">
            <i class="fas fa-times"></i>
          </b-button>
        </div>
      </b-col>
    </div>
    <b-form-group
      label-cols-sm="4"
      :label="$t('profile.other_language')"
      label-align-sm="right"
      label-size="sm"
      label-for="nested-country"
      class="select-working-country"
    >
      <div class="inputContainer">
          <b-row>
            <b-col cols="10" class="input_with_tooltip">
              <b-form-select
                size="sm"
                text-field="name"
                value-field="id"
                @input="selectedAction"
                :options="languages"
              />
            </b-col>
            <b-col cols="2" class="question_block">
              <i class="far fa-question-circle" ></i>
            </b-col>
          </b-row>
      </div>
    </b-form-group>
  </div>
  -->
</template>

<script>
import { mapGetters } from 'vuex'
import SelectWithSearch from '~/components/SelectWithSearch';
import AppTooltip from '~/components/AppTooltip'

export default {
  components: {
    SelectWithSearch,
    AppTooltip
  },
  props: {
    value: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      selected: this.value,
      selected_ids: this.value.map(el => el.id)
    }
  },
  computed: {
    ...mapGetters('options', ['languages']),
  },
  watch: {
    selected_ids: {
      immediate: true,
      handler: function(newVal, prevVal) {
        this.$emit('input', newVal)
      }
    }
  },
  methods: {
    selectedAction(value) {
      if(this.selected_ids.indexOf(value) !== -1)
        return;
      var sel = this.languages[this.languages.findIndex(el => el.id === value)];
      this.selected.push(sel)
      this.selected_ids.push(value)
    },
    remove(index) {
      this.selected.splice(index, 1)
      this.selected_ids.splice(index, 1)
    }
  },
  async mounted() {
    if(!this.$store.state.options.languages.length)
      await this.$store.dispatch('options/fetchLanguages')
  }
}
</script>

<style>
.working-country {
  font-size: 14px;
}
.working-country button {
  padding: 6px;
  border-radius: 100%;
  line-height: 0.5;
  font-size: 12px;
}
.select-working-country label {
  line-height: 1.3;
}
</style>
