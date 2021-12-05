<template>
  <div class="addUser" v-if="render">
    <b-form
      enctype="multipart/form-data"
    >
      <b>FIRST NAME:</b> <br />
      <b-input
        type="text"
        v-model="first_name"
        placeholder="enter first name"
        required
      >
      </b-input>
      <br />

      <b>LAST NAME:</b> <br />
      <b-input
        type="text"
        v-model="last_name"
        placeholder="enter last name"
        required
      >
      </b-input>
      <br />

      <b>EMAIL ADDRESS:</b> <br />
      <b-input
        type="email"
        v-model="user_email"
        placeholder="enter email address"
        required
      >
      </b-input>
      <b-alert id="alert" v-model="showDismissibleAlert_email" variant="danger" dismissible fade>
      <b id="alertcontent">EMAIL ALREADY TAKEN</b>
      </b-alert> <br />

      <b>PASSWORD:</b> <br />
      <b-input
        type="password"
        v-model="user_password"
        placeholder="enter password"
        required
      >
      </b-input>
      <br />

      <b>IMAGE UPLOAD:</b> <br />
      <b-form-file
        class="file"
        type="file"
        ref="imgUp"
        @change="handleFileUpload($event)"
        accept="image/png, image/bmp, image/jpeg"
        placeholder="Choose a file"
        size="sm"
        :required="file_input"
      >
      </b-form-file>
      <br />
      <b-alert id="alert" v-model="showDismissibleAlert_image" variant="danger" dismissible fade>
       <b id="alertcontent">PLEASE UPLOAD IMAGES ONLY</b>
      </b-alert>
      <br />

      <div v-if="roleToggle">
      <b>ROLE:</b> <br />
      <b-form-select
        class="end"
        v-model="role_id"
        :options="options"
        size="sm"
      ></b-form-select> <br>
      </div>

      <b-button
        v-if="toggle"
        type="submit"
        variant="gradient-success"
        id="add"
        @click="FormState( $event )"
        >Add User</b-button
      >

      <b-button
        v-if="(!toggle)"
        type="submit"
        variant="gradient-success"
        id="update"
        @click="FormState( $event )"
        >Update User</b-button
      >

      <b-button
        v-if="(!toggle)"
        type="reset"
        variant="gradient-success"
        id="cancel-update"
        @click="FormState( $event )"
        >Cancel Update</b-button
      >
    </b-form>
    <div id="preview">
      <img v-if="url" height="180em" width="330em" :src="url"/>
    </div>
  </div>
</template>

<script>
import { BCard, BCardText, BLink, BSidebar, BButton } from "bootstrap-vue";
import {EventBus} from '@/EventBus';
import axios from "axios";
export default {
  components: {
    BCard,
    BCardText,
    BLink,
    BSidebar,
    BButton,
  },
  data: function () {
    return {
      User: [],
      options: [
        { value: null, text: "Please select a role" },
        { value: 1, text: "Head" },
        { value: 2, text: "Faculty" },
        { value: 3, text: "Student"}
      ],
      toggle: true,
      validationCheck: true,
      passed_id: "",
      first_name: "",
      last_name: "",
      role_id: "3",
      user_email: "",
      user_password: "",
      user_image: "",
      url: null,
      render: true,
      file_input: true,
      showDismissibleAlert_email: false,
      showDismissibleAlert_image: false,
      roleToggle: false
    };
  },

  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
      this.url = URL.createObjectURL(this.file);
    },
    stub () {

    },
    updateStateReset () {
    this.render = false;
    this.roleToggle = false;
    this.$nextTick(function (){
       this.render = true;
    })
    this.first_name = "",
    this.last_name = "",
    this.role_id = "1",
    this.user_email = "",
    this.user_password = "",
    this.url = false,
    this.toggle = true
    },
    validationWarning (res) {
      if(res.data === "email"){
         this.showDismissibleAlert_email = true;
      }else if(res.data === "image"){
        this.showDismissibleAlert_image = true;
       }
    },
    FormState( e ) {
      var data = new FormData();
      data.append("first_name", this.first_name);
      data.append("last_name", this.last_name);
      data.append("user_email", this.user_email);
      data.append("user_password", this.user_password);
      data.append("role_id", this.role_id);
      if(e.target.id === "add"){
      data.append("user_image", this.file);
      axios({
        headers: { "Content-Type": "multipart/form-data" },
        method: "post",
        url: "/api/StudentUser/store",
        data: data,
      })
        .then((res) => {
          // check if the request is successful
          this.$emit("task-created");
          this.validationWarning (res);
        })
        .catch(function (error) {
          console.log(error);
        });
      }else{
        if(e.target.id === "update"){
        if( this.first_name && this.last_name && this.user_email && this.user_password ){
        //Error trapping if user doesn't upload file and keeps same picture
        if(typeof this.file === 'undefined' ){
        data.append("user_image", this.url);
        }else{
        data.append("user_image", this.file); 
        }
        //Error trap end
        data.append("_method", "put");
        axios({
        headers: { "Content-Type": "multipart/form-data" },
        method: "post",
        url: "/api/StudentUser/" + this.passed_id,
        data: data, 
        })
        .then((res) => {
          // check if the request is successful
          this.$emit("task-created");
          this.validationWarning (res);
        })
        .catch(function (error) {
          console.log(error);
        });
        }
      }else if(e.target.id === "cancel-update"){
          this.updateStateReset()
          this.file_input = true;
      }
      }
    },
  },
  mounted () {
    if(EventBus){
    EventBus.$on("passed_user", data => {
      this.updateStateReset();
      this.User = data.item;
      this.passed_id = this.User.user_id;
      this.first_name = this.User.first_name;
      this.last_name = this.User.last_name;
      this.role_id = this.User.role_id;
      this.user_email = this.User.user_email;
      this.user_password = this.User.user_password;
      this.url = this.User.user_image;
      this.toggle = false;
      this.file_input = false;
      this.roleToggle = true;
    })
  }
  }
};
</script>

<style>
</style>

<style scoped>
.addUser {
  position: relative;
  width: 90%;
  background: #d9d9d9;
  margin: 20px 37px 37px 70px;
  padding: 15px 30px 60px 15px;
}

#add, #update, #cancel-update {
  float: right;
  width: 20%;
  margin-top: 0.1em;
  margin-right: 0.5em;
}

.plus {
  font-size: 15px;
  border-radius: 5px 5px 5px 5px;
  color: white;
}

.active {
  background-color: #33cc33;
}

.inactive {
  background-color: #999999;
}

input, .file{
  width: 65%;
  margin: 5px 15px 5px 15px;
}

#alert {
  width: 65%;
  margin: 5px 15px 5px 15px;
  height: 3em;
  text-align: center;
}

#alertcontent {
  font-size: 2em;
}

b {
  font-size: 15px;
}

select {
  width: 20%;
  margin: 5px 15px 5px 15px;
}

#preview {
  position: absolute;
  top: 3em;
  right: 2em;
  border-color: black;
}
</style>
