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
                  @click="sortBy = sortOption"
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
          <b-input-group class="input-group-merg">
            <b-form-input
              v-model="searchValue"
              placeholder="Search Announcement"
            />
            <b-input-group-append @click="search">
              <b-button variant="outline-primary">
                GO
              </b-button>
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
          v-for="i in perPage"
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
          v-for="announcement in rendered_announcements"
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
            v-model="page"
            :total-rows="totalAnnouncements"
            :per-page="perPage"
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
      filters: {
        q: '',
        priceRangeDefined: 'all',
        priceRange: [0, 100],
        categories: [],
        brands: [],
        ratings: null,
      },
      filterOptions: {
        priceRangeDefined: [
          { text: 'All', value: 'all' },
          { text: '<= $10', value: '<=10' },
          { text: '$10 - $100', value: '10-100' },
          { text: '$100 - $500', value: '100-500' },
          { text: '>= $500', value: '>=500' },
        ],
        categories: [
          'Appliances',
          'Audio',
          'Cameras & Camcorders',
          'Car Electronics & GPS',
          'Cell Phones',
          'Computers & Tablets',
          'Health, Fitness & Beauty',
          'Office & School Supplies',
          'TV & Home Theater',
          'Video Games',
        ],
        brands: [
          'Insignia™',
          'Samsung',
          'Metra',
          'HP',
          'Apple',
          'GE',
          'Sony',
          'Incipio',
          'KitchenAid',
          'Whirlpool',
        ],
        ratings: [
          { rating: 4, count: 160 },
          { rating: 3, count: 176 },
          { rating: 2, count: 291 },
          { rating: 1, count: 190 },
        ],
      },
      sortBy: { text: 'Featured', value: 'featured' },
      sortByOptions: [
        { text: 'Featured', value: 'featured' },
        { text: 'Lowest', value: 'price-asc' },
        { text: 'Highest', value: 'price-desc' },
      ],
      itemView: 'list-view',
      itemViewOptions: [
        { icon: 'GridIcon', value: 'list-view test' },
        { icon: 'ListIcon', value: 'list-view' },
      ],
      isLoading: true,
      totalFilteredAnnouncements: 0,
      totalAnnouncements: 0,
      searchValue: '',
      page: 1,
      perPage: 12,
      announcement_list: [],
      rendered_announcements: [],
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
    page() {
      this.makePagination()
    },
    searchValue() {
      if (this.searchValue.length === 0) {
        this.search()
      }
    },
  },
  async created() {
    try {
      const count = await this.getAnnouncementCount()
      this.totalAnnouncements = count

      const page = 1
      const items = 12
      const announcements = await this.getAllAnnouncements({
        page, items,
      })

      this.announcement_list = new Array(count)

      // eslint-disable-next-line no-plusplus
      for (let offset = (page - 1) * items, i = 0; i < items; offset++, i++) {
        this.announcement_list[offset] = announcements[i]
      }

      this.passToSearch = announcements
      this.rendered_announcements = [...announcements]
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
    makePagination() {
      // eslint-disable-next-line prefer-destructuring
      const page = this.page
      const items = this.perPage
      this.updateList({ page, items })
    },
    async updateList(params) {
      // this is to check if the elements to be rendered based on the
      // pagination are already present
      const offset = (params.page - 1) * params.items
      // eslint-disable-next-line camelcase, prefer-const
      let temp_list = []
      // eslint-disable-next-line no-plusplus
      for (let i = offset, j = 0; j < params.items; i++, j++) {
        if (!this.announcement_list[offset]) {
          this.isLoading = true
          break
        } else {
          temp_list.push(this.announcement_list[i])
        }
      }
      if (!this.isLoading && this.totalAnnouncements !== 0) {
        // we need to remove the undefined so as to not accidentally access
        // invalid index of an array
        // eslint-disable-next-line camelcase
        temp_list = temp_list.filter(element => element !== undefined)

        // eslint-disable-next-line camelcase
        this.rendered_announcements = temp_list
        return
      }

      const count = await this.getAnnouncementCount()
      this.totalAnnouncements = count

      // else, items to be rendered are not yet present, so we
      // get that from the database
      this.getAllAnnouncements(params)
        .then(res => {
          // eslint-disable-next-line no-plusplus, no-shadow
          for (let offset = (params.page - 1) * params.items, i = 0; i < res.length; offset++, i++) {
            this.announcement_list[offset] = res[i]
          }


          this.rendered_announcements = res
          this.isLoading = false
        })
        .catch(err => {
          console.log(err.toString())
        })
    },
    async search() {
      if (this.searchValue === '') {
        const count = await this.getAnnouncementCount()
        this.totalAnnouncements = count

        // else, items to be rendered are not yet present, so we
        // get that from the database
        this.getAllAnnouncements({ page: this.page, items: this.perPage, q: this.searchValue })
          .then(res => {
            // eslint-disable-next-line no-plusplus, no-shadow
            for (let offset = (this.page - 1) * this.perPage, i = 0; i < res.length; offset++, i++) {
              this.announcement_list[offset] = res[i]
            }

            this.rendered_announcements = res
            this.isLoading = false
          })
          .catch(err => {
            console.log(err.toString())
          })
        return
      }

      this.isLoading = true
      const res = await this.getFilteredAnnouncements({ q: this.searchValue })
      console.log('AWHAWA')
      console.log(res)

      this.announcement_list = res
      this.totalAnnouncements = res.length

      this.rendered_announcements = []
      // eslint-disable-next-line no-plusplus, no-shadow
      for (let i = 0, j = 0; i < this.perPage && j < res.length; i++, j++) {
        this.rendered_announcements[i] = res[i]
      }

      console.log("wah")
      console.log(this.rendered_announcements)
      this.isLoading = false
    },
  },
}
</script>
