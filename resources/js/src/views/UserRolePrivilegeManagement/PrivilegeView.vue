<template>
  <div class="container pt-3 pb-5">
    <h2>Privilege</h2>
    <div class="addPrivilege">
      <input type="text" v-model="privilege.permission" />
      <font-awesome-icon 
        icon="plus-square"
        @click="addPrivilege()"
        :class="[privilege.permission ? 'active' : 'inactive', 'plus']"
      />
    </div>
    <div v-for="(privilege, index) in privileges" :key="index">
        <privilege-list 
          :privilege="privilege"
          class="privilege"
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