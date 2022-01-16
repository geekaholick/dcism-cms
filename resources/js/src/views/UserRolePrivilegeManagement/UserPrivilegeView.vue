<template>
    <div class="container">
        <h3>User Privileges</h3>
        <div class="userPrivileges" v-for="(datum2, index) in userDatum2.userPrivilege" :key="index">
            <span>{{datum2.permission}}</span>
            <button @click="deletePrivilege(datum2.id)" class="trashcan">
                <font-awesome-icon icon="trash"/>
            </button>
        </div>
        <h3>Available Privileges</h3>
        <div class="availablePrivileges" v-for="(privilege, privilege_id) in privileges" :key="privilege_id">
            <span>{{privilege.permission}}</span>
            <button @click="addPrivilege(privilege.privilege_id)" class="plus">
                <font-awesome-icon icon="plus-square"/>
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {

    props: ['userDatum2','privileges'],
    data: function(){
        return{
            datum2:{
                permission: ""
            },
            privilege:{
                type: ""
            },
        }
    },
    methods:{
      deletePrivilege(id) {
          axios.delete('api/user-role-privilege/' + id)
          .then(response=>{
              if(response.status == 200){
                 this.$emit('reloadUP', this.userDatum2.id);
              }
          })
          .catch (error=>{
              console.log(error);
          })
      },
      addPrivilege(id) {
          axios.post('api/user-role-privilege/store/'+ this.userDatum2.id + '/' + id)
          .then(response=>{
              if(response.status == 201){
                 this.$emit('reloadUP', this.userDatum2.id);
              }
          })
          .catch (error=>{
              console.log(error);
          })
      }
  }
}
</script>

<style scoped>
    .trashcan{
        background: #e6e6e6;
        border: none;
        color: #FF0000;
        outline: none;
    }

    .plus{
        background: #e6e6e6;
        border: none;
        color: #00CE25;
        outline: none;
    }

    .userPrivileges{
      padding: 0px 10px 10px 10px;

    }
    .availablePrivileges{
      padding: 0px 10px 10px 10px;
    }
    span{
        font-size: 15px;
        font-style: normal;
        color: black;
    }
    h3{
        font-weight: bold;
    }
</style>