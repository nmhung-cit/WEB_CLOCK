<template>
<div> 
    <Loading v-if="User == false||Loading ==true"></Loading> 
    <IconLoading v-if="IconLoading"></IconLoading>
    <div @click="$router.push({name:'home'})" class="note_cart" v-if="note">
        <h2>GIỎ HÀNG TRỐNG</h2>
        <p>Nhấn vào để quay lại cửa hàng</p>
    </div>
    <div v-if="User!=false&&Loading == false&&note == false" class="flex_cart">
        <div class="flex_left" >
            <table>
                <tr>
                    <th colspan="2">SẢN PHẨM</th>
                    <th class="apple">MÀU SẮC</th>
                    <th style="text-align: center;" class="apple">GIÁ</th>
                    <th>SỐ LƯỢNG</th>
                    <th style="text-align: right;" >TỔNG TIỀN</th>
                </tr>
                <tr v-for="(product) in Products" :key="product.id_cart">
                    <td>
                        <span @click="DeleteCart(product)" ><i class="far fa-window-close"></i>
                        </span><img class="image" :src="$store.state.UrlImage+product.image" alt="ảnh sản phẩm">
                    </td>
                    <td class="nameproduct apple-name">
                       {{product.name}}
                    </td>
                    <!-- apple -->
                    <td class="nameproduct apple-name-none" v-if="product.promotion_price==0||product.promotion_price==null">
                       {{product.name}} - <span>{{product.colors}}</span> X {{product.price|MoneyFormat}}
                    </td>
                    <td class="nameproduct apple-name-none" v-if="product.promotion_price>0">
                       {{product.name}} - <span>{{product.colors}}</span> X {{product.promotion_price|MoneyFormat}}
                    </td>
                    <!-- end-apple-nameproduct -->
                    <td class="apple">
                        {{product.colors}}
                    </td>
                    <td class="apple" v-if="product.promotion_price==0||product.promotion_price==null">
                        {{product.price|MoneyFormat}}
                    </td>
                    <td class="apple" v-if="product.promotion_price>0">
                        {{product.promotion_price|MoneyFormat}}
                    </td>
                    <td class="input_price">
                        <input type="number" min="1" max="9999" step="1" v-model="product.quantity" >
                    </td>
                    <td v-if="product.promotion_price==0||product.promotion_price==null">
                        {{product.price*product.quantity|MoneyFormat}}
                    </td>
                    <td v-if="product.promotion_price>0">
                        {{product.promotion_price*product.quantity|MoneyFormat}}
                    </td>
                </tr>
            </table>
            <input @click="UpdateCart" class="btn_uploadcart" type="button" value="CẬP NHẬT GIỎ HÀNG" :disabled="disabled">    
        </div>
        <div class="flex_right">
            <table>
                <tr>
                    <th colspan="2">TỔNG THANH TOÁN</th>
                </tr>
                <tr>
                    <td class="title">Số lượng:</td>
                    <td class="result">{{TotalQuantity}}</td>
                </tr>
                <tr>
                    <td class="title">Giao hàng:</td>
                    <td class="result">
                        <p>Phí giao hàng:</p>
                        <p>Miễn phí</p>
                    </td>
                </tr> 
                <tr>
                    <td class="title_discount">Tổng tiền thanh toán:</td>
                    <td class="result">{{TotalPrice|MoneyFormat}}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>Mã Giảm giá(nếu có):</span>
                        <p  class="input_discount"><input type="text" placeholder="Nhập Mã Giảm Giá " ></p>
                         <p  class="input_discount"><input type="button" value="Áp dụng ưu đãi" ></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="btn_checked">
                        <input @click="$router.push({name:'oder'})" type="button" value="TIẾN HÀNH THANH TOÁN">
                    </td>
                </tr>                                  
            </table>
        </div>
    </div>
</div>
</template>

<script>
import IconLoading from './IconLoading.vue'
import Loading from './Loading.vue'
import {mapState,mapMutations} from 'vuex'
import BaseRequest from '@/BaseRequest'
export default {
    components:{
        Loading,
        IconLoading
    },
    data(){
        return{
            Loading:true,
            Products:[],
            quantity:1,
            IconLoading:false,
            TotalQuantity:0,
            TotalPrice:0,
            note:false,
            disabled:true,
        }
    },
    created(){
        window.scrollTo(0,0)
        this.GetCart()
    },
    computed:{
        ...mapState(['User'])  
    },
    methods:{
        ...mapMutations(['setquantity']),
        GetCart(){
            if(this.User!==false&&this.User!==true){
                BaseRequest.post('/getproductcart',this.User)
                .then((response)=>{
                    this.Products = response.data
                    this.Check()
                    this.Loading = false
                    if(this.Products==0){
                       this.note = true
                    }
                    else
                    {
                        this.note = false
                    }
                })
            }
            else{
                this.$router.push({name:'login'})
            }
        },
        DeleteCart:function(product){
            this.IconLoading = true
            BaseRequest.post('/deletecart',product)
            .then((response)=>{
                this.IconLoading = false
                this.Products = response.data
                this.Check()
                this.setquantity(response.data.length )
                this.disabled = true
                if(response.data.length==0){
                    this.note = true
                }
            })
        },
        UpdateCart(){
            let products = this.Products
            this.IconLoading = true
            BaseRequest.post('/updatecart',{products})
            .then((response)=>{
                this.IconLoading = false
                this.Products = response.data
                this.Check()
                this.setquantity(response.data.length )
                this.disabled = true
                if(response.data.length==0){
                    this.note = true
                }
            })
            .catch(()=>{
            })
        },
        Check(){
            this.TotalQuantity = 0
            this.TotalPrice = 0
            for(var i = 0; i<this.Products.length; i++){
                this.TotalQuantity += this.Products[i].quantity
                if(this.Products[i].promotion_price>0){
                this.TotalPrice += this.Products[i].promotion_price*this.Products[i].quantity
                }
                else{
                    this.TotalPrice += this.Products[i].price*this.Products[i].quantity
                }
            }
        },
    },
    filters:{
        MoneyFormat:function(money){
            return (new Intl.NumberFormat('de-DE').format(money)+' VND');
        },         
    },
    watch:{
        Products:{
            deep:true,
            handler(){
                let quantity = 0
                for(var i in this.Products){
                    quantity += Number(this.Products[i].quantity)
                }
                if(quantity == this.TotalQuantity){
                    this.disabled = true
                }
                else{
                    this.disabled = false
                }
            },
        },
    }
}
</script>

<style scoped src = "@/assets/styles/frontend/Cart.css">

</style>