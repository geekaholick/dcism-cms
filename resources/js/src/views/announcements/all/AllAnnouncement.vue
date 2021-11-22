/* eslint-disable import/no-unresolved */
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
                {{ totalProducts }} results found
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
          <b-input-group class="input-group-merge">
            <b-form-input
              v-model="filters.q"
              placeholder="Search Product"
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
    <section :class="itemView">
      <b-card
        v-for="product in products"
        :key="product.id"
        class="ecommerce-card"
        no-body
      >
        <div class="item-img text-center">
          <b-link :to="{ name: 'apps-e-commerce-product-details', params: { slug: product.slug } }">
            <b-img
              :alt="`${product.name}-${product.id}`"
              fluid
              class="card-img-top"
              :src="product.image"
            />
          </b-link>
        </div>

        <!-- Announcement Details -->
        <b-card-body>
          <div class="item-wrapper">
            <div class="item-rating">
              <ul class="unstyled-list list-inline">
                <li
                  v-for="star in 5"
                  :key="star"
                  class="ratings-list-item"
                  :class="{'ml-25': star-1}"
                >
                  <feather-icon
                    icon="StarIcon"
                    size="16"
                    :class="[{'fill-current': star <= product.rating}, star <= product.rating ? 'text-warning' : 'text-muted']"
                  />
                </li>
              </ul>
            </div>
            <div>
              <h6 class="item-price">
                ${{ product.price }}
              </h6>
            </div>
          </div>
          <h6 class="item-name">
            <b-link
              class="text-body"
              :to="{ name: 'view-all-announcements'}"
            >
              {{ product.name }}
            </b-link>
            <b-card-text class="item-company">
              By <b-link class="ml-25">
                {{ product.brand }}
              </b-link>
            </b-card-text>
          </h6>
          <b-card-text class="item-description">
            {{ product.description }}
          </b-card-text>
        </b-card-body>

        <!-- Product Actions -->
        <div class="item-options text-center">
          <div class="item-wrapper">
            <div class="item-cost">
              <h4 class="item-price">
                ${{ product.price }}
              </h4>
            </div>
          </div>
          <b-button
            variant="light"
            tag="a"
            class="btn-wishlist"
          >
            <feather-icon
              icon="HeartIcon"
              class="mr-50"
              :class="{'text-danger': product.isInWishlist}"
            />
            <span>Wishlist</span>
          </b-button>
          <b-button
            variant="primary"
            tag="a"
            class="btn-cart"
          >
            <feather-icon
              icon="ShoppingCartIcon"
              class="mr-50"
            />
            <span>{{ product.isInCart ? 'View In Cart' : 'Add to Cart' }}</span>
          </b-button>
        </div>
      </b-card>
    </section>

    <!-- Pagination -->
    <section>
      <b-row>
        <b-col cols="12">
          <b-pagination
            v-model="filters.page"
            :total-rows="totalProducts"
            :per-page="filters.perPage"
            first-number
            align="center"
            last-number
            prev-class="prev-item"
            next-class="next-item"
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
  BButton,
  BPagination,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { useResponsiveAppLeftSidebarVisibility } from '@core/comp-functions/ui/app'
import AnnouncementFilter from './AnnouncementFilter.vue'
import { mapGetters, mapActions } from "vuex";
import * as announcementTypes from "../../../store/announcements/announcementTypes";

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
    BImg,
    BCardText,
    BButton,
    BPagination,
    AnnouncementFilter,
  },
  data() {
    return {
      filters: {
        q: '',
        priceRangeDefined: 'all',
        priceRange: [0, 100],
        categories: [],
        brands: [],
        ratings: null,
        page: 1,
        perPage: 9,
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
      itemView: 'grid-view',
      itemViewOptions: [
        { icon: 'GridIcon', value: 'grid-view' },
        { icon: 'ListIcon', value: 'list-view' },
      ],
      totalProducts: 5,
      products: [
        {
          id: 1,
          name: 'VicTsing Wireless Mouse,',
          slug: 'vic-tsing-wireless-mouse-1',
          description:
            'After thousands of samples of palm data, we designed this ergonomic mouse. The laptop mouse has a streamlined arc and thumb rest to help reduce the stress caused by prolonged use of the laptop mouse.',
          brand: 'VicTsing',
          price: 10.99,
          // eslint-disable-next-line global-require, import/no-unresolved
          image: require('@/assets/images/pages/eCommerce/27.png'),
          hasFreeShipping: true,
          rating: 3,
        },
        {
          id: 2,
          name: 'Bose Frames Tenor - Rectangular Polarized, Bluetooth Audio Sunglasses',
          slug: 'bose-frames-tenor-rectangular-polarized-bluetooth-audio-sunglasses-2',
          description:
            'Redesigned for luxury — Thoughtfully refined and strikingly elegant, the latest Bose sunglasses blend enhanced features and designs for an elevated way to listen',
          brand: 'Bose',
          price: 249.0,
          // eslint-disable-next-line global-require, import/no-unresolved
          image: require('@/assets/images/pages/eCommerce/26.png'),
          hasFreeShipping: false,
          rating: 4,
        },
        {
          id: 3,
          name: 'Willful Smart Watch for Men Women 2020,',
          slug: 'willful-smart-watch-for-men-women-2020-3',
          description:
            'Are you looking for a smart watch, which can not only easily keep tracking of your steps, calories, heart rate and sleep quality, but also keep you informed of incoming calls.',
          brand: 'Willful',
          price: 29.99,
          // eslint-disable-next-line global-require, import/no-unresolved
          image: require('@/assets/images/pages/eCommerce/25.png'),
          hasFreeShipping: true,
          rating: 5,
        },
        {
          id: 4,
          name: 'Ronyes Unisex College Bag Bookbags for Women',
          slug: 'ronyes-unisex-college-bag-bookbags-for-women-4',
          description:
            'Made of high quality water-resistant material; padded and adjustable shoulder straps; external USB with built-in charging cable offers a convenient charging',
          brand: 'Ronyes',
          price: 23.99,
          // eslint-disable-next-line global-require, import/no-unresolved
          image: require('@/assets/images/pages/eCommerce/24.png'),
          hasFreeShipping: true,
          rating: 2,
        },
        {
          id: 5,
          name: 'Toshiba Canvio Advance 2TB Portable External Hard Drive',
          slug: 'toshiba-canvio-advance-2-tb-portable-external-hard-drive-5',
          description:
            'Up to 3TB of storage capacity to store your growing files and content',
          brand: 'Toshiba',
          price: 69.99,
          // eslint-disable-next-line global-require, import/no-unresolved
          image: require('@/assets/images/pages/eCommerce/23.png'),
          hasFreeShipping: true,
          rating: 2,
        },
      ],
    }
  },
  setup() {
    const { mqShallShowLeftSidebar } = useResponsiveAppLeftSidebarVisibility()
    return {
      mqShallShowLeftSidebar,
    }
  },
  created() {
    this.getAllAnnouncements()
  },
  methods: {
    ...mapActions({
      getAllAnnouncements: announcementTypes.ACTION_GET_ALL_ANNOUNCEMENTS,
    }),
  },
}
</script>
