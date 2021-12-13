<template>
  <div class="container">
      <div>
        <h2>Modal</h2>
        <b-button v-b-modal.privilege-modal>View Privileges</b-button>
        <b-modal id="privilege-modal">
          <privilege-view 
            :privileges="privileges"
          />
        </b-modal>
        <b-button v-b-modal.role-modal>View Roles</b-button>
        <b-modal id="role-modal">
          <role-view 
            :roles="roles"
          />
        </b-modal>
      </div>
      <div>
        <h2>DataTable</h2>
        <user-data-table
          :userData="userData"
        />
      </div>
  </div>
</template>

<script>
import PrivilegeView from "./PrivilegeView"
import RoleView from "./RoleView"
import RolesPrivilege from "./RolesPrivilege"
import UserDataTable from "./UserDataTable"
import axios from 'axios'


export default {
  components:{
      PrivilegeView,
      RoleView,
      RolesPrivilege,
      UserDataTable
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