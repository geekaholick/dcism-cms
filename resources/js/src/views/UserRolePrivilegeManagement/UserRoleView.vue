<template>
    <div>
        <h2>User Role</h2>
        <div v-for="(x, id) in userDatum.user" :key="id">
            <span>{{x.type}}</span>
        </div>
        <h2>Role Available</h2>
        <div v-for="(role, role_id) in roles" :key="role_id">
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
</style>