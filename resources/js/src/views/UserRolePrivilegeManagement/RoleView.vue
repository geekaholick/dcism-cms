<template>
  <div class="container pt-3 pb-5">
    <h2>Role</h2>
    <div class="addRole">
      <input type="text" v-model="role.type" />
      <font-awesome-icon 
        icon="plus-square"
        @click="addRole()"
        :class="[role.type ? 'active' : 'inactive', 'plus']"
      />

    </div>
    <div v-for="(role, index) in roles" :key="index">
        <role-list 
          :role="role"
          class="role"
          v-on:itemChanged="$emit('reloadRList')"
        />
    </div>
  </div>
</template>

<script>
import RoleList from "./RoleList"
import axios from 'axios'

export default {
  props: ['roles'],
  components:{
    RoleList
  },
  data: function(){
    return{
      role:{
        type: ""
      }
    }
  },
  methods:{
    addRole(){
      if(this.role.type == ''){
        return;
      }
      axios.post('api/role/store',{
          role: this.role
      })
      .then(response => {
          if(response.status == 201){
            this.role.type = "";
            this.$emit('reloadRList');
          }
      })
      .catch(error => {
          console.log(error);
      })
    }
  }
}
</script>

<style scoped>
    .plus{
      font-size: 20px;
    }
    .active{
      color: #00CE25;
    }
    .inactive{
      color: #999999;
    }
</style>