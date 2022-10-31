<template>
<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card p-3 py-4">
                <div class="text-center">
                    <img v-if="User.image =='null'" src="@/assets/user.png" style="width:100px"  class="rounded-circle">
                    <img v-if="User.image !=='null'" :src="$store.state.UrlImageUser+User.image" class="image_radius"> 
                </div>
                
                <div class="text-center mt-3">
                    <button @click="$router.push({name:'userinformation'})" class="btn btn-outline-primary px-4">chỉnh sửa thông tin</button>
                    <h5 class="mt-2 mb-0">{{User.name}}</h5> <span>{{User.email}}</span>
                    <div class="buttons">
                    <button @click="$router.push({name:'userorder'})" class="btn btn-outline-primary px-4">Đơn Hàng </button>
                    <button @click="logout" class="btn btn-primary px-4 ms-3">Đăng xuất</button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
</template>

<script>
import {mapState,mapActions} from 'vuex'
export default {
    created(){
        if(this.User==false||this.User==true){
            this.$router.push({name:'login'})
        }
    },
    data(){
        return{

        }
    },
    computed:{
        ...mapState(['User'])
    },
    methods:{
        ...mapActions(['CheckUser']),
        logout(){
            if(confirm('Bạn có muốn đăng xuất không?')){
                window.localStorage.removeItem('user')
                this.$router.push({name:'login'})
                this.CheckUser()
            }
        }
    }
}
</script>

<style scoped>
body {
    background: #eee;
}

.card {
    border: none;
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    cursor: pointer;
}

.card:before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background-color: #fdedc0;
    transform: scaleY(1);
    transition: all 0.5s;
    transform-origin: bottom;
}

.card:after {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background-color: #fcbd12;
    transform: scaleY(0);
    transition: all 0.5s;
    transform-origin: bottom;
}

.card:hover::after {
    transform: scaleY(1);
}
.image_radius{
  width: 100px;
  height: 100px;
  border-radius:50% ;
}
.social-list {
    display: flex;
    list-style: none;
    justify-content: center;
    padding: 0;
}

.social-list li {
    padding: 10px;
    color: #fcbd12;
    font-size: 19px;
}
.buttons{
    padding-top: 100px ;
}

.buttons button:nth-child(1) {
    border: 1px solid #fcbd12 !important;
    color: #fcbd12;
    height: 40px;
}

.buttons button:nth-child(1):hover {
    border: 1px solid #fcbd12 !important;
    color: #fff;
    height: 40px;
    background-color: #fcbd12;
}

.buttons button:nth-child(2) {
    border: 1px solid #fcbd12 !important;
    background-color: #fcbd12;
    color: #fff;
    height: 40px;
}
.btn{
    margin-left:10px ;
}
</style>