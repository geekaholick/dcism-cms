<template>
  <div class="role">
      <span>{{ role.type }}</span>
      <button @click="removeRole()" class="trashcan">
          <font-awesome-icon icon="trash"/>
      </button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: ['role'],
  methods:{
      removeRole() {
          axios.delete('api/role/' + this.role.role_id)
          .then(response=>{
              if(response.status == 200){
                  this.$emit('itemChanged');
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