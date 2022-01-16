<template>
    <div class="container">
        <h3>User Role</h3>
        <div class="userRole" v-for="(x, id) in userDatum.user" :key="id">
            <span>{{x.type}}</span>
        </div>
        <h3>Role Available</h3>
        <div class="availableRoles" v-for="(role, role_id) in roles" :key="role_id">
            <span>{{role.type}}</span>
            <button @click="updateRole(role.role_id)" class="trashcan">
                <font-awesome-icon icon="plus-square"/>
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    props: ['userDatum','roles'],
    data: function(){
        return{
            datum:{
                type: ""
            },
        }
    },
    methods:{
        updateRole(id) {
            axios.put('api/user-role-privilege/' + id + '/' + this.userDatum.id)
            .then(response=>{
                if(response.status == 200){
                    this.$emit('reloadUR', this.userDatum.id);
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
        color: #00CE25;
        outline: none;
    }
    .userRole{
      padding: 0px 10px 10px 10px;
    }
    .availableRoles{
      padding: 0px 10px 10px 10px;
      float: left;
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