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
                        <template v-slot:cell(actions)="data">
                            <b-button variant="warning" @click="deleteItem(data.item.id)">View</b-button>
                        </template>
                </b-table>
                <b-pagination v-model="currentPage" 
                    :total-rows="rows" 
                    :per-page="perPage">
                </b-pagination>
            </b-col>
        </b-row>
    </div>
</template>

<script>


export default {
    props: ['userData'],
    data: function(){
        return{
            fields: ["type","last_name","first_name","actions"],
            perPage: 5,
            currentPage:1,
            filter: ""
        }
    },
    computed: {
        rows() {
            return this.userData.length
        }
    },
    methods: {
        deleteItem(id){
            const index = this.userData.indexOf((x) => x.id ===id);
            this.userData.splice(index,1);
        }
    }
}
</script>