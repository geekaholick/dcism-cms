<template>
  <div class="container">
    <div class="addPrivilege">
      <input type="text" id="privilegeInput" placeholder="Add new role" v-model="privilege.permission" />
      <font-awesome-icon 
        icon="plus-square"
        @click="addPrivilege()"
        :class="[privilege.permission ? 'active' : 'inactive', 'plus']"
      />
    </div>
    <div class="privileges" v-for="(privilege, index) in privileges" :key="index">
        <privilege-list 
          :privilege="privilege"
          class="privilege"
          v-on:privilegeChanged="$emit('reloadPList')"
        />
    </div>
  </div>
</template>

<script>
import PrivilegeList from "./PrivilegeList"
import axios from 'axios'


export default {
  props: ['privileges'],
  components:{
    PrivilegeList
  },
  data: function(){
    return{
      privilege:{
        permission: ""
      }
    }
  },
  methods:{
    addPrivilege(){
      if(this.privilege.permission == ''){
        return;
      }
      axios.post('api/privilege/store',{
          privilege: this.privilege
      })
      .then(response => {
          if(response.status == 201){
            this.privilege.permission = "";
            this.$emit('reloadPList');
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
    .privileges{
      padding: 10px 10px 10px 10px;

    }
    .addPrivilege{
      padding: 10px 10px 10px 0px;
    }
</style>

