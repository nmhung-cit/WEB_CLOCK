<template>
    <div class="add_product " v-bind:class="{set_left: changepassword}" >
        <p>THAY ĐỔI MẬT KHẨU</p>
        <p class="close" @click="$store.state.changepassword = true"><i class="fas fa-times fa-2x"></i></p>
        <div class="addproduct">
            <form action="" @submit.prevent="GetPassword">
            <div class="form_left from">
                <div :class="{'error':messages}">{{messages}}</div>
                <input type="password" placeholder="Mật khẩu cũ" v-model="password.password" autocomplete="off">
                <input :type="type" placeholder="Mật khẩu mới" v-model="password.newpassword"  autocomplete="off">
                <input :type="type" placeholder="Xác nhận mật khẩu" v-model="password.confirmpassword" autocomplete="off">
                <input type="checkbox" v-model="checked">
                <label>Hiển thị mật khẩu</label>
                <button class="btn_add" :disabled="loading" >
                    <span :class="{'spinner-border spinner-border-sm':loading}"></span>{{status}}
                </button>                 
            </div>
            </form>
        </div>
    </div>
</template>

<script>
import {mapGetters,mapState} from 'vuex'
import BaseRequest from '@/BaseRequest'
// import BaseRequest from '@/BaseRequest'
export default {
    data(){
        return{
            password:{
                password:'',
                newpassword:'',
                confirmpassword:''
            },
            type:'password',
            checked:false,
            messages:'',
            status:'CẬP NHẬT',
            loading:false,
        }
    },
    computed:{
        ...mapGetters(['changepassword']),
        ...mapState(['addproducts','User']),
    },
    methods:{
        GetPassword(){
            if(this.password.newpassword==this.password.confirmpassword){
                this.loading = true
                BaseRequest.post('/updatepassword',this.password)
                .then((response)=>{
                    this.messages = response.data.message
                    this.loading = false
                })
                .catch((error)=>{
                    this.messages = error.response.data.message
                    this.loading = false
                })
            }
            else{
                this.messages = 'Mật Khẩu không khớp'
            }
        }
    },
    watch:{
        checked:function(){
            if(this.checked==true){
                this.type='text'
            }
            else{
                this.type ='password'
            }
        }
    }
}
</script>

<style scoped>
.add_product{
    top: 0;
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0, 0.9);
    overflow: hidden;
    transition:  0.5s;
    z-index: 99;
}
.add_product>p{
    color: white;
    font-size: 20px;
    margin: 20px;
    text-align: center;
    text-transform: uppercase ;
}
.set_left{
    height: 0;
}
.close{
    width: 30px;
    height: 30px;
    position: absolute;
    right: 30px;
    top: 30px;
}
.addproduct{
    width: 800px;
    margin: auto;
    background: rgb(248, 250, 250);
    border-radius:20px;
    box-shadow: 0 0 10px rgb(252, 252, 252);
    overflow: hidden;
}
.form_left{
    width: 300px;
    margin: auto;
}
.from>input{    
    width: 300px;
    padding: 5px ;
    margin: 10px 0px 10px 0px;
    border:1px solid rgb(117, 117, 117);
    border-radius:20px ;
    outline: none;
}
.from>input[type=checkbox]{
    width: 20px;
    margin-right: 5px;
}
.from>input:focus{
    box-shadow: 0 0 4px red;
}
.btn_add:hover{
    background: rgb(233, 243, 99);
    border:1px solid rgb(233, 243, 99);
    color: white;
}.btn_add{
    margin: 20px 0px;
    width: 300px;
    padding: 10px 20px;
    border:1px solid black;
    border-radius:5px ;
    transition: all 0.5s ease;
    background: none;
}
.error{
  color: red;
  font-size: 13px;
  text-transform: uppercase;
}
</style>