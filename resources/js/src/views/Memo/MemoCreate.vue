<template>
    <div>
        <!-- New memo form -->
        <h3 class="text-side">Post a Memo</h3><br>
        <div class="row">
            <div class="col-md-6">
                <form method="POST" enctype="multipart/form-data" @submit.prevent="addMemo" required>
                    <div class="form-group">
                        <label>Memo Title:</label>
                        <input type="text" class="form-control" v-model="title" required>
                    </div>
                    <div class="form-group">
                        <label>Description: </label>
                        <input type="text" class="form-control" v-model="desc" required>
                    </div>
                    <div class="form-group">
                        <label>Effective on: </label>
                        <input type="date" class="form-control" v-model="effDate" required>
                    </div>
                    <div class="form-group">
                        <label>Issued on: </label>
                        <input type="date" class="form-control" v-model="issDate" required>
                    </div>
                    <div class="form-group">
                        <label>Upload file: </label>
                        <input type="file" class="form-control" @change="selectFile" required>
                    </div><br>

                    <button class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
//import { defineComponent } from '@vue/composition-api'
import axios from 'axios';

export default ({
    components: {
        axios,
    },
    data(){
        return{
            title: '',
            desc: '',
            effDate: '',
            issDate: '',
            file: '',
        }
    },
    methods: {
        selectFile(event) {
            this.file = event.target.files[0];
        },
        addMemo(){
            let data = new FormData();

            data.append('title', this.title);
            data.append('desc', this.desc);
            data.append('effDate', this.effDate);
            data.append('issDate', this.issDate);
            data.append('file', this.file);

            axios.post('/api/memos',  data)
                .then ((responses) => (
                    this.$router.push({ name: 'Memos'})
                ))
                .then ((responses) => (
                    this.$swal('Posted', 'Successfully posted new memo', 'success')
                ))
                .catch(error => console.log(error))
        }
    }
})
</script>
