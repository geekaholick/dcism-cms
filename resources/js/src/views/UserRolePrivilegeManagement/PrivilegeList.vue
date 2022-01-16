<template>
  <div class="privilege">
      <span>{{ privilege.permission }}</span>
      <button @click="removePrivilege()" class="trashcan">
          <font-awesome-icon icon="trash"/>
      </button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: ['privilege'],
  methods:{
      removePrivilege() {
          axios.delete('api/privilege/' + this.privilege.privilege_id)
          .then(response=>{
              if(response.status == 200){
                  this.$emit('privilegeChanged');
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
    span{
        font-size: 20px;
        font-style: normal;
        color: black;
    }
</style>