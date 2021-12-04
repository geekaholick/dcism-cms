<template>
  <b-card>
    <b-row>
      <b-col>
        Account ID: {{users.user_id}}
      </b-col>
      <b-col md="6">
        Role: <span v-if="users.role_id === 1">admin</span>
              <span v-else-if="users.role_id === 2">faculty</span>
              <span v-else>student</span>
      </b-col>
      <b-col md="6">
        Verified: <span v-if="users.verified === 1">yes</span>
                  <span v-else-if="id === 0">no</span>
          
      </b-col>
    </b-row>
    <b-row>
      
    </b-row>
  </b-card>
</template>

<script>

import {
   BRow, BCol, BCard,BLink
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import axios from 'axios'
export default {
  components: {
    
    BRow,
    BCol,    
    BCard,     
    BLink,
  },
  directives: {
    Ripple,
  },
  props: {
    generalData: {
      type: Object,
      default: () => {},
    },
  },
  
  data() {
    return {
        id:'',
        users:'',
       
    };
  },
  created(){
    //deletable line 58
    localStorage.setItem('user_id',1);
    this.id=localStorage.getItem('user_id');
    axios.get('api/studsetting/'+this.id)  
    .then(response => {this.users = response.data});
  },
  methods: {      
  },

  
  mounted() {  
  }
}
</script>
