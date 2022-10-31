<template>
  <div>
    <b-sidebar id="sidebar-variant" title="MENU" bg-variant="dark" text-variant="light" shadow>
      <div class="px-3 py-2 ">
        <div class="menu_button">
            <ul>
                <li><router-link :to="{ name: 'management'}"><i class="fas fa-audio-description"></i>Tổng quan</router-link></li>
                <li><router-link :to="{name:'admin-slide' }"><i class="fas fa-images"></i>Slide</router-link> </li>
                <li><router-link :to="{name:'Product-management' }"><i class="fas fa-box"></i>Sản phẩm</router-link> </li>
                <li><router-link :to="{name:'Oder-management' }"><i class="fas fa-calendar-week"></i>Đơn hàng</router-link> </li>
                <li><router-link :to="{name:'manage-news' }"><i class="fas fa-newspaper"></i>Bảng tin</router-link> </li>
                <li><router-link to="" @click.native="logout()"><i class="fas fa-sign-out-alt"></i>Đăng xuất</router-link></li>
            </ul>
        </div>
      </div>
    </b-sidebar>
    <div class="menu_header">
        <div class="flex_left">
            <b-button v-b-toggle.sidebar-variant><i class="fas fa-bars"></i></b-button> 
            <span>MENU</span>
        </div>
        <div class="flex_right">
             
            <span><i class="fas fa-bell"></i></span>
            <span><i class="fas fa-user-cog"></i></span>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    data(){
        return{
        }
    },
    methods: {
        logout:function(){
            if(confirm('Bạn có muốn đăng xuất không?')){
                window.localStorage.removeItem('admin')
                this.$router.push({name:'login_admin'})
            }
        }
    },
}
</script>

<style scoped>
.menu_button{
    border-top: 1px solid white;
}
.menu_button>ul>li{
    width: 250px;
    height: 50px;
    margin: 5px;
    list-style: none;
    border-radius:5px ;
    padding:12px;
    font-size: 16px;
}
.fas{
    padding-right:10px ;
}
.menu_button>ul>li>a{
    text-decoration: none;
    color: white;
    padding:10px 120px 10px 0px;
}
.menu_button>ul>li:hover{
    background: rgb(94, 93, 93);
}
.router-link-active {
    color: yellow !important;
}
.menu_header{
    display: flex;
    justify-content: flex-end;
    height: 100px;
    width:100%;
    background: rgb(236, 234, 234);
    border-bottom:1px solid  rgb(145, 145, 145);;
}
.menu_header>div{
    align-self: center;
}
.flex_left>button{
    height: 40px;
    width: 40px;
    border-radius: 50%;
    color: rgb(117, 116, 116);
    background: white;
    border: none;
    box-shadow:0 0 5px rgb(151, 150, 150) ;
    margin-left: 30px;
}
.flex_left>span{
    padding-left:10px;
    color: rgb(100, 100, 100);
    font-size: 20px;
}
.flex_left{
    width: 50%;
}
.flex_right{
    width: 50%;
    text-align: right;
}
.flex_right>span{
    color:rgb(117, 116, 116);
    padding: 20px;
    margin: 5px;

}
.flex_right>span:hover{
    background: rgb(214, 213, 213) ;
    border-radius: 10px;
}
</style>