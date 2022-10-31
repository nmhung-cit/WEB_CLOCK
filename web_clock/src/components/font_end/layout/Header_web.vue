<template>
    <div class="header-container">
        <div class="flex-header" :class="{'Show':Show}">
            <div class="nav_bars-btn">
                <label for="mobile-input">
                    <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                </label>
            </div>
            <div class="logo-header">
                <img alt="logo_clock" src="@/assets/logo/logo_clock.png">
            </div>   
            <div class="search-product">
                <input v-model="NameProduct" type="text" placeholder="Nhập tên , thương hiệu..." style="color:white">
                <button @click="ShreachProduct()"> 
                    <i class="fas fa-search fa-2x" style="color: white;"></i>
                </button>
            </div>
            <div class="button-login-and-cart">
                <span v-if="User !== true && User !== false && User.image !== 'null' " @click="$router.push({name:'user'}).catch(err =>{})" >
                    <img :src="UrlImageUser+User.image" alt=""></span>
                <!-- <span v-if="User!==true&&User!==false&&User=='null'" @click="$router.push({name:'user'}).catch(err =>{})" ><i class="fas fa-user fa-2x" style="color:white"></i></span> -->
                <span v-if="User == true || User==false || User.image == 'null' " @click="$router.push({name:'user'}).catch(err =>{})" ><i class="fas fa-user fa-2x" style="color:white"></i></span>
                <span class="cart" @click="$router.push({name:'cart'}).catch(err =>{})"><i class="fas fa-shopping-cart fa-2x" style="color:white"></i>
                <span v-if="$store.state.CartQuantity>0" class="badge">{{$store.state.CartQuantity}}</span> </span>
            </div>
        </div>

        <input type="checkbox" name="" id ="mobile-input">

        <label for="mobile-input" class="nav_overlay">
        </label>
        <div class="list-of-menu">
            <label for="mobile-input" ref="Close" class="menu_btn-close">
                <i class="fa fa-times fa-2x" aria-hidden="true"></i>
            </label>
            <input class="menu_input-shearch" v-model="NameProduct" type="text" placeholder="Tìm kiếm...">
            <button class="menu_btn-shearch" @click="ShreachProduct()"> 
                <label for="mobile-input"> <i class="fas fa-search " style="color: black;"></i></label>
            </button>
            <ul @click = LableClick>
                <li><router-link to="/Home">TRANG CHỦ</router-link></li>
                <li><router-link to="/Introduce">GIỚI THIỆU</router-link></li>
                <li><router-link to="/Men-clock">ĐỒNG HỒ NAM</router-link></li>
                <li><router-link to="/Women-clock">ĐỒNG HỒ NỮ</router-link></li>
                <li><router-link to="/News-clock">TIN TỨC</router-link></li>
                <li><router-link to="/Contact">LIÊN HỆ </router-link></li>
                <li><router-link :to="{name:'user'}">TÀI KHOẢN </router-link></li> 
            </ul>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'
export default ({
    data() {
        return {
            NameProduct:"",
            Show:false,
        }
    },
    computed:{
        ...mapState(['User','UrlImageUser'])
    },
    methods: {
        ShreachProduct(){
            if(!this.NameProduct){
                alert('Vui lòng nhập thông tin tìm kiếm')
            }
            else{
                this.$router.push({name:'Shearch', query:{text:this.NameProduct}})
                this.NameProduct = ""
            }
        },
        LableClick(){
            this.$refs.Close.click()
        },
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
})
</script>

<style scoped src = '@/assets/styles/frontend/header.css'></style>
