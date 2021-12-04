<template>
 
  <b-card>
    
    <b-form>
      <b-row>      
        
        <b-modal ref="pass-modal" hide-footer title="Password Status">
          <div class="d-block text-center">
            <h3>{{res}}</h3>
          </div>      
        </b-modal>
        <b-modal ref="confirm-modal" hide-footer title="Password Status">
          <div class="d-block text-center">
            <h3>Are you sure you want to change you password?</h3>
            <b-button
              v-ripple.400="'rgba(255, 255, 255, 0.15)'"
              variant="primary"
              class="mt-1 mr-1"
              @click.prevent="updatepass"            
            >
              Yes
            </b-button>
            <b-button 
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            class="mt-1 mr-1"
            @click="hideconfirm"
            >
              No
            </b-button>
    
          </div>      
        </b-modal>
        <!-- old password -->
        <b-col md="6">
          <b-form-group
            label="Old Password"
            label-for="account-old-password"
          >
            <b-input-group class="input-group-merge">
              <b-form-input
                id="account-old-password"
                v-model="passwordValueOld"
                name="old-password"
                :type="passwordFieldTypeOld"
                placeholder="Old Password"
                required
              />
              <b-input-group-append is-text>
                <feather-icon
                  :icon="passwordToggleIconOld"
                  class="cursor-pointer"
                  @click="togglePasswordOld"
                />
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
        <!--/ old password -->
      </b-row>
      <b-row>
        <!-- new password -->
        <b-col md="6">
          <b-form-group
            label-for="account-new-password"
            label="New Password"
          >
            <b-input-group class="input-group-merge">
              <b-form-input
                id="account-new-password"
                v-model="newPasswordValue"
                :type="passwordFieldTypeNew"
                name="new-password"
                placeholder="New Password"
                required
              />
              <b-input-group-append is-text>
                <feather-icon
                  :icon="passwordToggleIconNew"
                  class="cursor-pointer"
                  @click="togglePasswordNew"
                />
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
        <!--/ new password -->

        <!-- retype password -->
        <b-col md="6">
          <b-form-group
            label-for="account-retype-new-password"
            label="Retype New Password"
          >
            <b-input-group class="input-group-merge">
              <b-form-input
                id="account-retype-new-password"
                v-model="RetypePassword"
                :type="passwordFieldTypeRetype"
                name="retype-password"
                placeholder="New Password"
                required
              />
              <b-input-group-append is-text>
                <feather-icon
                  :icon="passwordToggleIconRetype"
                  class="cursor-pointer"
                  @click="togglePasswordRetype"
                />
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
        <!--/ retype password -->

        <!-- buttons -->
        <b-col cols="12">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            class="mt-1 mr-1"
            @click.prevent="confirm"
            v-b-modal="'my-modal'"
          >
            Save changes
          </b-button>
          <b-button
            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
            type="reset"
            variant="outline-secondary"
            class="mt-1"
          >
            Reset
          </b-button>
        </b-col>
        <!--/ buttons -->
      </b-row>
    </b-form>
  </b-card>
</template>

<script>
import {
  BButton, BForm, BFormGroup, BFormInput, BRow, BCol, BCard, BInputGroup, BInputGroupAppend,BModal
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import axios from 'axios'

export default {
  components: {
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BCard,
    BInputGroup,
    BInputGroupAppend,
    BModal
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      passwordValueOld: '',
      newPasswordValue: '',
      RetypePassword: '',
      passwordFieldTypeOld: 'password',
      passwordFieldTypeNew: 'password',
      passwordFieldTypeRetype: 'password',
      id:'',
      res:'',
      error:'',
    }
  },
  //deletable line 177
  temporaryidsetter(){
    localStorage.setItem('user_id',1);
  },
  computed: {
    passwordToggleIconOld() {
      return this.passwordFieldTypeOld === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    passwordToggleIconNew() {
      return this.passwordFieldTypeNew === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    passwordToggleIconRetype() {
      return this.passwordFieldTypeRetype === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    togglePasswordOld() {
      this.passwordFieldTypeOld = this.passwordFieldTypeOld === 'password' ? 'text' : 'password'
    },
    togglePasswordNew() {
      this.passwordFieldTypeNew = this.passwordFieldTypeNew === 'password' ? 'text' : 'password'
    },
    togglePasswordRetype() {
      this.passwordFieldTypeRetype = this.passwordFieldTypeRetype === 'password' ? 'text' : 'password'
    },
    updatepass(){
      
        this.$refs['confirm-modal'].hide();        
        if(this.error==10){
          this.res='password has changed successfully';
        }
        else if(this.error==1){
          this.res='the old password you entered is incorrect';
        }
        else if(this.error==2){
          this.res='you cannot use your old password as your new password';
        }
        this.$refs['pass-modal'].show();
        
                                      
      
      
      
    },
    confirm(){
      if(this.newPasswordValue==this.RetypePassword){
        this.id=localStorage.getItem('user_id');
        axios.put('api/changepass',{
          oldpass:this.passwordValueOld,
          newpass:this.newPasswordValue,
          retypepass:this.RetypePassword,
          id:this.id
        }).then(response=>{this.error=response.data});
        this.$refs['confirm-modal'].show();
      }
      else{
        this.res='your retyped password does not match your new password';
        this.$refs['pass-modal'].show();
      }
    },
    hideconfirm(){
      this.$refs['confirm-modal'].hide();
    }

    
  },
}
</script>
