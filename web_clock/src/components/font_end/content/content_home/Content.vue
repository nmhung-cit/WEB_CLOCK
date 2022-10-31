<template>
<div>
    <Loading v-if="loading"></Loading>
    <IconLoading v-if="IconLoading"></IconLoading>
<div v-if="loading==false">
    <div class="body">
        <div class="title">SẢN PHẨM NỖI BẬT</div>
            <div class="GeneralProduct">
                <div 
                @mousedown ="MouseDown"
                @mouseenter="MouseEnter" 
                @mousemove="MouseMove"
                @mouseup ="MouseUp"
                ref="DragSlide" class="Featured-product" >
                    <div ref="Slide_product" class="ProductSlide">
                        <div ref="Featured_Product" v-for="product in ProductFeatured" :key="product.id" 
                        class="product all-product" :class="{'Click':Click}">
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
                            <!-- <p v-if="product.promotion_price>0" class="price-product"> <span>{{product.price|MoneyFormat}}</span>{{product.promotion_price|MoneyFormat}}</p>           -->
                        </div>
                    </div>
                </div>
                <div class="prev" @click="ProductSlidebar(-SizeProductSlide)"><i class="fas fa-chevron-left fa-2x"></i></div>
                <div class="next" @click="ProductSlidebar(SizeProductSlide)"><i class="fas fa-chevron-right fa-2x"></i></div>
            </div>
        <div class="btn_set">
            <button @click="$router.push({name:'allproduct'})">XEM TẤT CẢ</button>
        </div>
    </div>
    <div class="body">
        <div class="title">ĐỒNG HỒ NAM</div>
        <div class="men_clock">
            <div v-for="product in ProductMen" :key="product.id" class="product">
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
        <div class="btn_set">
            <button @click="$router.push({name:'men'})">XEM TẤT CẢ</button>
        </div>
    </div>
    
    <div class="introduce">
        <div class="text">
            <div class="text-introduce"> <i class="fab fa-free-code-camp fa-2x"></i>Miễn Phí Giao Hàng</div>
            <div class="text-introduce"> <i class="fas fa-gift fa-2x"></i>Quà Tặng Đặc Biệt</div>
            <div class="text-introduce"> <i class="fas fa-comments-dollar fa-2x"></i>Tiết Kiệm</div>
        </div>
    </div>
    <div class="body">
        <div class="title">ĐỒNG HỒ NỮ</div>
        <div class="men_clock">
            <div v-for="product in ProductWomen" :key="product.id" class="product">
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
                      <p class="title-product " @click="$router.push({name:'productdetails',params:{id:product.id}})">{{product.name}}</p>
                      <p v-if="product.promotion_price==0||product.promotion_price==null" class="price-product">{{product.price|MoneyFormat}}</p>
                    <div v-if="product.promotion_price>0" class="price">
                        <p class="price-product-mai">{{product.price|MoneyFormat}}</p>
                        <p class="price-product">{{product.promotion_price|MoneyFormat}}</p>
                    </div>
              </div>
        </div>
        <div class="btn_set">
            <button @click="$router.push({name:'women'})">XEM TẤT CẢ </button>
        </div>
    </div>
  <div class="introduce">
        <div class="text">
            <div class="text-introduce"> <i class="fas fa-coins fa-2x"></i>Tự tin </div>
            <div class="text-introduce"> <i class="fas fa-percent fa-2x"></i>KHUYẾN MÃI </div>
            <div class="text-introduce"> <i class="fas fa-users fa-2x"></i>Giao hàng nhanh</div>
        </div>
    </div>
    <div class="body">
        <div class="title">THÔNG TIN HỮU ÍCH</div>
        <div class="men_clock">
            <div v-for="news in NewNews" :key="news.id_news" class="news"
            @click="$router.push({name:'contentnews',params:{id_news:news.id_news}})">
                <div class="imageNews">
                    <img :src="UrlImageNews+news.image" alt="">
                </div>
                <div class="titleNews">{{news.title}}</div>
                <div class="content">
                    {{news.content}}
                </div>
            </div>
        </div>
        <div class="btn_set">
            <button @click="$router.push({name:'news'})">XEM TẤT CẢ</button>
        </div>
    </div>
</div>
</div>
</template>

<script>
import BaseRequest from '@/BaseRequest'
import {mapState,mapMutations} from 'vuex'
import Loading from '../Loading.vue'
import IconLoading from '../IconLoading.vue'
export default {
    components:{
        Loading,
        IconLoading
    },
    data(){
        return{
            ProductFeatured:{},
            ProductMen:{},
            ProductWomen:{},
            NewNews:{},
            Cart:{
                id_product:'',
                id_user:'',
                quantity:1,
                colors:'mặc định'
            },
            loading:true,
            TransformPX:0,
            QuantityProduct:0,
            ProductSlide:0,
            SizeProductSlide:0,
            SlideBarClick:true,
            SlideDrag:0,
            Mouse:false,
            CoordinatesX:0,
            Drag:0,
            Click:false,
            IconLoading:false,
            SizeAplle:50,
            Numberproduct:2
        }
    },
    created(){
        this.CheckSize()
        window.addEventListener('resize', ()=>{
            this.CheckSize()
            this.FeaturedProduct()
        })
        BaseRequest.get('/Home-product-featured')
        .then((response)=>{
            this.ProductFeatured = response.data
            this.ProductFeatured.forEach(e => {
                e.ViewCart = false
            })
        })
        BaseRequest.get('/Home-product-men')
        .then((response)=>{
            this.ProductMen = response.data
            this.ProductMen.forEach(e => {
                e.ViewCart = false
            })
        })
        BaseRequest.get('/Home-product-women')
        .then((response)=>{
            this.ProductWomen = response.data
            this.ProductWomen.forEach(e=>{
                e.ViewCart = false
            })
        })
        BaseRequest.get('/home-get-new-news')
        .then((response)=>{
            this.NewNews = response.data
            this.loading = false
            this.$nextTick(()=>{
            this.FeaturedProduct()
            })
        })
    },
    computed:{
        ...mapState(['User','UrlImageNews']),
    },
    methods:{
        ...mapMutations(['setquantity']),
        CheckSize(){
            if(window.innerWidth < 740){
                this.SizeAplle = 50
                this.Numberproduct = 2
            }
            else{
                this.SizeAplle =25
                this.Numberproduct = 4
            }
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
        FeaturedProduct:function(){
            for(var i = 0 ; i < this.$refs.Featured_Product.length ; i++){
                this.$refs.Featured_Product[i].style.left = this.SizeAplle * i + '%'
            }
            this.QuantityProduct = this.$refs.Featured_Product.length
            this.SizeProductSlide = this.$refs.Slide_product.clientWidth
            this.ProductSlide =  this.$refs.Slide_product
            this.SlideDrag = this.$refs.DragSlide
        },
        //Click Silide
        ProductSlidebar(n){
            if(this.SlideBarClick == true){
                this.PushProduct(this.TransformPX += n)
            }
        },
        PushProduct:function(n){
            let Size = this.SizeProductSlide
            let Product = Math.ceil(this.QuantityProduct / this.Numberproduct)
            let PX = this.QuantityProduct / this.Numberproduct * Size - Size
            // console.log()
            if(n == Product * Size - Size){
                this.TransformPX = PX 
            }
            if(n > Product * Size - Size){
                for(let i = 0 ; i < this.Numberproduct ; i++){
                    this.$refs.Featured_Product[i].style.left = this.SizeAplle * (i + this.QuantityProduct) + '%'
                }
                this.SlideBarClick = false
                this.ProductSlide.addEventListener('transitionend', this.ResetNext)                
            }
            if(n > (-Size) && n < 0){
                this.TransformPX = 0
            }
            if(n <= (-Size)){
                // console.log(this.SizeProductSlide)
                this.TransformPX = this.SizeProductSlide
                for(let i = this.QuantityProduct - this.Numberproduct ; i < this.QuantityProduct ; i++){
                    this.$refs.Featured_Product[i].style.left = this.SizeAplle * (i - this.QuantityProduct) + '%'
                }
                this.$refs.Slide_product.style.transform = 'translateX('+100*(this.TransformPX/this.SizeProductSlide)+'%)'
                this.$refs.Slide_product.style.transition = 'transform 0.6s'
                this.SlideBarClick = false
                this.ProductSlide.addEventListener('transitionend', this.ResetPrev) 
                return
            }
            this.$refs.Slide_product.style.transform = 'translateX(-'+100*(this.TransformPX/this.SizeProductSlide)+'%)'
            this.$refs.Slide_product.style.transition = 'transform 0.6s' 
        },
        ResetNext:function(){
            this.FeaturedProduct()
            this.TransformPX = 0
            this.ProductSlide.style.transition = 'none'
            this.ProductSlide.style.transform = 'translateX(-'+this.TransformPX+'%)'
            this.ProductSlide.removeEventListener('transitionend', this.ResetNext)
            this.SlideBarClick = true
        },
        ResetPrev:function(){
            let Size = this.SizeProductSlide
            let PX = this.QuantityProduct / this.Numberproduct * Size - Size

            this.FeaturedProduct()
            this.TransformPX = PX 
            this.ProductSlide.style.transition = 'none'
            this.ProductSlide.style.transform = 'translateX(-'+100*(this.TransformPX/this.SizeProductSlide)+'%)'
            this.ProductSlide.removeEventListener('transitionend', this.ResetPrev)
            this.SlideBarClick = true
        },
        MouseDown(e){
            this.SlideDrag.style.cursor = 'grabbing'
            // e.preventDefault()
            this.Mouse = true
            this.CoordinatesX = e.clientX
        },
        MouseUp(){
            this.SlideDrag.style.cursor = 'grab'
            this.Mouse = false
            this.Click = false
            let totalWidth = this.SizeProductSlide / 2.5
            if(this.Drag > 0 && this.Drag > totalWidth ){
                this.ProductSlidebar(this.SizeProductSlide)
            }
            else if(this.Drag < 0 && this.Drag < (-totalWidth)){
                 this.ProductSlidebar(-this.SizeProductSlide)
            }
            else{
                this.PushProduct(this.TransformPX)
            }
            
        },
        MouseEnter(){
            this.SlideDrag.style.cursor = 'grab'
            this.Mouse = false
        },
        MouseMove(e){
            if(!this.Mouse) return;
            this.Click = true
            e.preventDefault()
            let A = e.clientX - this.CoordinatesX
            let PX = (-(this.TransformPX) + A)
            this.ProductSlide.style.transition = 'none'
            this.ProductSlide.style.transform = 'translateX('+ PX +'px)'
            this.Drag = -A
        }
    },
    mounted(){
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
}
</script>

<style scoped src = "@/assets/styles/frontend/Content_home.css">
</style>