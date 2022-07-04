<template>
  <div
    style="height: inherit"
  >
    <router-link to="/view-all-announcements" class="back-button">< Go back</router-link><br>
    <section>
      <b-card class="specific-announcement">
        <div>
          <h1>{{rendered_announcements[(this.$route.params.id)-1].title}}</h1>
          <h4>By: {{rendered_announcements[(this.$route.params.id)-1].first_name}} {{rendered_announcements[(this.$route.params.id)-1].last_name}}</h4>
          <h4>On: {{formatDate(rendered_announcements[(this.$route.params.id)-1].created_at)}}</h4>
          <br><br>
          <p>{{rendered_announcements[(this.$route.params.id)-1].body}}</p>
        </div>
      </b-card>
      <b-card class="comments">
        <div>
        <h2>Comments</h2>
        <b-card>
          <p>{{rendered_announcements[(this.$route.params.id)-1].comment}}</p>
        </b-card>
        </div>
      </b-card>
    </section>
  </div>
</template>

<style lang="scss">
@import "~@core/scss/base/pages/app-ecommerce.scss";
</style>

<style lang="scss" scoped>

.back-button {
  font-size: 20px;
}

.comments {
  max-width: 70rem;
  display: flex;
  justify-content: center;
  margin: auto;
  margin-top: 3vh;
}

.specific-announcement {
  max-width: 70rem;
  display: flex;
  justify-content: center;
  margin: auto;
  margin-top: 3vh;
}

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
import * as announcementComments from '../../../store/announcements/announcementComments'

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
      totalAnnouncements: 0,
      page: 1,
      commentCount: 1,
      perPage: 1,
      announcement_list: [],
      rendered_announcements: [],
      comment_list: [],
      rendered_comments: [],
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
  },
  async created() {
    try {
      const count = await this.getAnnouncementCount()
      // const commentCount = await this.getCommentCount()
      this.totalAnnouncements = count

      const page = 1
      const items = 12
      // const commentItems = 12
      // const commentCounter = 1
      const announcements = await this.getAllAnnouncements({
        page, items,
      })

      // const comments = await this.getAllComments({
      //   commentCounter, commentItems
      // })

      this.announcement_list = new Array(count)
      // this.comment_list = new Array(commentCount)

      // eslint-disable-next-line no-plusplus
      for (let offset = (page - 1) * items, i = 0; i < items; offset++, i++) {
        this.announcement_list[offset] = announcements[i]
      }

      // for(let newNum = (commentCounter - 1) * commentItems, j = 0; j < commentItems; newNum++, j++) {
      //   this.comment_list[newNum] = comments[j]
      // }

      this.passToSearch = announcements
      this.rendered_announcements = [...announcements]
      // this.rendered_comments = [...comments]

    } catch (e) {
      console.log(e.toString())
    }

    

    this.isLoading = false
  },
  methods: {
    ...mapActions({
      getAllAnnouncements: announcementTypes.ACTION_GET_ALL_ANNOUNCEMENTS,
      getAnnouncementCount: announcementTypes.ACTION_GET_ANNOUNCEMENTS_COUNT,
      // getAllComments: announcementComments.ACTION_GET_ALL_COMMENTS,
      // getCommentCount: announcementComments.ACTION_GET_COMMENTS_COUNT,
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
    updateList(params) {
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
      if (!this.isLoading) {
        // we need to remove the undefined so as to not accidentally access
        // invalid index of an array
        // eslint-disable-next-line camelcase
        temp_list = temp_list.filter(element => element !== undefined)

        // eslint-disable-next-line camelcase
        this.rendered_announcements = temp_list
        return
      }

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

      // this.getAllComments(params)
      //   .then(resp => {
      //     for(let newNum = (params.commentCounter -1) * params.commentItems, j = 0; j < resp.length; newNum++, j++) {
      //       this.comment_list[newNum] = resp[j]
      //     }

      //     this.rendered_comments = resp
      //   })
    },
  },
}
</script>
