<template>

  <b-card>
    
    <b-media no-body>
      <b-media-aside>
        <b-link>
          <b-img
            ref="previewEl"
            rounded
            v-bind:src="users.user_image"
            height="80" 
          />
          
          
        </b-link>
        <!--/ avatar -->
      </b-media-aside>

      <b-media-body class="mt-75 ml-75">
        <!-- upload button -->
        <b-form-group
          label="Change Profile Picture"
          label-for="pp"
        >
          <b-form enctype="multipart/form-data">
            <b-row>
              <b-col >
                <input type="file" class="form-control" v-on:change="onChange">
              </b-col>
              <b-col>
                <b-button class="btn btn-primary btn-block" @click.prevent="formSubmit">Upload</b-button>
              </b-col>
            </b-row>
          </b-form>
        </b-form-group>
        <!--/ upload button -->

        <b-card-text>Allowed JPG, GIF or PNG. Max size of 800kB</b-card-text>
      </b-media-body>
    </b-media>
    <!--/ media -->

    <!-- form -->
    <b-form ref="anyName" class="mt-2" >
      
       <b-row>
         <b-col sm="6">
          <b-form-group             
            label="First Name"
            label-for="firstname"            
          >
          
            <b-form-input              
              v-model="users.first_name"
              name="first-name"
              placeholder="First Name"
              required
            />
              
          </b-form-group>
         </b-col>
         <b-col sm="6">
          <b-form-group           
            label="Last Name"
            label-for="lastname"
          >
            <b-form-input
              v-model="users.last_name"
              name="last-name"
              placeholder="Last Name"
              required
            />
              
          </b-form-group>
         </b-col>
         <b-col sm="6">
          <b-form-group
            label="E-mail"
            label-for="email"
          >
            <b-form-input
              v-model="users.user_email"
              name="email-add"
              placeholder="Email"
              
              required
            />
              
          </b-form-group>
         </b-col>
       </b-row>
    
    
    <b-col>
      
      <b-button
        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
        variant="primary"
        class="mt-2 mr-1"
        type="submit"
        @click.prevent="edituser"
      >
        Save changes
      </b-button>
      <b-button
        v-ripple.400="'rgba(186, 191, 199, 0.15)'"
        variant="outline-secondary"
        type="reset"
        class="mt-2"
        @click.prevent="resetForm()"
      >
            Reset
      </b-button>
    </b-col>
   </b-form>
    
  </b-card>
</template>

<script>

import {
  BFormFile, BButton, BForm, BFormGroup, BFormInput, BRow, BCol, BAlert, BCard, BCardText, BMedia, BMediaAside, BMediaBody, BLink, BImg,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import axios from 'axios'
export default {
  components: {
    BButton,
    BForm,      
    BFormGroup,
    BFormInput,
    BCardText,
    BImg,
    BMedia,
    BMediaAside,
    BMediaBody,    
    BRow,
    BFormFile,
    BCol,    
    BCard,       
    BLink,
  },
  directives: {
    Ripple,
  },
  props: {
    generalData: {
      
      type: Object,
      default: () => {},
    },
  },
  
  data() {
    return {        
      profileFile: '',
      users:'',
      temp:'',
      name: '',
      file: '',
      success: '',
      id:'',    
                
    };
  },
  created(){
     //temporarily setting id deletable line 172
    localStorage.setItem('user_id',1);
    this.id=localStorage.getItem('user_id');
    
    
    axios.get('api/studsetting/'+this.id)  
    .then(response => {this.users = response.data});
    axios.get('api/studsetting/'+this.id)  
    .then(response => {this.temp= response.data});
   
    
  },
  methods: {
    sayhello() {
      alert("hello");
    },
    resetForm() {
     this.users.first_name=this.temp.first_name;
     this.users.last_name=this.temp.last_name;
     this.users.user_email=this.temp.user_email;
    },
    edituser(){
       
      axios.post('api/updatestudinfo',{
         first_name : this.users.first_name,
         last_name: this.users.last_name,
         email: this.users.user_email
        })
        .then(response =>{window.location.reload();});
       
      console.log(this.users.first_name);
      
    },
     
    onChange(e){
                this.file = e.target.files[0];
    },
    formSubmit(e){                
                let id=localStorage.getItem('user_id');
                e.preventDefault();
                let existingObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                let data = new FormData();
                data.append('file', this.file);
                data.append('id',id);            
                axios.post('api/upload', data, config)
                    .then(function (res) {existingObj.success = res.data.success;})                 
                    .catch(function (err) {existingObj.output = err;});    
                    
                        
                    
    },          
  },
  mounted() {      
  }
}

</script>
