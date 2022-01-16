<template>
    <div>
        <b-row>
            <b-col md="3">
                <b-form-input 
                    v-model="filter" 
                    type="search" 
                    placeholder="Search">
                </b-form-input>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-table striped hover 
                    :items="userData" 
                    :filter="filter" 
                    :per-page="perPage" 
                    :current-page="currentPage"
                    :fields="fields">
                        <template v-slot:cell(Role)="data">
                             <b-button variant="success" @click="viewUserRole(data.item.user_id)" v-b-modal.user-role>Edit</b-button>
                        </template>
                        <template v-slot:cell(Privilege)="data">
                             <b-button variant="success" @click="viewUserPrivilege(data.item.user_id)" v-b-modal.user-privilege>Edit</b-button>
                        </template>
                </b-table>
                <b-pagination v-model="currentPage" 
                    :total-rows="rows" 
                    :per-page="perPage">
                </b-pagination>
            </b-col>
        </b-row>
        <b-modal id="user-role" centered title="Edit Role" ok-only>
            <user-role-view 
                :userDatum="userDatum" :roles="roles"
                v-on:reloadUR="viewUserRole($event)"
            />
        </b-modal>
        <b-modal id="user-privilege" centered title="Edit Privileges" ok-only>
            <user-privilege-view
                :userDatum2="userDatum2" :privileges="privileges"
                v-on:reloadUP="viewUserPrivilege($event)"
            />
        </b-modal>
    </div>
</template>

<script>
import UserRoleView from "./UserRoleView"
import UserPrivilegeView from "./UserPrivilegeView"
import axios from 'axios'


export default {
    components:{
        UserRoleView,
        UserPrivilegeView,
    },
    props: ['userData'],
    data: function(){
        return{
            fields: ["type","last_name","first_name","Role","Privilege"],
            perPage: 5,
            currentPage:1,
            filter: "",
            userDatum: [],
            userDatum2: [],
            roles: [],
            privileges:[]
        }
    },
    computed: {
        rows() {
            return this.userData.length
        }
    },
    methods: {
        viewUserRole(id){
            axios.get('api/user-role-privilege/'+ id)
            .then( response => {
                this.userDatum = response.data
            })
            .catch( error =>{
                console.log( error );
            })
            //const index = this.userData.indexOf((x) => x.id ===id);
            //this.userData.splice(index,1);
        },
        viewUserPrivilege(id){
            axios.get('api/user-role-privilege/show2/'+ id)
            .then( response => {
                this.userDatum2 = response.data
            })
            .catch( error =>{
                console.log( error );
            })
            //const index = this.userData.indexOf((x) => x.id ===id);
            //this.userData.splice(index,1);
        },
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
    },
    created(){
        this.viewUserRole();
        this.viewUserPrivilege();
        this.getRoles();
        this.getPrivileges();
    }
}
</script>