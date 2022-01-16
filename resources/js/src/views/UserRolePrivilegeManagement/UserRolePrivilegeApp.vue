<template>
    <div class="container">
        <div class="bigBox">
          <div class="boxes" id="box1">
            <b-button v-b-modal.privilege-modal variant="primary">View Privileges</b-button>
            <b-modal id="privilege-modal" centered title="Privileges" ok-only>
              <privilege-view 
                :privileges="privileges"
                v-on:reloadPList="getPrivileges()"
              />
            </b-modal>
          </div>
          <div class="boxes" id="box2">
            <b-button v-b-modal.role-modal variant="primary">View Roles</b-button>
            <b-modal id="role-modal" centered title="Roles" ok-only>
              <role-view 
                :roles="roles"
                v-on:reloadRList="getRoles()"
              />
            </b-modal>
          </div>
        </div>
        <div class="bigBox">
          <div class="boxes" id="box3">
            <user-data-table
              :userData="userData"
            />
          </div>
        </div>
    </div>
</template>

<script>
import PrivilegeView from "./PrivilegeView"
import RoleView from "./RoleView"
import UserDataTable from "./UserDataTable"
import axios from 'axios'




export default {
  components:{
      PrivilegeView,
      RoleView,
      UserDataTable,
  },
  data: function() {
    return{
      roles: [],
      privileges: [],
      userData: [],
    }
  },
  methods:{
    getRoles() {
      axios.get('api/roles')
      .then( response => {
        this.roles = response.data
      })
      .catch( error =>{
        console.log( error );
      })
    },
    getPrivileges() {
      axios.get('api/privileges')
      .then( response => {
        this.privileges = response.data
      })
      .catch( error =>{
        console.log( error );
      })
    },
    getUserData() {
      axios.get('api/user-roles-privileges')
      .then( response => {
        this.userData = response.data
      })
      .catch( error =>{
        console.log( error );
      })
    },
  },
  created(){
    this.getRoles();
    this.getPrivileges();
    this.getUserData();
  }
  
}
</script>

<style>
  .boxes{
    padding: 10px;
  }

  .bigBox{
    padding: 0px 25px 50px 0px;
  }

  #box1{
    float:right;
  }

  #box2{
    float:right;
  }


</style>