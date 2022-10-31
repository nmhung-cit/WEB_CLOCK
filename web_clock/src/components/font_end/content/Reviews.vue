<template>
    <div class="product_details " v-bind:class="{set_left: reviews}" >
        <p>ĐÁNH GIÁ SẢN PHẨM</p>
        <p class="close" @click="$store.state.reviews = true"><i class="fas fa-times fa-2x"></i></p>
        <div class="reviews">
            <div class="error">{{messages}}</div>
            <table class="table" v-for="product in Products" :key="product.id">
                <tr>
                    <th style="width:10%;" >ID: {{product.id}} </th>
                    <th style="width:10%;"><img :src="UrlImage+product.image" alt="Hình ảnh sản phẩm"></th>
                    <th><div class="name-image">{{product.name}}</div></th>
                </tr>
                <tr>
                    <td colspan="3">ĐÁNH GIÁ CỦA BẠN</td>
                </tr>
                <tr>
                    <td class="rating" colspan="2">
                        <i class="fas fa-star" :class="{'active':product.star>4}" @click="ChooseStar(product, 5)"></i>
                        <i class="fas fa-star" :class="{'active':product.star>3}" @click="ChooseStar(product, 4)"></i>
                        <i class="fas fa-star" :class="{'active':product.star>2}" @click="ChooseStar(product, 3)"></i>
                        <i class="fas fa-star" :class="{'active':product.star>1}" @click="ChooseStar(product, 2)"></i>
                        <i class="fas fa-star" :class="{'active':product.star>=1}" @click="ChooseStar(product, 1)"></i>                        
                    </td>
                    <td>
                        <textarea placeholder="Nội dung" name="" id="" cols="76" rows="3" v-model="product.content"></textarea>
                    </td>
                </tr>
            </table>
            <div class="btn_update">
                <button @click="SetReviews" class="btn_add" :disabled="loading||disabled" >
                    <span :class="{'spinner-border spinner-border-sm':loading}"></span>{{status}}
                </button> 
            </div>                   
        </div>
    </div>
</template>

<script>
import {mapGetters,mapState} from 'vuex'
import BaseRequest from '@/BaseRequest'
export default {
    props:{
        IdOrder:Number
    },
    data(){
        return{
            messages:'',
            status:'GỬI ĐÁNH GIÁ',
            loading:false,
            active:0,
            Products:{},
            Reviews:[],
            disabled:true
        }
    },
    computed:{
        ...mapGetters(['reviews']),
        ...mapState(['UrlImage','User'])
    },
    methods:{
        ChooseStar(product, star){
            product.star = star
            this.$forceUpdate()
            var exist = this.Products.filter(e =>
                e.star == null
            )
            if(exist.length==0){
                this.disabled = false
            }
        },
        SetReviews(){
            for(var i = 0 ; i<this.Products.length; i++){
                this.Reviews[i]={
                    id_product: this.Products[i].id,
                    id_user: this.User.id,
                    id_order:this.IdOrder,
                    star: this.Products[i].star,
                    comment: this.Products[i].content,
                }
            }
            this.loading = true
            let reviews = this.Reviews
            BaseRequest.post('/set-reviews',{reviews})
            .then((response)=>{
                alert('Cảm ơn bạn đã đánh giá sản phẩm của chúng tôi')
                this.loading = false
                this.$store.state.reviews = true
                this.$emit('ListOrder', response.data)
            })
        }
    },
    watch:{
        IdOrder(){
        BaseRequest.post('/product-reviews/'+this.IdOrder)
            .then((response)=>{
                this.Products = response.data
                this.Products.forEach(e=>{
                    e.star=null
                    e.content=''
                })
            })            
        },
        Products(){
        }
    }
}
</script>

<style scoped>
table{
    background:white;
    border-radius: 6px;
    width: 100%;
}
th>img{
    width: 60px;
    /* display: inline-block; */
}
th,td{
    padding: 10px;
}
.name-image{
    display: inline-block;
}
td>textarea{
    outline: none;
    padding: 10px;
}
.product_details{
    top: 0;
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0, 0.9);
    overflow: hidden;
    transition:  0.5s;
    z-index: 1;
}
.product_details>p{
    color: white;
    font-size: 20px;
    margin: 20px;
    text-align: center;
    text-transform: uppercase ;
}
.set_left{
    height: 0;
}
.close{
    position: absolute;
    right: 30px;
    top: 30px;
}
.reviews{
    width: 800px;
    height: 600px;
    overflow: auto !important;
    margin: auto;
    padding: 10px;
    background: rgb(250, 243, 147);
    box-shadow: 0 0 10px rgb(252, 252, 252);
    overflow: hidden;
}
.fa-star{
    color: rgb(199, 199, 199);
}
.rating{
    unicode-bidi: bidi-override;
    direction: rtl;
}
.rating> i:hover,
.rating> i:hover ~ i::before{
    color: rgb(250, 213, 6);
}
.active{
    color: rgb(250, 213, 6);
}
.btn_update{
    width: 300px;
    margin: auto;
}
.btn_add:hover{
    background: rgb(255, 255, 254);
    border:1px solid rgb(255, 255, 254);
}.btn_add{
    margin: 20px 0px;
    width: 300px;
    padding: 10px 20px;
    border:1px solid black;
    border-radius:5px ;
    transition: all 0.5s ease;
    background: none;
}
.error{
  color: red;
  font-size: 16px;
  padding-top: 10px;
  height: 20px;
  text-transform: uppercase;
}
</style>