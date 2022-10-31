<template>
    <div class="product_details " v-bind:class="{set_left: productdetails}" >
        <p>CHI TIẾT SẢN PHẨM </p>
        <p class="close" @click="$store.state.productdetails = true"><i class="fas fa-times fa-2x"></i></p>
        <div class="productdetails">
                <div class="form_left">
                    <div class="error">{{messages}}</div>
                    <table class="table">
                        <tr>
                            <th>BỘ MÁY & NĂNG LƯỢNG</th>
                            <td><input type="text" v-model="Setproductdetails.batery" ></td>
                        </tr>
                        <tr>
                            <th>CHẤT LIỆU DÂY</th>
                            <td><input type="text" v-model="Setproductdetails.material" ></td>
                        </tr>
                        <tr>
                            <th>CHẤT LIỆU MẶT KÍNH</th>
                            <td><input type="text" v-model="Setproductdetails.material_glass" ></td>
                        </tr>
                        <tr>
                            <th>HÌNH DẠNG MẶT SỐ</th>
                            <td><input type="text" v-model="Setproductdetails.glass_shape" ></td>
                        </tr>
                        <tr>
                            <th>KÍCH THƯỚC MẶT SỐ</th>
                            <td><input type="text" v-model="Setproductdetails.glass_size" ></td>
                        </tr>
                        <tr>
                            <th>MÀU SẮC</th>
                            <td><input type="text" v-model="Setproductdetails.color" ></td>
                        </tr>
                        <tr>
                            <th>MỨC CHỐNG NƯỚC</th>
                            <td><input type="text" v-model="Setproductdetails.waterproof_lever" ></td>
                        </tr>
                        <tr>
                            <th>XUẤT XỨ</th>
                            <td><input type="text" v-model="Setproductdetails.origin" ></td>
                        </tr>
                    </table>
                    <div class="btn_update">
                    <button @click="Updetailsproduct" class="btn_add" :disabled="loading" >
                        <span :class="{'spinner-border spinner-border-sm':loading}"></span>{{status}}
                    </button> 
                    </div>                   
                </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import BaseRequest from '@/BaseRequest'
export default {
    props:{
        Setproductdetails:Object
    },
    data(){
        return{
            messages:'',
            status:'CẬP NHẬT',
            loading:false,
        }
    },
    computed:{
        ...mapGetters(['productdetails']),
    },
    methods:{
        Updetailsproduct(){
            this.loading=true
            this.status = 'Loading...'
            BaseRequest.PostAdmin('/update-details-product',this.Setproductdetails)
            .then((response)=>{
                 this.$store.state.addproducts = response.data
                 this.loading=false
                 this.status='CẬP NHẬT'
                 this.messages = 'Cập nhật thành công'
                 setTimeout(() => {
                     this.messages=null
                 }, 3000);
            })
            .catch((error)=>{
                 this.loading=false
                 this.status='CẬP NHẬT'
                 this.messages = error.response.data.message
                 setTimeout(() => {
                     this.messages=null
                 }, 3000);                
            })
        }
    },
}
</script>

<style scoped>
table{
    width: 100%;
    margin-top:20px;
}
table>tr>th{
    padding: 10px;
}
table>tr>td{
    text-align: right;
}
table>tr>td>input{
    border: none;
    outline: none;
    background:rgb(247, 247, 151);
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
.productdetails{
    width: 800px;
    margin: auto;
    background: rgb(248, 250, 250);
    border-radius:20px;
    box-shadow: 0 0 10px rgb(252, 252, 252);
    overflow: hidden;
}
.detailsproduct{
    width: 800px;
    background: white;
}
.form_left{
    width: 600px;
    margin: auto;
}
.btn_add:hover{
    background: rgb(233, 243, 99);
    border:1px solid rgb(233, 243, 99);
    color: white;
}.btn_add{
    margin: 20px 0px;
    width: 300px;
    padding: 10px 20px;
    border:1px solid black;
    border-radius:5px ;
    transition: all 0.5s ease;
    background: none;
}
.btn_update{
    width: 300px;
    margin: 0 auto;
}
.error{
  color: red;
  height: 20px;
  font-size: 16px;
  padding-top: 10px;
  text-transform: uppercase;
}
</style>