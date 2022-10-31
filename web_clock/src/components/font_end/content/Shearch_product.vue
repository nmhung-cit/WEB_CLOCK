<template>
<div >
    <Loading v-if="User == false||Loading ==true"></Loading> 
    <div v-if="User!=false&&Loading == false">
        <IconLoading v-if="IconLoading"></IconLoading>
      <div class="flex-allproduct">
          <div class="category of-search">
              <div class="category-menu">
                  <p>DANH MỤC</p>
                  <div class="menu">
                      <ul>
                        <li><router-link to="/Home">Trang chủ</router-link></li>
                        <li><router-link to="/Introduce">Giới thiệu</router-link></li>
                        <li><router-link to="/Men-clock">Đồng hồ nam</router-link></li>
                        <li><router-link to="/Women-clock">Đồng hồ nữ</router-link></li>
                        <li><router-link to="/News-clock">Tin tức</router-link></li>
                        <li><router-link to="/Contact">Liên hệ</router-link></li>
                      </ul>
                  </div>
              </div>
              <div v-if="products.length !== 0" class="category-menu">
                  <p>THƯƠNG HIỆU</p>
                  <div class="menu">
                      <ul>
                        <li v-for="(trademark, index ) in trademarks" :key="index" ><router-link to="#">{{trademark.trademark}}</router-link></li>                       
                      </ul>                      
                  </div>
              </div>
              <div v-if="products.length !== 0" class="category-menu">
                  <p>TIN NỖI BẬT</p>
                  <div class="show-all-news">
                    <div v-for="news in NewNews" :key="news.id_news" class="news-menu" 
                    @click="$router.push({name:'contentnews',params:{id_news:news.id_news}})">
                        <div class="img-news">
                            <img :src="UrlImageNews+news.image" alt="">
                        </div>
                        <div class="title-news">
                            {{news.title}}
                        </div>
                    </div>
                  </div>                                  
              </div>
          </div>
          <div class="all-product-content">
            <div class="title-allproduct">
                <div class="title"><p>KẾT QUẢ TÌM KIẾM CHO "{{NameProduct}}"</p></div>
            </div>              
            <div class="all-products">
                <div v-if="products.length == 0" class="Notification">
                    <h3>Không tìm thấy kết quả</h3>
                </div>
                <div v-for="(product) in products" :key="product.id" class="product">
                    <div @click="$router.push({name:'productdetails',params:{id:product.id}})" class="image-product">              
                        <img :src="$store.state.UrlImage+product.image" alt="picture-clock">
                    </div>
                    <div v-if="product.status == 1" class="statusProduct">
                        <div class="viewstatus">Hết hàng</div>
                    </div>
                    <div v-if="product.promotion_price>0" class="PromotionProduct">
                        <div class="Promotion">-{{100-(product.promotion_price/product.price)*100}}%</div>
                    </div>                                          
                    <div v-if="product.ViewCart==false&&product.status == 0" @click="AddCart(product)" class="button-cart">
                        <i class="fas fa-cart-plus fa-2x "></i>                          
                        <p class="tooltip">Thêm vào giỏ</p>
                    </div>
                    <div v-if="product.ViewCart==true" class="button-cart">
                        <div @click="$router.push({name:'cart'})" class="viewcart">Xem giỏ hàng</div>
                    </div>                      
                    <p class="title-type-product">{{product.type_product|TypeProduct}}</p>
                    <p class="title-product" @click="$router.push({name:'productdetails',params:{id:product.id}})">{{product.name}}</p>
                    <p v-if="product.promotion_price==0||product.promotion_price==null" class="price-product">{{product.price|MoneyFormat}}</p>
                    <div v-if="product.promotion_price>0" class="price">
                        <p class="price-product-mai">{{product.price|MoneyFormat}}</p>
                        <p class="price-product">{{product.promotion_price|MoneyFormat}}</p>
                    </div>     
                </div>
            </div>
                <nav v-if="total_page>1" aria-label="Page navigation example" class="Pages">
                    <ul class="pagination justify-content-center">
                        <li v-if="current_page > 1"  class="page-item">
                            <a class="page-link" href="" @click.prevent="current_page--" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li v-for="(page, index) in total_page" :key="index" class="page-item ">
                            <a class="page-link " href="#" @click.prevent="current_page = page"  :class="{'bg-secondary text-white': current_page==page}">{{page}}</a>
                        </li>
                        <li v-if="current_page < total_page" class="page-item">
                            <a class="page-link" href="" @click.prevent="current_page++" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
          </div>
      </div>        
    </div>
</div>
</template>

<script>
import Loading from './Loading.vue'
import IconLoading from './IconLoading.vue'
import BaseRequest from '@/BaseRequest'
import {mapMutations,mapState} from 'vuex'
export default {
    components:{
        Loading,
        IconLoading
    },
    props:['name'],
    data(){
        return{
            // NameProduct:this.name,
            // Sort:1,
            products:[],
            trademarks:[],
            Cart:{
                id_product:'',
                id_user:'',
                quantity:1,
                colors:'mặc định'
            },
            NewNews:{},
            current_page:1,
            total_page:0,
            IconLoading:false,
            Loading : true,
            LinkProduct:'/shearch-product/'
        }
    },
    beforeCreate() {
        window.scrollTo(0,0)
        BaseRequest.GetUser('/trademark')
        .then((response)=>{
            this.trademarks = response.data
        });
        BaseRequest.get('/get-new-news')
        .then((response)=>{
            this.NewNews = response.data
        })         
    },
    computed:{
        ...mapState(['User','UrlImageNews']),
        NameProduct(){
            return this.name
        }
    },
    methods:{
        ...mapMutations(['setquantity']),
        getproduct:function(Link){
            BaseRequest.GetUser(Link)
            .then((response)=>{
                this.Loading = false
                this.products = response.data.data
                this.total_page = response.data.last_page
                this.products.forEach(product => {
                    product.ViewCart = false
                });               
            });
        },
        AddCart:function(product){
            this.Cart.id_product = product.id
            this.IconLoading = true
            if(this.User!=false&&this.User!=true){
                this.Cart.id_user = this.User.id
                BaseRequest.post('/cart',this.Cart)
                .then((reaponse)=>{
                    this.IconLoading = false
                    product.ViewCart = true
                    this.setquantity(reaponse.data.length )                  
                })
            }
            else{
                this.$router.push({name:'login'})
            }
        },    
    },
    mounted(){
        this.getproduct(this.LinkProduct+this.NameProduct);
        
    },
    filters:{
        TypeProduct:function(types){
            if(types == 0){
                return(types = 'Đồng hồ nam')
            }
            else{
                return(types = 'Đồng hồ nữ')
            }
        },
        MoneyFormat:function(money){
            return (new Intl.NumberFormat('de-DE').format(money)+' VND');
        }, 
    },
    watch:{
        current_page(){
            this.getproduct(this.LinkProduct+this.NameProduct+'?page='+this.current_page);
        },
        NameProduct(){
            this.Loading = true
            this.getproduct(this.LinkProduct+this.NameProduct);
        }
    }
}
</script>

<style scoped src = "@/assets/styles/frontend/Clock.css">
/* .title-allproduct{
    display: flex;
    justify-content: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.title-allproduct>div{
    margin: 20px;
}
.title{
    width: 300px;
    font-weight: bold;
    font-size: 18px;
    white-space: nowrap;
}
#cars{
    padding: 10px;
    box-shadow: 0 0 10px rgb(92, 92, 92);
    outline: none;
    width: 200px;
}
#cars:hover{
    box-shadow: 0 0 0px rgb(92, 92, 92);
}
#name-cars{
    padding: 10px;
}
.flex-allproduct{
    display: flex;
    justify-content: center;
}
.flex-allproduct > div{
    margin: 20px;
}
.category{
    width: 300px;
}
.all-products{
    width: 900px;
    box-shadow: 0 0 10px #adadad;
    display: flex;
    flex-wrap: wrap;
    align-content: flex-start;
    background: #fafafa;
}
.category-menu>p{
    padding: 20px 0px 20px 0px;
    font-weight: bold;
}
.menu{
    border: solid 1px rgb(199, 198, 198);
    padding: 10px 10px 0px 10px;
    max-height: 400px;
    overflow: auto;
    word-wrap: break-word;
    border-radius: 10px;
    background: #fafafa;
}
.menu>ul>li{
    list-style: none;
    padding: 10px;
    border-bottom: solid 1px rgb(199, 198, 198);
}
.menu>ul>li>a{
    text-decoration: none;
    color: black;
}
.menu>ul>li>a:hover{
    color: #fcce4f;
}
.show-all-news{
    border: solid 1px rgb(199, 198, 198);
    border-radius: 10px;
    background: #fafafa;
    max-height: 400px;
    overflow: auto;    
}
.news-menu{
    display: flex;
    align-items: center;
    margin: 0px 10px 0px 10px;
    border-bottom: solid 1px rgb(199, 198, 198);
}
.news-menu>div{
    padding:10px 0px 20px 10px;
}
.img-news>img{
    max-width: 60px;
}
.title-news{
    text-decoration: none;
    color: black;
}
.title-news:hover{
    cursor: pointer;
    color: #fcce4f;
}
.product{
    width: 270px;
    height: 380px;
    margin: 5px 15px 5px 15px;
    background: white;
    position: relative;
    border-radius: 10px;
    
}
.product:hover{
    box-shadow: 0 0 1px rgb(83, 83, 83);
}
.product:hover .button-cart{
    opacity: 1;
    transform: translateY(-16px);
}
.product:hover .image-product>img{
    transform: scale(1.06,1.06);
}
.image-product {
    width: 268px;
    height: 270px;
    overflow: hidden;
    margin: auto;
    border-radius: 10px;
}
.button-cart{
    position: absolute;
    left: 6%;
    bottom: 110px;
    opacity: 0;
    color: #a1a1a1;
    transition: 0.6s;
}
.button-cart:hover{
    color: #0a0801;
}
.button-cart:hover .tooltip {
    transition: all 0.6s;
    transition-delay: 1s;
    opacity: 0.8;
}
.statusProduct{
    position: absolute;
    left: 6%;
    bottom: 57%;
    color: #a1a1a1;
}
.PromotionProduct{
    position: absolute;
    left: -4%;
    bottom: 90%;
}
.Promotion{
    width: 50px;
    height: 50px;
    line-height: 48px;
    border-radius: 50px;
    font-weight: 600;
    background: rgba(228, 205, 0, 0.973);
    color: rgb(255, 253, 253);
    text-align: center;
}
.viewstatus{
    width: 236px;
    height: 60px;
    line-height: 60px;
    font-size: 19px;
    font-weight: 600;
    text-transform: uppercase;
    background: rgba(247, 247, 247, 0.829);
    color: rgba(0, 0, 0, 0.664);
    cursor: pointer;
    text-align: center;
}
.viewcart{
    width: 236px;
    height: 30px;
    background: rgba(5, 5, 5, 0.575);
    color: white;
    cursor: pointer;
    text-align: center;
    transition: all 0.5s;
}
.viewcart:hover{
    background: #0a0801;
}
.tooltip{
    opacity: 0;
    width: 100px;
    text-align: center;
    background: black;
    color: white;
    padding: 6px 0px 6px 0px;
    border-radius: 10px;
    position: absolute;
    bottom: 46px;
    left: -86%;
    
}
.tooltip::after{
    content: "";
    position: absolute;
    top: 100%;
    margin-left:-4px ;
    left: 50%;
    border-width: 6px;
    border-style:solid ;
    border-color: black transparent transparent transparent;
}
.image-product>img{
    width: 268px;
    transition: 0.6s;
}
.title-product{
    cursor: pointer;
}
.title-product:hover{
    color: #fcbc0e;
}
.title-product, .price-product{
    text-align: center;
    padding: 3px 0px 3px 0px;
    font-size: 14px;
    margin: 0;
    text-transform: uppercase;
}
.title-type-product{
    color: #adadad;
    font-weight: bold;
    text-align: center;
    padding: 3px 0px 3px 0px;
    font-size: 11px;
    margin: 0;
    text-transform: uppercase;
}
.price-product{
    font-weight: bold;
}
.price-product>span{
    color: #adadad;   
    text-decoration-line: line-through; 
}
.Notification{
    width: 100%;
    text-align: center;
    text-transform: uppercase;
    padding:60px
} */
</style>