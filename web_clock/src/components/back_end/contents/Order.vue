<template>
<div class="body">
    <IconLoading v-if="Loading"></IconLoading>
    <Feedback :SetIdOrder = IdOrder @Order = SetOrder></Feedback>
    <div class="title">
        <p>quản lý đơn hàng</p>
    </div>
    <div class="btn_order">
        <button @click="active=0,OrderDetailss=0" :class="{'btn_status':active==0}">ĐANG CHỜ XỬ LÝ</button>
        <button @click="active=1,OrderDetailss=0" :class="{'btn_status':active==1}">ĐANG GIAO</button>
        <button @click="active=2,OrderDetailss=0" :class="{'btn_status':active==2}">ĐÃ GIAO</button>
        <button @click="active=3,OrderDetailss=0" :class="{'btn_status':active==3}">ĐÃ HỦY</button>
    </div>
    <div class="status" v-if="active == 0">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>TÊN KHÁCH HÀNG</th>
                <th>NGÀY ĐẶT</th>
                <th class="text-center" >TRẠNG THÁI</th>
            </tr>
            <tr v-for="order in Orders" :key="order.id_order" class="tr_hover" @click="OrderDetails(order)" v-show="order.status==0">
                <td >{{order.id_order}}</td>
                <td>{{order.userName}}</td>
                <td>{{order.created_at}}</td>
                <td class="statusOrder">{{order.status|Status}}</td>
            </tr>
        </table>
    </div>
    <div class="status" v-if="active == 1">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>TÊN KHÁCH HÀNG</th>
                <th>NGÀY ĐẶT</th>
                <th class="text-center" >TRẠNG THÁI</th>
            </tr>
            <tr v-for="order in Orders" :key="order.id_order" class="tr_hover" @click="OrderDetails(order)" v-show="order.status==1">
                <td >{{order.id_order}}</td>
                <td>{{order.userName}}</td>
                <td>{{order.created_at}}</td>
                <td class="statusOrder">{{order.status|Status}}</td>
            </tr>
        </table>
    </div>
    <div class="status" v-if="active == 2">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>TÊN KHÁCH HÀNG</th>
                <th>NGÀY ĐẶT</th>
                <th class="text-center" >TRẠNG THÁI</th>
            </tr>
            <tr v-for="order in Orders" :key="order.id_order" class="tr_hover" :class="{'Have_Review':order.status==4}"
            @click="OrderDetails(order)" v-show="order.status==2||order.status==4||order.status==5">
                <td >{{order.id_order}}</td>
                <td>{{order.userName}}</td>
                <td>{{order.created_at}}</td>
                <td class="statusOrder">{{order.status|Status}}</td>
            </tr>
        </table>
    </div>
    <div class="note-oder status" v-if="active == 2">
        <div class="no-answer">
            <div id="no-answer"></div><div>Đơn hàng chưa phản hồi đánh giá</div>
        </div>
    </div>
    <div class="status" v-if="active == 3">
        <table class="table">
            <tr >
                <th>ID</th>
                <th>TÊN KHÁCH HÀNG</th>
                <th>NGÀY ĐẶT</th>
                <th class="text-center" >TRẠNG THÁI</th>
            </tr>
            <tr v-for="order in Orders" :key="order.id_order" class="tr_hover" @click="OrderDetails(order)" v-show="order.status==3">
                <td >{{order.id_order}}</td>
                <td>{{order.userName}}</td>
                <td>{{order.created_at}}</td>
                <td class="statusOrder">{{order.status|Status}}</td>
            </tr>
        </table>
    </div>
    <div class="order-details">
        <div class="table-details" v-if="OrderDetailss!==0">
            <table class="table">
                <tr>
                    <th colspan="2">MÃ ĐƠN:{{OrderDetailss.id_order}}</th>
                    <th >{{OrderDetailss.userName}}</th>
                    <th class="text-right">{{OrderDetailss.status|Status}}</th>
                </tr>
                <tr v-for="product in ProductDetails" :key="product.id_orderdetails"  >
                    <td >MÃ SP: {{product.id}}</td>
                    <td colspan="2" >
                        <div class="product">
                            <td><img :src="UrlImage+product.image" alt=""></td>
                            <td>
                                <p>{{product.name}}</p>
                                <p> PHÂN LOẠI: {{product.type_product|TypeProduct}} </p>
                                <p> x{{product.quantity}} - {{product.color}} </p>
                            </td>
                        </div> 
                    </td>  
                    <td class="text-right text-danger ">{{product.totalmoneys|MoneyFormat}}</td>
                </tr>
                <tr>
                    <td colspan="1">
                        GHI CHÚ: 
                    </td>
                    <td colspan="3">
                        {{OrderDetailss.node}}
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <button v-if="OrderDetailss.status==0" @click="UpStatusOrder(OrderDetailss.id_order, status=1)">XÁC NHẬN</button>
                        <button v-if="OrderDetailss.status==0||OrderDetailss.status==1" @click="UpStatusOrder(OrderDetailss.id_order, status=3)">HỦY ĐƠN</button>
                        <button v-if="OrderDetailss.status==1"  @click="UpStatusOrder(OrderDetailss.id_order, status=2)">ĐÃ GIAO</button>
                        <p class="text_statusOrder" v-if="OrderDetailss.status==2">CHƯA CÓ ĐÁNH GIÁ</p>
                        <button v-if="OrderDetailss.status==4" @click="$store.state.feedback = false,GetIdOrder()">PHẢN HỒI ĐÁNH GIÁ</button>
                        <p class="text_statusOrder" v-if="OrderDetailss.status==5">ĐÃ PHẢN HỒI </p>
                        <button v-if="OrderDetailss.status==3" @click="UpStatusOrder(OrderDetailss.id_order, status=0)">KHÔI PHỤC</button>
                    </td>
                    <td colspan="2">
                        <div class="shipmentdetails">
                        <span>Thông tin nhận hàng: </span>
                        {{OrderDetailss.surname}} {{OrderDetailss.name}} - {{OrderDetailss.address}}
                         - {{OrderDetailss.wards}} - {{OrderDetailss.district}} - {{OrderDetailss.city_province}}
                        </div>
                        <div class="shipmentdetails">
                            <span>Số điện thoại(+84): </span>{{OrderDetailss.phone_number}}
                        </div>
                        </td>
                    <td class="text-right "><div>Tổng Tiền:</div><span class="text-danger"> {{TotalMoney|MoneyFormat}}</span></td>
                </tr>
            </table>
        </div>
    </div>
</div>    
</template>

<script>
import Feedback from './feedback.vue'
import BaseRequest from '@/BaseRequest'
import {mapState} from 'vuex'
import IconLoading from '@/components/font_end/content/IconLoading.vue'
export default {
    components:{
        IconLoading,
        Feedback
    },
    data(){
        return{
            active:0,
            Orders:{},
            OrderDetailss:0,
            ProductDetails:{},
            Loading:false,
            TotalMoney:0,
            IdOrder:0
        }
    },
    created(){
        BaseRequest.GetAdmin('/admin-get-order')
        .then((response)=>{
            this.Orders = response.data
        })
    },
    computed:{
        ...mapState(['UrlImage'])
    },
    methods:{
        OrderDetails:function(order){
            this.OrderDetailss = order
        },
        UpStatusOrder:function(id, status){
            if(status==0){
                if(confirm('Bạn có muốn khôi phục đơn hàng này')){
                    this.Loading=true
                    BaseRequest.PostAdmin('/admin-up-status/'+id+'/'+status)
                    .then((response)=>{
                        this.Orders = response.data
                        this.OrderDetailss=0
                    })
                } 
            }
            else{
                this.Loading=true
                BaseRequest.PostAdmin('/admin-up-status/'+id+'/'+status)
                .then((response)=>{
                    this.Orders = response.data
                    this.OrderDetailss=0
                })
            }
        },
        GetIdOrder(){
            this.IdOrder = this.OrderDetailss.id_order
        },
        SetOrder(order){
            this.OrderDetailss.status = order.status
        }
    },
    watch:{
        OrderDetailss:function(){
            this.Loading=true
            BaseRequest.GetAdmin('/admin-get-orderdetails/'+this.OrderDetailss.id_order)
            .then((response)=>{
                this.ProductDetails = response.data
                this.Loading=false
            })
            BaseRequest.GetAdmin('/admin-get-order')
            .then((response)=>{
                this.Orders = response.data
            })
        },
        ProductDetails:function(){
            this.TotalMoney=0
            for(var i = 0; i<this.ProductDetails.length; i++){
                this.TotalMoney += Number(this.ProductDetails[i].totalmoneys)
            }
        }
    },
    filters:{
        Status:function(types){
            if(types == 0){
                return(types = 'ĐANG CHỜ XỬ LÝ')
            }
            if(types == 1){
                return(types = 'ĐANG GiAO')
            }
            if(types == 2){
                return(types = 'ĐÃ GIAO')
            }
            if(types == 3){
                return(types = 'ĐÃ HỦY')
            }
            if(types == 4){
                return(types = 'ĐÃ GIAO')
            }
            if(types == 5){
                return(types = 'ĐÃ GIAO')
            }
        },
        MoneyFormat:function(money){
            return (new Intl.NumberFormat('de-DE').format(money)+' VND');
        },
        TypeProduct:function(types){
            if(types == 0){
                return(types = 'Đồng hồ nam')
            }
            else{
                return(types = 'Đồng hồ nữ')
            }
        },
    }
    
}
</script>

<style scoped>
table{
    width: 100%;
}
th,td{
    padding: 16px;
}
td>button{
    width: 100px;
    padding: 6px;
    background: rgb(248, 238, 152);
    font-size: 14px;
    border: none;
    margin: 4px 4px;
}
.tr_hover:hover{
    background: rgb(245, 244, 244);
    cursor: pointer;
}
.product>td>img{
    max-width: 60px;
}
.product>td>p{
    margin:0;
}
.product>td{
    border: none;
}
.body{
    color:rgb(117, 116, 116);
    background: rgb(236, 234, 234);
    padding-bottom:20px ;
}
.title{
    width: 100%;
    height: 100px;
    line-height: 100px;
    font-size: 20px;
    text-transform: uppercase;
    text-align: center;
}
.btn_order{
    width: 70%;
    margin: auto;
}
.btn_order>button{
    width: 25%;
    padding: 20px;
    background: white;
    transition: 0.4s;
    margin-bottom: 50px;
    border: none;
     color:rgb(117, 116, 116);
}
.btn_order>button:hover{
    background: rgb(253, 253, 183);
}
.btn_status{
    background: rgb(253, 253, 183) !important;
}
.status{
    background: white;
    width: 80%;
    margin: auto;
    max-height: 400px;
    overflow: auto;
}
.order-details{
    margin: 30px 0px ;
}
.table-details{
    width: 80%;
    background: white;
    margin: auto;
}
.table-details>table{
    color:rgb(117, 116, 116);
}
.shipmentdetails{
    text-transform: capitalize;
}
.shipmentdetails>span{
    color: black;
}
.statusOrder{
    text-align: center;
    color: rgb(255, 40, 40);
    font-weight: bold;
}
.text_statusOrder{
    font-size: 13px;
    width: 65px;
    font-weight: 600;
    color: rgb(255, 174, 0);
}
.Have_Review{
    background: rgb(185, 185, 185);
}
.Have_Review:hover{
    background: rgb(185, 185, 185);
}
.no-answer>div{
    display: inline-block;
}
#no-answer{
    width: 26px;
    height: 16px;
    background-color: rgb(117, 116, 116);
    margin-right: 5px;
}
.no-answer{
    margin:6px;   
}
</style>