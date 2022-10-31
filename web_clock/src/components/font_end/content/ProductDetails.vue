<template>
<div>
    <Loading v-if="Product==0"></Loading>
    <IconLoading v-if="IconLoading"></IconLoading>
<div v-if="Product!=='0'">
    <div class="flex_details">
        <div class="flex_left">
            <p>SẢN PHẨM MỚI NHẤT</p>
            <div class="product-latest">
                <div v-for="product in Newproduct" :key="product.id" class="product-latest-menu">
                    <div class="img-product-menu">
                        <img :src="UrlImage+product.image" alt="">
                    </div>
                    <div class="name-product-menu" @click="$router.push({name:'productdetails',params:{id:product.id}})">
                        {{product.name}}
                    </div>
                </div>
            </div>
            <p>BÀI VIẾT MỚI NHẤT</p>
            <div class="product-latest">
                <div v-for="news in NewNews" :key="news.id_news" class="product-latest-menu" 
                @click="$router.push({name:'contentnews',params:{id_news:news.id_news}})">
                    <div class="img-product-menu">
                        <img :src="UrlImageNews+news.image" alt="">
                    </div>
                    <div class="name-product-menu">
                        {{news.title}}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex_right">
            <div class="message">{{Message}}</div>
            <div class="product-flex">
                <div class="product-flex-left">
                    <div class="image_product">
                        <div class="promotion" v-if="Product.promotion_price>0">
                            -{{100-(Product.promotion_price/Product.price)*100}}%
                        </div>
                        <a target="targer" :href="UrlImage+Product.image">
                        <img :src="UrlImage+Product.image" alt="IMAGE">
                        </a>
                        <div class="image_details">{{details}}</div>
                    </div>
                    <div class="images">
                        <img :src="UrlImage+image" @click="getimage" alt="IMAGE">
                        <img v-for="image in ProductImages" :key="image.id"
                        :src="UrlImage+image.images" @click="ChooseImages(image)" alt="IMAGE">
                    </div>
                </div>
                <div class="product-flex-right">
                    <div class="details-product">
                        <h3>{{Product.name}}</h3>
                        <span>
                        <i v-if="Star>=1" class="fas fa-star"></i>
                        <i v-if="Star>1" class="fas fa-star"></i>
                        <i v-if="Star>2" class="fas fa-star"></i>
                        <i v-if="Star>3" class="fas fa-star"></i>
                        <i v-if="Star>=4" class="fas fa-star"></i>
                        </span>
                        <div class = "money" v-if="Product.promotion_price>0">
                            <p class = "money-price-promotion">{{Product.price|MoneyFormat}}</p>
                            <p class = "money-price">{{Product.promotion_price|MoneyFormat}}</p>
                        </div>
                        <!-- <p class="money" v-if="Product.promotion_price>0"> <span>{{Product.price|MoneyFormat}}</span>{{Product.promotion_price|MoneyFormat}} </p> -->
                        <p class="money" v-if="Product.promotion_price==0||Product.promotion_price==null" > {{Product.price|MoneyFormat}} </p>
                        <p>{{Product.description}}</p>
                        <p v-if="Product.status==1" class="btn_cart">Sản phẩm này đã hết hàng hoặc không có sẵn.</p>
                        <div  class="input_radio">
                            <input type="radio"  value="Mặc định" v-model="Cart.colors" :checked="true" name="radio" >
                            <label for="color">Mặc định</label>
                        </div>                    
                        <div v-for=" details in ProductImages " :key="details.id" class="input_radio">
                            <input type="radio" id="color" :value="details.descriptions" v-model="Cart.colors" name="radio" >
                            <label for="color"  >{{details.descriptions}}</label>
                        </div>
                        <div v-if="Product.status==0" class="input">
                            <p>
                                <input class="btn_dow" type="button" @click="Cart.quantity-=1" :disabled="Cart.quantity<2" value="-">
                                <input class="quantity_btn" type="number" min="0" v-model="Cart.quantity">
                                <input class="btn_up" type="button"  @click="Cart.quantity+=1" value="+">
                            </p>
                            <p>
                                <input class="btn_addcart" @click="AddCart()" type="button" value="thêm vào giỏ">
                            </p>
                        </div>
                        <p class="type_product">DANH MỤC: {{Product.type_product|TypeProduct}}</p>
                    </div>
                </div>            
            </div>
            <div class="information-product">
                <div class="tab-information-product">
                    <div class="btn-tab">
                        <button @click="active=1" :class="{'active':active==1}">THÔNG TIN CHI TIẾT</button>
                        <button @click="active=2" :class="{'active':active==2}" class="btn_link">ĐÁNH GIÁ</button>
                        <button @click="active=3" :class="{'active':active==3}" class="btn_link">CHÍNH SÁCH BẢO HÀNH</button>
                    </div>
                    <div v-if="active==1" class="tab_content">
                        <table>
                            <tbody>
                                <tr>
                                    <th>BỘ MÁY & NĂNG LƯỢNG</th>
                                    <td>{{Product.batery}}</td>
                                </tr>
                                <tr>
                                    <th>CHẤT LIỆU DÂY</th>
                                    <td>{{Product.material}}</td>
                                </tr>  
                                <tr>
                                    <th>CHẤT LIỆU MẶT KÍNH</th>
                                    <td>{{Product.material_glass}}</td>
                                </tr>  
                                <tr>
                                    <th>GIỚI TÍNH</th>
                                    <td>{{Product.type_product|TypeProduct}}</td>
                                </tr>  
                                <tr>
                                    <th>HÌNH DẠNG MẶT SỐ</th>
                                    <td>{{Product.glass_shape}}</td>
                                </tr>  
                                <tr>
                                    <th>KÍCH THƯỚC MẶT SỐ</th>
                                    <td>{{Product.glass_size}}</td>
                                </tr>
                                <tr>
                                    <th>MÀU MẶT SỐ</th>
                                    <td>{{Product.color}}</td>
                                </tr> 
                                <tr>
                                    <th>MỨC CHỐNG NƯỚC</th>
                                    <td>{{Product.waterproof_lever}}</td>
                                </tr> 
                                <tr>
                                    <th>THƯƠNG HIỆU</th>
                                    <td>{{Product.trademark}}</td>
                                </tr> 
                                <tr>
                                    <th>XUẤT XỨ</th>
                                    <td>{{Product.origin}}</td>
                                </tr>                              
                            </tbody>
                        </table>
                    </div>
                    <div v-if="active==2" class="tab_content">
                        <div class="reviews">
                            <p>ĐÁNH GIÁ SẢN PHẨM</p>
                            <p v-if="this.Reviews.length == 0">Chưa có đánh giá nào</p>
                            <div class="conten_reviews" v-for="review in Reviews" :key="review.id_reviews">
                                <div class="image_user">
                                    <img v-if="review.image=='null'" src="@/assets/user.png" alt="">
                                    <img v-if="review.image!=='null'" :src="UrlImageUser+review.image" alt="">
                                </div>
                                <div class="text_content">
                                    <div class="name_user">{{review.name}}</div>
                                    <div class="star_review">
                                        <i class="fas fa-star" v-if="review.star>=1"></i>
                                        <i class="fas fa-star" v-if="review.star>1"></i>
                                        <i class="fas fa-star" v-if="review.star>2"></i>
                                        <i class="fas fa-star" v-if="review.star>3"></i>
                                        <i class="fas fa-star" v-if="review.star>=4"></i>
                                    </div>
                                    <div class="content">
                                        {{review.comment}}
                                        <p>{{review.created_at}}</p>
                                    </div>
                                    <div v-if="review.feedback !== null" class="reply_review">
                                        <p>Phản hồi của người bán</p>
                                    {{review.feedback}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="active==3" class="tab_content">
                        <div class="insurance">
                            <div class="name_product">
                                {{Product.name}}
                            </div>
                            <div class="content_insurance">
                                {{Product.content}}
                            </div>
                        </div>
                    </div>                
                </div>
            </div>        
        </div>
    </div>
</div>
</div>
</template>

<script>
import {mapState,mapMutations} from 'vuex'
import BaseRequest from '@/BaseRequest'
import Loading from './Loading.vue'
import IconLoading from './IconLoading.vue'
export default {
    components:{
        Loading,
        IconLoading
    },
    data(){
        return{
            // idproduct:this.$route.params.id,
            active:1,
            image:'',
            details:'Mặc định',
            Newproduct:{},
            Product:'0',
            Reviews:{},
            Star:0,
            Cart:{
                id_product:'',
                id_user:'',
                quantity:1,
                colors:'Mặc định'
            }, 
            ProductImages:{},
            NewNews:{},
            Message:'',       
            IconLoading:false
        }
    },
    computed:{
        ...mapState(['UrlImage','User','UrlImageUser','UrlImageNews']),
        idproduct(){
            return this.$route.params.id
        }
    },
    created(){
        window.scrollTo(0,0)
        BaseRequest.get('/getnewproduct')
        .then((response)=>{
            this.Newproduct = response.data
        })

        BaseRequest.get('/productdetails/'+this.idproduct)
        .then((response)=>{
            this.Product = response.data
            this.image = response.data.image
        })
        BaseRequest.get('/get-reviews-product/'+this.idproduct)
        .then((response)=>{
            this.Reviews = response.data
        })

        BaseRequest.get('/user-get-images/'+this.idproduct)
        .then((response)=>{
            this.ProductImages = response.data
        })

        BaseRequest.get('/get-star/'+this.idproduct)
        .then((response)=>{
            this.Star = response.data
        })
        BaseRequest.get('/get-new-news')
        .then((response)=>{
            this.NewNews = response.data
        })
    },
    methods:{
        ...mapMutations(['setquantity']),

        AddCart(){
            this.Cart.id_product = this.Product.id
            this.IconLoading = true
            if(this.User!=false&&this.User!=true){
                this.Cart.id_user = this.User.id
                BaseRequest.post('/cart',this.Cart)
                .then((reaponse)=>{
                    this.IconLoading = false
                    this.setquantity(reaponse.data.length )
                    this.Message = this.Product.name+' đã được thêm vào giỏ hàng'
                    setTimeout(() => {
                       this.Message = '' 
                    },6000);
                })
            }
            else{
                this.$router.push({name:'login'})
            }
        },
        ChooseImages:function(image){
            this.Product.image = image.images
            this.details = image.descriptions
        },
        getimage(){
            this.Product.image = this.image
            this.details = 'Mặc định'
        },
    },
        filters:{
        TypeProduct:function(types){
            if(types == 0){
                return(types = 'ĐỒNG HỒ NAM')
            }
            else{
                return(types = 'ĐỒNG HỒ NAM')
            }
        },
        MoneyFormat:function(money){
            return (new Intl.NumberFormat('de-DE').format(money)+' VND');
        }, 
    },
    watch:{
        idproduct:function(){
            this.Product ='0'
            BaseRequest.get('/productdetails/'+this.idproduct)
            .then((response)=>{
                this.Product = response.data
            })
            BaseRequest.get('/user-get-images/'+this.idproduct)
            .then((response)=>{
                this.ProductImages = response.data
            })
            BaseRequest.get('/productdetails/'+this.idproduct)
            .then((response)=>{
                this.Product = response.data
                this.image = response.data.image
            })
            BaseRequest.get('/get-reviews-product/'+this.idproduct)
            .then((response)=>{
                this.Reviews = response.data
            })
            BaseRequest.get('/get-star/'+this.idproduct)
            .then((response)=>{
                this.Star = response.data
            })
            this.Message=''
        }
    },
    beforeDestroy(){
        this.Product='0'
    }
}
</script>

<style scoped src = "@/assets/styles/frontend/ProductDetails.css">
</style>