<template>
<div>
    <Loading v-if="LoadingUser"></Loading>
    <form v-if="LoadingUser==false" action="" @submit.prevent="Regester">
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-5">
                    <div class="card1 pb-5">
                        <div class="row"> <img src="@/assets/logo/images.jpg" class="logo"> </div>
                        <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img src="@/assets/logo/welcome.jpg" class="image"> </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-4 px-3">
                            <h4 class="mb-0 mr-4 mt-2">Đăng Ký Tài Khoản</h4>
                        </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 v-if="Messages==null" class="mb-0 text-sm">Họ và tên:</h6>
                                <h6> <span :class="{'error':Messages}">{{Messages}}</span> </h6>                             
                            </label> <input v-model="Users.name" class="mb-4" type="text" name="email" placeholder="Nhập họ và Tên"> </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 v-if="Messages==null" class="mb-0 text-sm">Tên tài khoản:</h6>                            
                            </label> <input v-model="Users.username" class="mb-4" type="text" name="email" placeholder="Nhập tên tài khoản"> </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 v-if="Messages==null" class="mb-0 text-sm">Địa chỉ email:</h6>                            
                            </label> <input v-model="Users.email" class="mb-4" type="text" name="email" placeholder="Nhập địa chỉ email"> </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Mật khẩu:</h6>
                            </label> <input :type="type" v-model="Users.password" name="password" placeholder="Nhập mật khẩu" autocomplete="off" > </div>
                            <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Nhập lại mật khẩu:</h6>
                            </label> <input :type="type" v-model="AgainPassword" name="password" placeholder="Nhập lại mật khẩu" autocomplete="off" > </div>
                        <div class="row px-3 mb-4">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input id="chk1" v-model="checked" type="checkbox" name="chk" class="custom-control-input"> 
                                <label for="chk1" class="custom-control-label text-sm">Hiển thị mật khẩu</label> 
                            </div> 
                        </div>
                        <div class="row mb-3 px-3">
                            <button class="btn btn-primary" type="submit" :disabled="Loading">
                            <span :class="{'spinner-border spinner-border-sm':Loading}" role="status" aria-hidden="true"></span>
                            {{Status}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</template>

<script>
import Loading from './Loading.vue'
import {mapState} from 'vuex'
import BaseRequest from '@/BaseRequest'
export default {
    components:{
        Loading
    },
    data(){
        return{
            Users:{
                name:'',
                username:'',
                email:'',
                password:'',
            },
            AgainPassword:'',
            Loading:false,
            Status:'ĐĂNG KÝ',
            type:'password',
            Messages:null,
            checked:false,
            LoadingUser:true
        }
    },
    created(){
        window.scrollTo(0,0)
        BaseRequest.get('/user-information')    
        .then(()=>{
            this.$router.push({name:'user'})
        })
        .catch(()=>{
            this.LoadingUser=false
        })
    },
    computed:{
        ...mapState(['User'])
    },
    methods:{
        Regester(){
            if(this.Users.password == this.AgainPassword){
                this.Loading = true
                this.Status = 'Loading...'
                BaseRequest.login('/user-register',this.Users)
                .then(()=>{
                    alert('ĐĂNG KÝ THÀNH CÔNG ! VUI LÒNG ĐĂNG NHẬP LẠI')
                    this.$router.push({name:'login'})
                })
                .catch((error)=>{
                    if (!error.response) {
                    this.Messages = 'KHÔNG THỂ KẾT NỐI ĐẾN SEVER'
                    this.Loading=false
                    this.Status ='ĐĂNG KÝ'
                    }
                    else{
                    this.Loading=false
                    this.Status ='ĐĂNG KÝ'
                    this.Messages = error.response.data.message
                    }
                })
            }
            else{
                this.Messages = 'MẬT KHẨU BẠN NHẬP KHÔNG TRÙNG'
            }
        }
    },
    watch:{
        checked:function(){
            if(this.checked == true){
                this.type='text'
            }else{
                this.type='password'
            }
        },
    }
}
</script>

<style scoped>

.card0 {
    box-shadow: 0px 4px 8px 0px #757575;
    border-radius: 0px
    
}

.card2 {
    margin: 0px 40px
}

.logo {
    width: 200px;
    height: 100px;
    margin-top: 20px;
    margin-left: 35px
}

.image {
    width: 360px;
    height: 280px
}

.border-line {
    border-right: 1px solid #EEEEEE
}

.facebook {
    background-color: #f15719;
    color: #fff;
    font-size: 18px;
    padding-top: 5px;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer
}

.twitter {
    background-color: #1DA1F2;
    color: #fff;
    font-size: 18px;
    padding-top: 5px;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer
}

.linkedin {
    background-color: #2867B2;
    color: #fff;
    font-size: 18px;
    padding-top: 5px;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer
}

.line {
    height: 1px;
    width: 45%;
    background-color: #E0E0E0;
    margin-top: 10px
}

.or {
    width: 10%;
    font-weight: bold
}

.text-sm {
    font-size: 14px !important
}

::placeholder {
    color: #BDBDBD;
    opacity: 1;
    font-weight: 300
}

:-ms-input-placeholder {
    color: #BDBDBD;
    font-weight: 300
}

::-ms-input-placeholder {
    color: #BDBDBD;
    font-weight: 300
}

input,
textarea {
    padding: 10px 12px 10px 12px;
    border: 1px solid lightgrey;
    border-radius: 2px;
    margin-bottom: 5px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    color: #2C3E50;
    font-size: 14px;
    letter-spacing: 1px
}

input:focus,
textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #304FFE;
    outline-width: 0
}

button:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline-width: 0
}

a {
    color: inherit;
    cursor: pointer
}

.btn-primary {
    background-color: #5f5f64 !important;
    font-size: 13px;
    width: 130px;
    color: #fff;
    border: none;
    transition: all 0.5s;
}

.btn-primary:hover {
    background-color: rgb(168, 119, 119) !important;
    color: white;
    cursor: pointer;
    border:none;
}
.error{
    color: red;
    text-transform: uppercase;
}

@media screen and (max-width: 991px) {
    .logo {
        margin-left: 0px
    }

    .image {
        width: 300px;
        height: 220px
    }

    .border-line {
        border-right: none
    }

    .card2 {
        border-top: 1px solid #EEEEEE !important;
        margin: 0px 15px
    }
}

</style>