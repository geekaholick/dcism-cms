<template>
  <div class="sidebar-detached sidebar-left">
    <div class="sidebar">
      <div
        class="sidebar-shop"
        :class="{'show': mqShallShowLeftSidebar}"
      >
        <b-row>
          <b-col cols="12">
            <h6 class="filter-heading d-none d-lg-block">
              Filters
            </h6>
          </b-col>
        </b-row>

        <!-- Filters' Card -->
        <b-card>

          <!-- Months -->
          <div class="multi-range-price">
            <h6 class="filter-title mt-0">
              Months
            </h6>
            <b-form-radio-group
              v-model="filters.months"
              class="price-range-defined-radio-group"
              stacked
              :options="filterOptions.months"
            />
          </div>

          <!-- Years -->
          <div class="product-categories">
            <h6 class="filter-title">
              Years
            </h6>
            <!-- <b-form-radio-group
              v-model="filters.categories"
              class="categories-radio-group"
              stacked
              :options="filterOptions.categories"
            /> -->
            <b-form-group>
              <v-select
                v-model="filters.years"
                :options="filterOptions.years"
                placeholder="Select Year"
                label="title"
              />
            </b-form-group>

            <b-button
              v-ripple.400="'rgba(113, 102, 240, 0.15)'"
              variant="outline-primary"
              @click="reset"
            >
                Reset
            </b-button>
          </div>

        </b-card>
      </div>
    </div>

    <div
      class="body-content-overlay"
      :class="{'show': mqShallShowLeftSidebar}"
      @click="$emit('update:mq-shall-show-left-sidebar', false)"
    />
  </div>
</template>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>

<style lang="scss" scoped>
.categories-radio-group,
.brands-radio-group,
.price-range-defined-radio-group {
    ::v-deep > .custom-control {
    margin-bottom: 0.75rem;
  }
}
</style>

<script>
import {
  BRow, BCol, BCard, BFormRadioGroup, BFormGroup, BButton,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import Ripple from 'vue-ripple-directive'

export default {
  directives: {
    Ripple,
  },
  components: {
    BRow,
    BCol,
    BFormRadioGroup,
    BCard,
    BFormGroup,
    BButton,
    vSelect,
  },
  props: {
    filters: {
      type: Object,
      required: true,
    },
    filterOptions: {
      type: Object,
      required: true,
    },
    mqShallShowLeftSidebar: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    reset() {
      this.$emit('reset', this.filters)
    },
  }
}
</script>
