<template>
   <div class="login-page">
       <h3> LOGIN  123</h3>
  <div class="form">
    <form class="login-form" action="" method="POST" @submit.prevent="login()">
      
      <div :class="{'error':messages}">
        {{messages}}</div>    

      <input v-model="admin.username" type="text" name="username" placeholder="Username"/>
      
      <input v-model="admin.password" :type="type" placeholder="Password" autocomplete="off"/>
      <!-- <div v-if="errors.password" :class="{'error':errors.password}">
        {{errors.password[0]}}</div>        -->
      <input class="checkbox" type="checkbox" v-model="check" ><span>Show password</span>
        <button :class="{'btn btn-primary':loading}" type="submit" :disabled="loading">
          <span :class="{'spinner-border spinner-border-sm':loading}" role="status" aria-hidden="true"></span>
          {{status}}
        </button>
    </form>
  </div>
</div>
</template>

<script>
import BaseRequest from '@/BaseRequest'
export default {
    data(){
        return{
          admin:{
            username:"",
            password:"",
          },
          messages:'',
          loading:false,
          status:'LOGIN',
          type:"password",
          check:false
        }
    },
    beforeCreate(){
      if(localStorage['admin']){
        this.$router.push({name:'management'})
      }
    },
    methods:{
      login: function(){
        this.loading=true
        this.status ='loading...'
        BaseRequest.login('/admin-login',this.admin)
        .then(response =>
        {
          window.localStorage.setItem('admin', response.data.token);
          this.$router.push({name:'management'})
        })
        .catch(error =>
        {
          if (!error.response) {
          this.messages = 'KHÔNG THỂ KẾT NỐI ĐẾN SEVER'
          this.loading=false
          this.status ='LOGIN'
          }
          else{
          this.loading=false
          this.status ='LOGIN'
          this.messages = error.response.data.message
          }
        })
      }
    },
    watch:{
        check:function(){
            if(this.check==true)
            {
                this.type="text"
            }
            else{
                this.type='password'
            }
        
        }
    }
}
</script>
<style scoped>
.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
  color: #026423;
}
.login-page>h3{
    text-align: center;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  padding: 45px;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: none;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
  margin: 0 0 10px;
}
.checkbox{
    width: 20px !important;
}
.form button {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.error{
  color: red;
  font-size: 11px;
  text-transform: uppercase;
}
body {
  background: #76b852; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  background: -moz-linear-gradient(right, #76b852, #8DC26F);
  background: -o-linear-gradient(right, #76b852, #8DC26F);
  background: linear-gradient(to left, #76b852, #8DC26F);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
</style>