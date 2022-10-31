<template>
<div>
    <div class="flex-menu" :class="{'Show':Show}">
        <div class="list-of-menu">
            <ul >
                <li><router-link to="/Home">TRANG CHỦ</router-link></li>
                <li><router-link to="/Introduce">GIỚI THIỆU</router-link></li>
                <li><router-link to="/Men-clock">ĐỒNG HỒ NAM</router-link></li>
                <li><router-link to="/Women-clock">ĐỒNG HỒ NỮ</router-link></li>
                <li><router-link to="/News-clock">TIN TỨC</router-link></li>
                <li><router-link to="/Contact">LIÊN HỆ </router-link></li>
            </ul>
        </div>
        <div v-if="Show" class="button-login-and-cart">
            <span v-if="User!==true&&User!==false&&User.image!=='null'" @click="$router.push({name:'user'}).catch(err =>{})" >
                <img :src="UrlImageUser+User.image" alt=""></span>
            <!-- <span v-if="User!==true&&User!==false&&User=='null'" @click="$router.push({name:'user'}).catch(err =>{})" ><i class="fas fa-user fa-2x" style="color:white"></i></span> -->
            <span v-if="User==true||User==false||User.image=='null'" @click="$router.push({name:'user'}).catch(err =>{})" ><i class="fas fa-user fa-2x" style="color:white"></i></span>|
            <span class="cart" @click="$router.push({name:'cart'}).catch(err =>{})"><i class="fas fa-shopping-cart fa-2x" style="color:white"></i>
            <span v-if="$store.state.CartQuantity>0" class="badge">{{$store.state.CartQuantity}}</span> </span>
        </div>
    </div>   
</div>
</template>

<script>
import {mapState} from 'vuex'
export default {
    data() {
        return {
            Show:false
        }
    },
    computed:{
        ...mapState(['User','UrlImageUser'])
    },
    mounted(){
        window.addEventListener('scroll', ()=>{
            if(window.scrollY >= 360){
                this.Show = true
            }
            else{
                this.Show = false
            }
        })
    }
    
}
</script>

<style scoped src = "@/assets/styles/frontend/menu.css">
/* @import "../../../assets/styles/frontend/menu.css"; */
</style>