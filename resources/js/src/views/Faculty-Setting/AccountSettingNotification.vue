<template>
  <b-card>
    <b-row>
      <!-- application switch -->
      <h6 class="section-label mx-1 mt-2">
        Application
      </h6>
      <b-col
        cols="12"
        class="mt-1 mb-2"
      >
        <b-form-checkbox
          id="accountSwitch4"
          name="check-button"
          switch
          inline
        >
          <span>News and announcements</span>
        </b-form-checkbox>
      </b-col>
      <b-col
        cols="12"
        class="mb-2"
      >
        <b-form-checkbox
          id="accountSwitch5"
          name="check-button"
          switch
          inline
        >
          <span>Weekly Memo Updates</span>
        </b-form-checkbox>
      </b-col>
      <b-col
        cols="12"
        class="mb-2"
      >
        <b-form-checkbox
          id="accountSwitch6"
          name="check-button"
          switch
          inline
        >
          <span>Weekly Calendar of Activities Updates</span>
        </b-form-checkbox>
      </b-col>
      <!--/ application switch -->

      <!-- buttons -->
      <b-col cols="12">
        <b-button
          v-ripple.400="'rgba(255, 255, 255, 0.15)'"
          variant="primary"
          class="mr-1 mt-1"
        >
          Save changes
        </b-button>
        <b-button
          v-ripple.400="'rgba(186, 191, 199, 0.15)'"
          type="reset"
          class="mt-1"
          variant="outline-secondary"
        >
          Cancel
        </b-button>
      </b-col>
      <!--/ buttons -->
    </b-row>
  </b-card>
</template>

<script>
import {
  BButton, BRow, BCol, BCard, BFormCheckbox,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'

export default {
  components: {
    BButton,
    BRow,
    BCol,
    BCard,
    BFormCheckbox,
  },
  directives: {
    Ripple,
  },
  props: {
    notificationData: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      localOptions: JSON.parse(JSON.stringify(this.notificationData)),
    }
  },
}
</script>
