<template>
<div >
    <Loading v-if="User == false||Loading ==true"></Loading> 
    <div v-if="User!=false&&Loading == false" class="wrapped">
        <IconLoading v-if="IconLoading"></IconLoading>
        <div class="title-allproduct">
            <div class="title"><p>ĐỒNG HỒ NỮ</p>
            </div>
            <div class="sort">
                    <label for="cars" id="name-cars">Sắp xếp theo: </label> 
                    <select name="" v-model="Sort" id="cars">
                        <option value="1">Sản phẩm mới nhất</option>
                        <option value="2">Cao đến thấp </option>
                        <option value="3">Thấp đến cao</option>
                        <option value="4">Sản phẩm cũ nhất</option>
                        
                    </select>
            </div>
        </div>

      <div class="flex-allproduct">
          <div class="category">
              <div class="category-menu menu-title">
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
              <div class="category-menu menu-title">
                  <p>THƯƠNG HIỆU</p>
                  <div class="menu">
                      <ul>
                        <li v-for="(trademark, index ) in trademarks" :key="index" ><router-link to="#">{{trademark.trademark}}</router-link></li>                       
                      </ul>                      
                  </div>
              </div>
              <div class="category-menu">
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
          <div class = "all-product-content">
                <div class="all-products">
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
                        <div v-if="product.ViewCart==false&&product.status ==0" @click="AddCart(product)" class="button-cart">
                            <i class="fas fa-cart-plus fa-2x "></i>                          
                            <p class="tooltip">Thêm vào giỏ</p>
                        </div>
                        <div v-if="product.ViewCart==true" class=" view-to-cart">
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
                        <a class="page-link" href="#" @click.prevent="current_page++" aria-label="Next">
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
    data(){
        return{
            Sort:1,
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
            LinkProduct:'/womenproduct?page='
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
    },
    methods:{
        ...mapMutations(['setquantity']),
        getproduct:function(){
            BaseRequest.GetUser(this.LinkProduct+this.current_page)
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
        demo(){
            console.log('hung')
        }     
    },
    mounted(){
        this.getproduct();
        
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
            this.getproduct();
        },
        Sort(){
            if(this.Sort == 1){
                this.Loading = true
                this.LinkProduct='/womenproduct?page='
                this.getproduct()
            }
            if(this.Sort == 2){
                this.Loading = true
                this.LinkProduct='/womenproductincrease?page='
                this.getproduct()                   
            }
            if(this.Sort == 3){
                this.Loading = true
                this.LinkProduct='/womenproductdiscount?page='
                this.getproduct()
            }
            if(this.Sort == 4){
                this.Loading = true
                this.LinkProduct='/womenproductold?page='
                this.getproduct()
            }
        }
    }
}
</script>

<style scoped src = "@/assets/styles/frontend/Clock.css">
</style>