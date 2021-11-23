<template>
  <div
    style="height: inherit"
  >
    <!-- Announcement Header -->
    <section id="ecommerce-header">
      <div class="row">
        <div class="col-sm-12">
          <div class="ecommerce-header-items">
            <div class="result-toggler">
              <feather-icon
                icon="MenuIcon"
                class="d-block d-lg-none"
                size="21"
                @click="mqShallShowLeftSidebar = true"
              />
              <div class="search-results">
                {{ totalAnnouncements }} results found
              </div>
            </div>
            <div class="view-options d-flex">
              <!-- Sort Button -->
              <b-dropdown
                v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                :text="sortBy.text"
                right
                variant="outline-primary"
              >
                <b-dropdown-item
                  v-for="sortOption in sortByOptions"
                  :key="sortOption.value"
                  @click="filters.sortBy = sortOption.value, sortBy = sortOption"
                >
                  {{ sortOption.text }}
                </b-dropdown-item>
              </b-dropdown>

              <!-- Item View Radio Button Group  -->
              <b-form-radio-group
                v-model="itemView"
                class="ml-1 list item-view-radio-group"
                buttons
                size="sm"
                button-variant="outline-primary"
              >
                <b-form-radio
                  v-for="option in itemViewOptions"
                  :key="option.value"
                  :value="option.value"
                >
                  <feather-icon
                    :icon="option.icon"
                    size="18"
                  />
                </b-form-radio>
              </b-form-radio-group>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Overlay -->
    <div class="body-content-overlay" />

    <!-- Searchbar -->
    <div class="ecommerce-searchbar mt-1">
      <b-row>
        <b-col cols="12">
          <b-input-group class="input-group-merge">
            <b-form-input
              v-model="filters.q"
              placeholder="Search Announcement"
              class="search-product"
            />
            <b-input-group-append is-text>
              <feather-icon
                icon="SearchIcon"
                class="text-muted"
              />
            </b-input-group-append>
          </b-input-group>
        </b-col>
      </b-row>
    </div>

    <!-- Announcements Section -->
    <div
      v-if="isLoading"
    >
      <section :class="itemView">
        <announcement-skeleton
          v-for="i in filters.perPage"
          :key="i"
        />
      </section>
    </div>
    <div v-else>
      <div
        v-if="totalAnnouncements == 0"
        class="d-flex justify-content-center py-4"
      >
        <b-col
          md="8"
          lg="8"
        >
          <b-card
            title="Uh ohhh! 😢"
            class="text-center"
            bg-variant="light-danger"
            text-variant="primary"
          >
            <b-card-text>
              There are no announcements to be displayed.
            </b-card-text>
            <b-button
              v-ripple.400="'rgba(113, 102, 240, 0.15)'"
              variant="outline-primary"
            >
              <router-link :to="'/'">
                Go somewhere else
              </router-link>
            </b-button>
          </b-card>
        </b-col>
      </div>

      <section
        v-else
        :class="itemView"
      >
        <b-card
          v-for="announcement in announcement_list"
          :key="announcement.announcement_id"
          class="ecommerce-card position-relative"
          stye="display: flex !important; flex-direction: flex-column !important;"
          no-body
        >

          <div
            class="item-wrapper pt-2 pl-1 pb-0"
            style="justify-content: space-between; align-items: center;"
          >
            <div
              class="d-flex"
              style="gap: 0.75rem;"
            >
              <b-avatar
                size="40"
                :variant="profile_color[announcement.user_id % profile_color.length]"
                badge
                :src="null"
                :text="`${announcement.first_name[0].toUpperCase()}${announcement.last_name[0].toUpperCase()}`"
                class="badge-minimal"
              />
              <div>
                <p
                  class="pb-0 mb-0 font-weight-bolder"
                >
                  {{ announcement.first_name }} {{ announcement.last_name }}
                </p>
                <span
                  class="item-description text-muted font-weight-bolder"
                  style="word-wrap: break-word;"
                >{{ formatDate(announcement.created_at) }}
                </span>
              </div>
            </div>

            <!-- Dropdown Bookmark -->
            <div class="dropdown float-right">
              <b-dropdown
                variant="link"
                no-caret
                toggle-class="p-0 mr-1"
                right
              >
                <template #button-content>
                  <feather-icon
                    icon="MoreVerticalIcon"
                    size="16"
                    class="align-middle text-body"
                  />
                </template>
                <b-dropdown-item>
                  <feather-icon
                    size="16"
                    icon="BookmarkIcon"
                    class="mr-50"
                  /> Bookmark this announcement
                </b-dropdown-item>
              </b-dropdown>
            </div>
          </div>

          <!-- Announcement Details -->
          <b-card-body class="cursor-pointer">
            <h6 class="item-name mb-2">
              <b-link
                class="text-body"
                :to="{ name: 'view-all-announcements'}"
              >
                {{ announcement.title }}
              </b-link>
            </h6>
            <b-card-text class="item-description">
              {{ addReadMoreToBody(announcement.body) }}
              <router-link to="/view-all-announcements">
                (Read more)
              </router-link>
            </b-card-text>
          </b-card-body>

          <!-- Product Actions -->
          <div class="item-options text-center border-top mx-2">
            <div class="item-wrapper justify-content-start">
              <div class="item-cost">
                <span
                  class="item-price cursor-pointer"
                  style="font-size: 0.75rem;"
                >
                  <feather-icon
                    size="16"
                    icon="MessageSquareIcon"
                    class="mr-50"
                  />
                  {{ announcement.comment_no >= 1000 ? `${formatCommentCount(announcement.comment_no)}k comments` : announcement.comment_no > 1 ? `${announcement.comment_no} comments` : `${announcement.comment_no} comment` }}
                </span>
              </div>
            </div>
          </div>
        </b-card>
      </section>
    </div>
    <!-- Pagination -->
    <section>
      <b-row>
        <b-col cols="12">
          <b-pagination
            v-model="filters.page"
            :total-rows="totalAnnouncements"
            :per-page="filters.perPage"
            first-number
            align="center"
            last-number
            prev-class="prev-item"
            next-class="next-item"
            @click="makePagination"
          >
            <template #prev-text>
              <feather-icon
                icon="ChevronLeftIcon"
                size="18"
              />
            </template>
            <template #next-text>
              <feather-icon
                icon="ChevronRightIcon"
                size="18"
              />
            </template>
          </b-pagination>
        </b-col>
      </b-row>
    </section>

    <!-- Sidebar -->
    <portal to="content-renderer-sidebar-detached-left">
      <announcement-filter
        :filters="filters"
        :filter-options="filterOptions"
        :mq-shall-show-left-sidebar.sync="mqShallShowLeftSidebar"
        @reset="reset"
      />
    </portal>
  </div>
</template>

<style lang="scss">
@import "~@core/scss/base/pages/app-ecommerce.scss";
</style>

<style lang="scss" scoped>

.ecommerce-application .ecommerce-card {
  grid-template-columns: 1fr !important;
}

.ecommerce-application .item-wrapper {
  display: flex;
  justify-content: center;
  align-items: baseline;
}

.ecommerce-application .list-view {
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
}

.ecommerce-application .list-view.test {
  grid-template-columns: 1fr 1fr 1fr;
  gap: 1.5rem;
}

@media screen and (min-width: 1500px) {
  .ecommerce-application .list-view {
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  .ecommerce-application .list-view.test {
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1rem;
  }
}

@media screen and (max-width: 1350px) {
  .ecommerce-application .list-view {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .ecommerce-application .list-view.test {
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }
}

@media screen and (max-width: 700px) {
  .ecommerce-application .list-view {
    grid-template-columns: 1fr;
    gap: 0.2rem;
  }

  .ecommerce-application .list-view.test {
    grid-template-columns: 1fr;
    gap: 0.2rem;
  }
}
</style>

<script>
import {
  BDropdown,
  BDropdownItem,
  BFormRadioGroup,
  BFormRadio,
  BRow,
  BCol,
  BInputGroup,
  BInputGroupAppend,
  BFormInput,
  BCard,
  BCardBody,
  BLink,
  BImg,
  BCardText,
  BPagination,
  BAvatar,
  BButton,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { useResponsiveAppLeftSidebarVisibility } from '@core/comp-functions/ui/app'
// eslint-disable-next-line no-unused-vars
import { mapGetters, mapActions } from 'vuex'
import AnnouncementFilter from './AnnouncementFilter.vue'
import AnnouncementSkeleton from './AnnouncementSkeleton.vue'
import * as announcementTypes from '../../../store/announcements/announcementTypes'

export default {
  directives: {
    Ripple,
  },
  components: {
    BDropdown,
    BDropdownItem,
    BFormRadioGroup,
    BFormRadio,
    BRow,
    BCol,
    BInputGroup,
    BInputGroupAppend,
    BFormInput,
    BCard,
    BCardBody,
    BLink,
    // eslint-disable-next-line vue/no-unused-components
    BImg,
    BCardText,
    BButton,
    BPagination,
    BAvatar,
    AnnouncementSkeleton,
    AnnouncementFilter,
  },
  data() {
    return {
      profile_color: ['primary', 'secondary', 'success', 'warning', 'danger', 'info'],
      filterOptions: {
        months: [
          'January',
          'February',
          'March',
          'April',
          'May',
          'June',
          'July',
          'August',
          'September',
          'October',
          'November',
          'December',
        ],
        years: [
          new Date().getFullYear(),
          new Date().getFullYear() - 1,
          new Date().getFullYear() - 2,
          new Date().getFullYear() - 3,
          new Date().getFullYear() - 4,
          new Date().getFullYear() - 5,
          new Date().getFullYear() - 6,
        ],
      },
      sortBy: { text: 'Latest', value: 'latest' },
      sortByOptions: [
        { text: 'Latest', value: 'latest' },
        { text: 'Oldest', value: 'oldest' },
      ],
      itemView: 'list-view',
      itemViewOptions: [
        { icon: 'GridIcon', value: 'list-view test' },
        { icon: 'ListIcon', value: 'list-view' },
      ],
      filters: {
        q: '',
        page: 1,
        perPage: 12,
        sortBy: 'latest',
        months: new Date().toLocaleString('default', { month: 'long' }),
        years: new Date().getFullYear(),
      },
      isLoading: true,
      totalAnnouncements: 0,
      announcement_list: [],
      passToSearch: [],
    }
  },
  setup() {
    const { mqShallShowLeftSidebar } = useResponsiveAppLeftSidebarVisibility()
    return {
      mqShallShowLeftSidebar,
    }
  },
  watch: {
    filters: {
      deep: true,
      handler() {
        this.makePagination()
      },
    },
  },
  async created() {
    try {
      const args = this.filters

      const count = await this.getAnnouncementCount({
        args,
      })
      this.totalAnnouncements = count

      const announcements = await this.getAllAnnouncements(
        args,
      )

      this.announcement_list = announcements
    } catch (e) {
      console.log(e.toString())
    }

    this.isLoading = false
  },
  methods: {
    ...mapActions({
      getAllAnnouncements: announcementTypes.ACTION_GET_ALL_ANNOUNCEMENTS,
      getAnnouncementCount: announcementTypes.ACTION_GET_ANNOUNCEMENTS_COUNT,
      getFilteredAnnouncements: announcementTypes.ACTION_GET_FILTERED_ANNOUNCEMENTS,
    }),
    formatDate(date) {
      const months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
      ]

      const d = new Date(date)
      const extension = this.getDayDifference(d, new Date())

      return `${
        months[d.getMonth()]
      } ${d.getDate()}, ${d.getFullYear()} ${extension}`
    },
    getDayDifference(prev, now) {
      // convert to UTC
      // eslint-disable-next-line camelcase
      const date2_UTC = new Date(Date.UTC(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate()))
      // eslint-disable-next-line camelcase
      const date1_UTC = new Date(Date.UTC(prev.getUTCFullYear(), prev.getUTCMonth(), prev.getUTCDate()))

      //--------------------------------------------------------------
      let days = date2_UTC.getDate() - date1_UTC.getDate()
      if (days < 0) {
        date2_UTC.setMonth(date2_UTC.getMonth() - 1)
        days += this.DaysInMonth(date2_UTC)
      }
      //--------------------------------------------------------------
      let months = date2_UTC.getMonth() - date1_UTC.getMonth()
      if (months < 0) {
        date2_UTC.setFullYear(date2_UTC.getFullYear() - 1)
        months += 12
      }
      //--------------------------------------------------------------
      const years = date2_UTC.getFullYear() - date1_UTC.getFullYear()

      if (years === 1) return `(${years} year ago)`

      if (years > 1) return `(${years} years ago)`

      if (months === 1) return `(${months} month ago)`

      if (months > 1) return `(${months} months ago)`

      if (days === 1) return `(${days} day ago)`

      if (days > 1) return `(${days} days ago)`

      return '(today)'
    },
    // eslint-disable-next-line camelcase
    DaysInMonth(date2_UTC) {
      const monthStart = new Date(date2_UTC.getFullYear(), date2_UTC.getMonth(), 1)
      const monthEnd = new Date(date2_UTC.getFullYear(), date2_UTC.getMonth() + 1, 1)
      const monthLength = (monthEnd - monthStart) / (1000 * 60 * 60 * 24)
      return monthLength
    },
    addReadMoreToBody(text) {
      if (text.length >= 150) {
        // eslint-disable-next-line camelcase
        const new_text = text.slice(0, 140)
        // eslint-disable-next-line camelcase
        return `${new_text}...`
      }
      return text
    },
    formatCommentCount(number) {
      let temp = []
      let x = number / 1000
      x = x.toString()

      let i
      // eslint-disable-next-line no-plusplus
      for (i = 0; i < x.length && x[i] !== '.'; i++) temp.push(x[i])

      // eslint-disable-next-line no-plusplus
      temp = parseFloat(`${temp.join('')}.${x[++i]}`)
      return temp
    },
    async makePagination() {
      this.isLoading = true
      // eslint-disable-next-line prefer-destructuring
      try {
        const args = this.filters
        const count = await this.getAnnouncementCount({
          args,
        })
        this.totalAnnouncements = count

        const announcements = await this.getAllAnnouncements(this.filters)
        this.announcement_list = announcements
      } catch (err) {
        console.log(err.toString())
      }
      this.isLoading = false
    },
    reset() {
      this.filters.months = new Date().toLocaleString('default', { month: 'long' })
      this.filters.years = new Date().getFullYear()
    },
  },
}
</script>
