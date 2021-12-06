<template>
    <div>
        <!-- New memo form -->
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-side">Edit Memo</h3><br>
                <form method="POST" enctype="multipart/form-data" @submit.prevent="updateMemo">
                    <div class="form-group">
                        <label>Memo Title:</label>
                        <input type="text" class="form-control" v-model="memos.title" required>
                    </div>
                    <div class="form-group">
                        <label>Description: </label>
                        <input type="text" class="form-control" v-model="memos.short_desc" required>
                    </div>
                    <div class="form-group">
                        <label>Effective on: </label>
                        <input type="date" class="form-control" v-model="memos.effectivity_date" required>
                    </div>
                    <div class="form-group">
                        <label>Issued on: </label>
                        <input type="date" class="form-control" v-model="memos.issued_date" required>
                    </div>
                    <div class="form-group">
                        <label>Upload file: </label>
                        <input type="file" class="form-control" @change="selectFile" required>
                    </div><br>

                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-md-6">
                <center style="margin-top: 50px; margin-bottom: 10px;">
                    <label>Memo file currently in record: </label><br>
                </center>
                <b-img center :src="image_path" height="500px" width="500px" alt=""></b-img><br>
            </div>
        </div>
    </div>
</template>

<script>
//import { defineComponent } from '@vue/composition-api'
import axios from 'axios';
import moment from 'moment';
import { BImg, BRow, BCol } from 'bootstrap-vue'

export default ({
    components: {
        axios,
        moment,
        BImg, 
        BRow,
        BCol,
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
                issued_date: '',
            },
            image_path: '/storage/memoFiles/',
        }
    },
    created(){
        this.getMemos();
    },
    methods: {
        getMemos(){
            axios.get('/api/memos/show/' + this.$route.params.id)
                .then( res => {
                    this.memos = res.data.data;
                })
                .then( res => {
                    this.image_path = this.image_path + this.memos.file_path;
                })
                .catch( error => {
                    console.log(error);
                })
        },
        selectFile(event) {
            this.memos.file_path = event.target.files[0];
        },
        updateMemo(){
            let data = new FormData();

            data.append('title', this.memos.title);
            data.append('desc', this.memos.short_desc);
            data.append('effDate', this.format_date(this.memos.effectivity_date));
            data.append('issDate', this.format_date(this.memos.issued_date));
            data.append('file', this.memos.file_path);

            axios.post('/api/memos/edit/' + this.$route.params.id,  data)
                .then ((responses) => (
                    this.$router.push({ name: 'MemoDetails', params: {id : this.$route.params.id}})
                ))
                .then ((responses) => (
                    this.$swal('Update', 'Successfully updated the memo', 'success')
                ))
                .catch(error => console.log(error))
        },
        format_date(value){
            if(value){
                return moment(String(value)).format("YYYY-MM-DD");
            }
        }
    }
})
</script>
