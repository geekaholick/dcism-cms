<template>
  <div>
    <router-link 
      :to = "{name: 'MemoCreate'}" 
      v-ripple.400="'rgba(255, 255, 255, 0.15)'"
      variant="primary"
      class="btn btn-primary mb-2"
    >
    Post new Memo
    </router-link>

    <b-card 
      v-for="memo in memos" 
      :key="memo.memo_id"
      :header="memo.title"
      header-text-variant="white"
      header-tag="h2"
      header-bg-variant="primary"
    >
    <br>
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

          <div style="margin-top: 50px;">
            <b-button href="#" variant="primary" v-on:click="showMemo(memo.memo_id)">View</b-button>
            <b-button href="#" variant="danger" v-on:click="destroyMemo(memo.memo_id)">Delete</b-button>
          </div>
        </b-col>
        <b-col md="6">
          <b-img right :src="'/storage/memoFiles/' + memo.file_path" height="500px;" width="500px;" alt=""></b-img><br>
        </b-col> 
      </b-row>
    </b-card>
    
  </div>
</template>

<script>
import { BCard, BCardText, BImg, BRow, BCol, BCardImg } from 'bootstrap-vue'
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
    BButton,
    BImg,
    BRow, 
    BCol,
    BCardImg,
  },
  data(){
    return{
      memos: []
    }
  },
  created(){
    this.getMemos();
  },
  methods: {
    getMemos(){
      axios.get('/api/memos')
        .then( res => {
          this.memos = res.data.data
        }).catch( error => {
          console.log(error);
        })
    },
    showMemo(memo_id){
      this.$router.push({ name: 'MemoDetails', params: {id : memo_id}});
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
                location.reload();
              }).catch( error => {
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
