<template>
    <div class="product_details " v-bind:class="{set_left: feedback}" >
        <p>PHẢN HỒI ĐÁNH GIÁ</p>
        <p class="close" @click="$store.state.feedback = true"><i class="fas fa-times fa-2x"></i></p>
        <div class="reviews">
            <table class="table" v-for="product in ProductsReviews" :key="product.id">
                <tr>
                    <th style="width:10%;" >ID: {{product.id}} </th>
                    <th style="width:10%;"><img :src="UrlImage+product.image" alt="Hình ảnh sản phẩm"></th>
                    <th><div class="name-image">{{product.name}}</div></th>
                </tr>
                <tr>
                    <td colspan="3">ĐÁNH GIÁ CỦA KHÁCH HÀNG</td>
                </tr>
                <tr>
                    <td class="rating" colspan="2">
                        <i class="fas fa-star active" v-if="product.star>4" ></i>
                        <i class="fas fa-star active" v-if="product.star>3" ></i>
                        <i class="fas fa-star active" v-if="product.star>2" ></i>
                        <i class="fas fa-star active" v-if="product.star>1" ></i>
                        <i class="fas fa-star active" v-if="product.star>=1" ></i>
                        <br><button @click="RealoaDom(product)" class="btn_feedback">PHẢN HỒI</button>                      
                    </td>
                    <td >
                        <textarea placeholder="Nội dung" class="contentReviews" disabled name="" id="" cols="76" rows="3" v-model="product.comment"></textarea>
                        <textarea v-show="product.check" placeholder="Nội dung phản hồi"  name="" id="" cols="76" rows="3" v-model="product.feedback"></textarea>
                    </td>
                </tr>
            </table>
            <div class="btn_update">
                <button @click="SetFeedback" class="btn_add" :disabled="loading" >
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
        SetIdOrder:Number
    },
    data(){
        return{
            status:'GỬI PHẢN HỒI',
            loading:false,
            active:0,
            ProductsReviews:{},
            Feedback:[],
        }
    },
    computed:{
        ...mapGetters(['feedback']),
        ...mapState(['UrlImage','User'])
    },
    methods:{
        SetFeedback(){
            for(var i = 0 ; i<this.ProductsReviews.length; i++){
                this.Feedback[i]={
                    id_reviews: this.ProductsReviews[i].id_reviews,
                    feedback: this.ProductsReviews[i].feedback
                }
            }
            this.loading = true
            let feedback = this.Feedback
            BaseRequest.PostAdmin('/set-feedback-reviews/'+this.SetIdOrder,{feedback})
            .then((response)=>{
                alert('Gửi phản hồi thành công')
                this.loading = false
                this.$store.state.feedback = true
                this.$emit('Order', response.data)
            })
        },
        RealoaDom(product){
            product.check =! product.check
            this.$forceUpdate()
        }
    },
    watch:{
        SetIdOrder(){
        BaseRequest.PostAdmin('/get-feedback-reviews/'+this.SetIdOrder)
            .then((response)=>{
                this.ProductsReviews = response.data
                this.ProductsReviews.forEach(e=>{
                    e.check = false
                })
            })            
        },
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
    width: 30px;
    height: 30px;
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
.btn_feedback{
    border: none;
    padding: 10px;
    background: rgb(250, 198, 28);
    margin-top: 6px;
    color: white;
    transition: all 0.6s;
}
.btn_feedback:hover{
    border-radius: 10px;
    background: rgb(250, 211, 82);
}
.contentReviews{
    background: #e9e9e9;
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
</style>