<template>
  <div>
    <bootstrap-vue-datatable :posts="posts"></bootstrap-vue-datatable>
  </div>
</template>

<script>
import RolesPrivilege from "./views/UserRolePrivilegeManagement/UserRoleandPrivileges/RolesPrivilege"
export default {
  name: "App",
  components:{
    RolesPrivilege,
  },
  
}
</script>