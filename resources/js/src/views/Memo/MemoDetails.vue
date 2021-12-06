<template>
  <div>
    <b-card
        v-for="memo in memos" 
        :key="memo.memo_id"
    ><br>
    <b-card-title><h2>{{ memo.title }}</h2></b-card-title>
      <b-row>
        <b-col md="6">
          <b-card-text>
            <b>Posted on: </b>
            {{ memo.updated_at | formatDate}}
          </b-card-text>
          <b-card-text>
              <b>Effective on: </b> 
              {{ memo.effectivity_date | formatDate }}
          </b-card-text>
          <b-card-text>
              <b>Issued on:  </b> 
              {{ memo.issued_date | formatDate }}
          </b-card-text>
          <b-card-text>
              <b>Description:  </b> 
              {{ memo.short_desc }}
          </b-card-text>
          <div style="margin-top: 50px;">
            <b-button href="#" variant="primary" v-on:click="editMemo(memo.memo_id)">Edit</b-button>
            <b-button href="#" variant="danger" v-on:click="destroyMemo(memo.memo_id)">Delete</b-button>
          </div>
        </b-col>
        <b-col md="6">
            <expandable-image
                class="image"
                :src="'/storage/memoFiles/' + memo.file_path"
                :alt="memo.title"
                title="dog"
            />
            <br>
        </b-col> 
      </b-row>
    </b-card>
    
  </div>
</template>

<script>
import { BCard, BCardText, BImg, BRow, BCol, BCardImg, BCardTitle } from 'bootstrap-vue'
import { BButton } from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import axios from 'axios';

export default {
  directives: {
    Ripple,
  },
  components: {
    BCard,
    BCardText,
    BCardTitle,
    BButton,
    BImg,
    BRow, 
    BCol,
    BCardImg,
  },
  data(){
    return{
      memos: [],
      memos: {
        memo_id: '',
        title: '',
        short_desc: '',
        file_path: '',
        effectivity_date: '',
        issued_date:'',
      },
    }
  },
  created(){
    this.getMemos();
  },
  methods: {
    getMemos(){
      axios.get('/api/memos/show/' + this.$route.params.id)
        .then( res => {
          this.memos = res.data;
        })
        .catch( error => {
          console.log(error);
        })
    },
    editMemo(memo_id){
      this.$router.push({ name: 'MemoEdit', params: {id : memo_id}});
    },
    destroyMemo(id){
        this.$swal({
          title: 'Delete?',
          text: 'Are you sure you want to delete this memo? You can\'t revert your action',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes Delete it!',
          cancelButtonText: 'No, Keep it!',
          showCloseButton: true,
          showLoaderOnConfirm: true
        }).then((result) => {
          if(result.value) {
            axios.delete('/api/memos/show/' + id)
              .then( res => {
                this.$router.push({ name: 'Memos' });
              })
              .catch( error => {
                console.log(error);
              })

              this.$swal('Deleted', 'You successfully deleted this memo', 'success');
          } else {
            this.$swal('Cancelled', 'The memo is still intact', 'info');
          }
        })
      }
  }
};
</script>

<style>

</style>
