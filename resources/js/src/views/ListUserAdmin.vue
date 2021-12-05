<template>
  <div>
    <b-row class="utilities">
      <b-col md="3">
        <b-form-input
          class="searchBar"
          v-model="filter"
          type="search"
          placeholder="search"
        ></b-form-input>
      </b-col>
      <b-pagination 
          class="pagination"
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
          size="lg"
      ></b-pagination>
    </b-row>
    <b-row>
      <b-col>
        <b-table
          striped
          hover
          ref="datatable"
          :v-if="render"
          :items="User"
          :filter="filter"
          :per-page="perPage"
          :current-page="currentPage"
          :fields="fields"
        >
          <template v-slot:cell(update)="data">
              <b-button variant="success" @click="redirect(data)">Update</b-button>
          </template>   
          <template v-slot:cell(delete)="data">
              <b-button variant="danger" @click="deleteUser(data.item.user_id)">Delete</b-button>
          </template>     
          <template v-slot:cell(user_image)="data">
              <img id="img" :src = data.item.user_image>
          </template>
        </b-table>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { BCard, BCardText, BLink } from "bootstrap-vue";
import {EventBus} from '@/EventBus';
import axios from 'axios';

export default {
  props: ["User"],
  data: () => ({
    fields: ["user_id", "user_image", "role_id", "user_email", "first_name", "last_name", "delete", "update"],
    perPage: 10,
    currentPage: 1,
    filter: "",
    render: true
  }),
  computed: {
    rows() {
      return this.User.length;
    },
  },
  methods: {
    deleteUser(id) {
        axios({
        headers: { "Content-Type": "multipart/form-data" },
        method: "delete",
        url: "/api/FacultyUser/" + id
      })
      .catch(function (error) {
         console.log(error);
      });
      let deleteIndex = this.User.findIndex(item => item.user_id === id);
      this.User.splice(deleteIndex, 1);
    },
    redirect (data) {
      EventBus.$emit("passed_user", data);
    }
  },
  components: {
    BCard,
    BCardText,
    BLink,
  },
};
</script>

<style scoped>
.searchBar {
  margin-top: 0.65em;
  margin-left: 2em;
}

.utilities {
  width: 100%;
  height: 4em;
  background: #d9d9d9;
}

.pagination {
  margin-left: 4em;
  margin-top: 0.65em;
}

.User {
  background: #e6e6e6;
  padding: 5px;
  margin-top: 5px;
}

#img {
  width: 9em;
  height: 8em;
}
</style>
