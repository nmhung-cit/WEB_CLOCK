<template>
<div>
    <IconLoading v-if="IconLoading"></IconLoading>
    <Loading v-if="Loading"></Loading>
<div v-if="Loading == false" class="container rounded bg-white mt-5 mb-5">
    <div class="row ">
        <div class="col-md-6 border-right" >
            <div class="information">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Thông tin nhận hàng</h4>
                </div>
                <h6> <span :class="{'error':Messages}">{{Messages}}</span> </h6>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">Tên
                        <div class="note"><span id="star">*</span><span id="obligatory">Bắt Buộc</span></div>
                        </label><input type="text" class="form-control" v-model="ShipmentDetails.name"></div>
                    <div class="col-md-6"><label class="labels">Họ
                        <div class="note"><span id="star">*</span><span id="obligatory">Bắt Buộc</span></div>
                        </label><input type="text" class="form-control" v-model="ShipmentDetails.surname"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Số điện thoại(+84)</label>
                     <div class="note"><span id="star">*</span><span id="obligatory">Bắt Buộc</span></div>
                    <input  type="number" class="form-control " v-model="ShipmentDetails.phone_number"></div>

                    <div class="col-md-12"><label class="labels">Tỉnh thành phố
                        <div class="note"><span id="star">*</span><span id="obligatory">Bắt Buộc</span></div></label>
                        <select class="form-control" v-model="City_Province" @click="Showaddress=false">
                            <option v-if="Showaddress" value="">{{ShipmentDetails.city_province}}</option>
                            <option v-for="address in Address" :key="address.id" :value="address" >{{address.Name}}</option>
                        </select>
                    </div>
                    <div class="col-md-12"><label class="labels">Quận huyện
                        <div class="note"><span id="star">*</span><span id="obligatory">Bắt Buộc</span></div></label>
                        <select class="form-control"  v-model="Districts"  @click="Showaddress=false">
                            <option v-if="Showaddress" value="">{{ShipmentDetails.district}}</option>
                            <option v-for="district in City_Province.Districts" :key="district.id" :value="district">{{district.Name}}</option>
                        </select>
                    </div>                    
                    <div class="col-md-12"><label class="labels">Phường xã
                        <div class="note"><span id="star">*</span><span id="obligatory">Bắt Buộc</span></div></label>
                        <select class="form-control" v-model="Wards" @change="SetShipmentDetail"  @click="Showaddress=false">
                            <option v-if="Showaddress" value="">{{ShipmentDetails.wards}}</option>
                            <option v-for="(ward) in Districts.Wards" :key="ward.Id" :value="ward">{{ward.Name}}</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Số nhà/Thôn
                            <div class="note"><span id="star">*</span><span id="obligatory">Bắt Buộc</span></div></label>
                        <input type="text" class="form-control" v-model="ShipmentDetails.address">
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Ghi chú</label>
                        <textarea id="" cols="30" rows="5" v-model="Node" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-6">
             <div class="p-3  order">
                <table>
                    <tr>
                        <th id="title">ĐƠN HÀNG CỦA BẠN</th>
                    </tr>
                    <tr id="tr_border">
                        <th>SẢN PHẨM</th>
                        <th id="text_right">TỔNG CỘNG</th>
                    </tr>
                    <tr v-for="product in Products" :key="product.id_cart" id="td_tr_boder">
                        <td>
                            {{product.name}} <span> x {{product.quantity}}</span> - <span class="color">{{product.colors}}</span> 
                        </td>
                        <td v-if="product.promotion_price==0||product.promotion_price==null" id="td_text_right">
                            {{product.price*product.quantity|MoneyFormat}} 
                        </td>
                        <td v-if="product.promotion_price>0" id="td_text_right">
                            {{product.promotion_price*product.quantity|MoneyFormat}} 
                        </td>
                    </tr>
                    <tr id="td_tr_boder">
                        <th>GIAO HÀNG</th>
                        <td>Giao hàng miễn phí</td>
                    </tr>
                    <tr id="td_tr_boder1">
                        <th>TỔNG TIỀN</th>
                        <td id="td_text_right">{{TotalPrice|MoneyFormat}}</td>
                    </tr>
                    <tr>
                        <th>HÌNH THỨC TRẢ TIỀN</th>
                        <td>Trả tiền khi nhận hàng</td>
                    </tr>
                    <tr>
                        <th>
                            <div class="mt-2 "><button class=" profile-button" @click="AddOrder()" type="button">ĐẶT HÀNG</button></div>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</template>

<script>

import IconLoading from './IconLoading.vue'
import BaseRequest from '@/BaseRequest'
import {mapState,mapGetters,mapMutations} from 'vuex'
import VietNam from '@/DiagioiVietNam'
import Loading from './Loading.vue'
export default {
    components:{
        IconLoading,
        Loading
    },
    data(){
        return{
            IconLoading:false,
            Loading:true,
            Address:VietNam,
            City_Province:'',
            Districts:'',
            Wards:'',
            Showaddress:true,
            ShipmentDetails:{},
            Products:{},
            TotalPrice:0,
            Order:{},
            OrderDetails:[],
            Node:'',
            Messages:''
        }
    },
    computed:{
        ...mapState(['User']),
        ...mapGetters(['url'])
    },
    created(){
        if(this.User == false||this.User == true){
            this.$router.push({name:'login'})
        }
        else if(this.$store.state.CartQuantity<1){
            this.$router.push({name:'home'})
        }
        else{
        BaseRequest.post('/shipment-details',this.User)
        .then((response)=>{
            var n = response.data[0]
            if(n == undefined){
                return
            }
            else{
                this.ShipmentDetails = response.data[0]
            }
        })
        BaseRequest.post('/getproductcart',this.User)
        .then((response)=>{
            this.Products = response.data
            this.Loading = false
        })
        }
    },
    methods:{
        ...mapMutations(['setquantity']),
        SetShipmentDetail(){
            this.ShipmentDetails.city_province = this.City_Province.Name
            this.ShipmentDetails.district = this.Districts.Name
            this.ShipmentDetails.wards = this.Wards.Name
        },
        AddOrder(){
            this.IconLoading = true
            this.ShipmentDetails.id_user = this.User.id
            BaseRequest.post('/up-shipment-details',this.ShipmentDetails)
            .then((response)=>{
                this.ShipmentDetails = response.data
                this.Order.id_user = response.data.id_user
                this.Order.id_shipment_Details = response.data.id_shipment_details
                this.Order.node = this.Node
                BaseRequest.post('/order',this.Order)
                .then((response)=>{
                    for(var i = 0; i<this.Products.length; i++){
                        if(this.Products[i].promotion_price>0){
                            this.OrderDetails[i] = {
                                id_order: response.data.id_order,
                                id_product:this.Products[i].id_product,
                                color:this.Products[i].colors,
                                quantity:this.Products[i].quantity,
                                totalmoneys:this.Products[i].promotion_price*this.Products[i].quantity
                            }
                        }
                        else{
                            this.OrderDetails[i] = {
                                id_order: response.data.id_order,
                                id_product:this.Products[i].id_product,
                                color:this.Products[i].colors,
                                quantity:this.Products[i].quantity,
                                totalmoneys:this.Products[i].price*this.Products[i].quantity
                            }
                        }
                    }
                    let orderdetails = this.OrderDetails
                    BaseRequest.post('/order-details',{orderdetails})
                    .then(()=>{
                        BaseRequest.get('/delete-user-cart/'+this.User.id)
                        .then(()=>{
                            this.setquantity(0)
                            this.IconLoading = false
                            this.$router.push({name:'userorder'})
                        })
                    })
                })
            })
            .catch((error)=>{
                this.Messages = error.response.data.message
                this.IconLoading = false
            })
        }
    },
    filters:{
        MoneyFormat:function(money){
            return (new Intl.NumberFormat('de-DE').format(money)+' VND');
        },         
    },
    watch:{
        Products:function(){
            this.TotalPrice=0
            for(var i = 0; i<this.Products.length; i++){
                if(this.Products[i].promotion_price>0){
                this.TotalPrice += this.Products[i].promotion_price*this.Products[i].quantity
                }
                else{
                    this.TotalPrice += this.Products[i].price*this.Products[i].quantity
                }
            }        
        }
    }
}
</script>

<style scoped src = "@/assets/styles/frontend/Oder.css">

</style>