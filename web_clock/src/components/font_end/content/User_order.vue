<template>
<div>
    <Loading v-if="Orders===0"></Loading>
    <IconLoading v-if="Loading"></IconLoading>
    <Reviews :IdOrder="GetIdOrder" @ListOrder = ReviewsSetOrder ></Reviews>
    <div v-if="Orders!==0" class="user-order">
        <h2>ĐƠN HÀNG CỦA BẠN</h2>
        <div v-if="Orders.length==0" class="Messages">Bạn chưa Có đơn hàng Nào</div>
        <div v-if="Orders.length!==0" class = "wrapper">
            <div class="wrapper-status-order">
                <div class="status_order">
                    <button @click="active=1" :class="{'btn_order':active==1}">Tất cả </button>
                    <button @click="active=2" :class="{'btn_order':active==2}">Chờ xử lý </button>
                    <button @click="active=3" :class="{'btn_order':active==3}">Đang giao </button>
                    <button @click="active=4" :class="{'btn_order':active==4}">Đã Giao </button>
                    <button @click="active=5" :class="{'btn_order':active==5}">Đã Hủy </button>
                </div>
            </div>
            <div class="order" v-if="active==1">
                <table v-for="order in Orders" :key="order.id_order">
                    <tr>
                        <th colspan="1">
                            MÃ ĐƠN:{{order.id_order}}
                        </th>
                        <th>THỜI GIAN ĐẶT HÀNG: {{order.created_at}}</th>
                        <th class="text-right text-danger">
                            {{order.status|Status}}
                        </th>
                    </tr>
                    <tr v-for="oderdetails in OrderDetails" :key="order.id_order-0.5+oderdetails.id_orderdetails" >
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <img :src="UrlImage+oderdetails.image" alt="">
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <div class="content">
                                <p class="name-watch"> {{oderdetails.name}} </p>
                                <p class="type_watch"> Phân Loại: {{oderdetails.type_product|TypeProduct}} </p>
                                <p> x{{oderdetails.quantity}} - {{oderdetails.color}} </p>
                            </div>
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" class="text-right" >
                            {{oderdetails.totalmoneys|MoneyFormat}}
                        </td>
                    </tr>
                    <tr v-for="totalmoney in TotalMoney" :key="totalmoney.id">
                        <td v-if="totalmoney.id==order.id_order" >
                            <button @click="CancelOrder(order, status=3)" v-show="order.status==0">HỦY ĐƠN</button>
                            <p class="showtextReview" v-show="order.status==4||order.status==5" >ĐÃ ĐÁNH GIÁ</p>
                            <button v-show="order.status==2" @click="$store.state.reviews = false,GetOrder(order.id_order)">ĐÁNH GIÁ</button>
                            <button @click="Received(order, status=2)" v-show="order.status==1">ĐÃ NHẬN </button>
                        </td>
                        <td v-if="totalmoney.id==order.id_order">Ghi Chú: {{order.node}} </td>
                        <td v-if="totalmoney.id==order.id_order" class="text-right textPrice" colspan="2">Tổng số tiền:
                            <span style="color:red;background:none">{{totalmoney.Money|MoneyFormat}} </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="order" v-if="active==2">
                <div v-if="Control" class="not_order">
                    <h5 >CHƯA CÓ ĐƠN HÀNG NÀO</h5>
                </div>
                <table v-for="order in Orders" :key="order.id_order" v-show="order.status==0">
                    <tr>
                        <th colspan="1">
                            MÃ ĐƠN:{{order.id_order}}
                        </th>
                        <th>THỜI GIAN ĐẶT HÀNG: {{order.created_at}}</th>
                        <th class="text-right text-danger">
                            {{order.status|Status}}
                        </th>
                    </tr>
                    <tr v-for="oderdetails in OrderDetails" :key="order.id_order-0.5+oderdetails.id_orderdetails" >
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <img :src="UrlImage+oderdetails.image" alt="">
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <div class="content">
                                <p class="name-watch"> {{oderdetails.name}}</p>
                                <p class="type_watch"> Phân Loại: {{oderdetails.type_product|TypeProduct}} </p>
                                <p> x{{oderdetails.quantity}} - {{oderdetails.color}} </p>
                            </div>
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" class="text-right" >
                            {{oderdetails.totalmoneys|MoneyFormat}}
                        </td>
                    </tr>
                    <tr v-for="totalmoney in TotalMoney" :key="totalmoney.id">
                        <td v-if="totalmoney.id==order.id_order" >
                            <button @click="CancelOrder(order, status=3)" v-show="order.status==0">HỦY ĐƠN</button>
                        </td>
                        <td v-if="totalmoney.id==order.id_order">Ghi Chú: {{order.node}} </td>
                        <td v-if="totalmoney.id==order.id_order" class="text-right textPrice" colspan="2">Tổng số tiền:
                            <span style="color:red;background:none">{{totalmoney.Money|MoneyFormat}} </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="order" v-if="active==3">
                <div v-if="Delivery" class="not_order">
                    <h5 >CHƯA CÓ ĐƠN HÀNG NÀO</h5>
                </div>
                <table v-for="order in Orders" :key="order.id_order" v-show="order.status==1">
                    <tr>
                        <th colspan="1">
                            MÃ ĐƠN:{{order.id_order}}
                        </th>
                        <th>THỜI GIAN ĐẶT HÀNG: {{order.created_at}}</th>
                        <th class="text-right text-danger">
                            {{order.status|Status}}
                        </th>
                    </tr>
                    <tr v-for="oderdetails in OrderDetails" :key="order.id_order-0.5+oderdetails.id_orderdetails" >
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <img :src="UrlImage+oderdetails.image" alt="">
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <div class="content">
                                <p class="name-watch"> {{oderdetails.name}}</p>
                                <p class="type_watch"> Phân Loại: {{oderdetails.type_product|TypeProduct}} </p>
                                <p> x{{oderdetails.quantity}} - {{oderdetails.color}} </p>
                            </div>
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" class="text-right" >
                            {{oderdetails.totalmoneys|MoneyFormat}}
                        </td>
                    </tr>
                    <tr v-for="totalmoney in TotalMoney" :key="totalmoney.id">
                        <td v-if="totalmoney.id==order.id_order" >
                            <button @click="CancelOrder(order, status=3)" v-show="order.status==0">HỦY ĐƠN</button>
                            <button @click="Received(order, status=2)" v-show="order.status==1">ĐÃ NHẬN </button>
                        </td>
                        <td v-if="totalmoney.id==order.id_order">Ghi Chú: {{order.node}} </td>
                        <td v-if="totalmoney.id==order.id_order" class="text-right textPrice" colspan="2">Tổng số tiền:
                            <span style="color:red;background:none">{{totalmoney.Money|MoneyFormat}} </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="order" v-if="active==4">
                <div v-if="Delivered" class="not_order">
                    <h5 >CHƯA CÓ ĐƠN HÀNG NÀO</h5>
                </div>                
                <table v-for="order in Orders" :key="order.id_order" v-show="order.status==2||order.status==4||order.status==5">
                    <tr>
                        <th colspan="1">
                            MÃ ĐƠN:{{order.id_order}}
                        </th>
                        <th>THỜI GIAN ĐẶT HÀNG: {{order.created_at}}</th>
                        <th class="text-right text-danger">
                            {{order.status|Status}}
                        </th>
                    </tr>
                    <tr v-for="oderdetails in OrderDetails" :key="order.id_order-0.5+oderdetails.id_orderdetails" >
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <img :src="UrlImage+oderdetails.image" alt="">
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <div class="content">
                                <p class="name-watch"> {{oderdetails.name}}</p>
                                <p class="type_watch"> Phân Loại: {{oderdetails.type_product|TypeProduct}} </p>
                                <p> x{{oderdetails.quantity}} - {{oderdetails.color}} </p>
                            </div>
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" class="text-right" >
                            {{oderdetails.totalmoneys|MoneyFormat}}
                        </td>
                    </tr>
                    <tr v-for="totalmoney in TotalMoney" :key="totalmoney.id">
                        <td v-if="totalmoney.id==order.id_order" >
                            <button @click="CancelOrder(order, status=3)" v-show="order.status==0">HỦY ĐƠN </button>
                            <p class="showtextReview" v-show="order.status==4||order.status==5" >ĐÃ ĐÁNH GIÁ</p>
                            <button v-show="order.status==2" @click="$store.state.reviews = false,GetOrder(order.id_order)">ĐÁNH GIÁ</button>
                        </td>
                        <td v-if="totalmoney.id==order.id_order">Ghi Chú: {{order.node}} </td>
                        <td v-if="totalmoney.id==order.id_order" class="text-right textPrice" colspan="2">Tổng số tiền:
                            <span style="color:red;background:none">{{totalmoney.Money|MoneyFormat}} </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="order" v-if="active==5">
                <div v-if="Canceled" class="not_order">
                    <h5 >CHƯA CÓ ĐƠN HÀNG NÀO</h5>
                </div>                
                <table v-for="order in Orders" :key="order.id_order" v-show="order.status==3">
                    <tr>
                        <th colspan="1">
                            MÃ ĐƠN:{{order.id_order}}
                        </th>
                        <th>THỜI GIAN ĐẶT HÀNG: {{order.created_at}}</th>
                        <th class="text-right text-danger">
                            {{order.status|Status}}
                        </th>
                    </tr>
                    <tr v-for="oderdetails in OrderDetails" :key="order.id_order-0.5+oderdetails.id_orderdetails" >
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <img :src="UrlImage+oderdetails.image" alt="">
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" >
                            <div class="content">
                                <p class="name-watch"> {{oderdetails.name}} </p>
                                <p class="type_watch"> Phân Loại: {{oderdetails.type_product|TypeProduct}} </p>
                                <p> x{{oderdetails.quantity}} - {{oderdetails.color}} </p>
                            </div>
                        </td>
                        <td v-if="oderdetails.id_order == order.id_order" class="text-right" >
                            {{oderdetails.totalmoneys|MoneyFormat}}
                        </td>
                    </tr>
                    <tr v-for="totalmoney in TotalMoney" :key="totalmoney.id">
                        <td v-if="totalmoney.id==order.id_order">
                            <button  @click="CancelOrder(order, status=3)" v-show="order.status==0">HỦY ĐƠN </button>
                        </td>
                        <td v-if="totalmoney.id==order.id_order">Ghi Chú: {{order.node}} </td>
                        <td v-if="totalmoney.id==order.id_order" class="text-right textPrice" colspan="2">Tổng số tiền:
                            <span style="color:red;background:none">{{totalmoney.Money|MoneyFormat}} </span>
                        </td>
                    </tr>
                </table>
            </div>   
        </div>     
    </div>
</div>
</template>

<script>
import BaseRequest from '@/BaseRequest'
import Loading from './Loading.vue'
import IconLoading from './IconLoading.vue'
import Reviews from './Reviews.vue'
import {mapState} from 'vuex'
export default {
    components:{
        Loading,
        IconLoading,
        Reviews
    },
    data(){
        return{
            active:1,
            Orders:0,
            Loading:false,
            OrderDetails:[],
            TotalMoney:[],
            GetIdOrder:0,
            Control:true,
            Delivery:true,
            Delivered:true,
            Canceled:true
        }
    },
    computed:{
        ...mapState(['User','UrlImage'])
    },
    created(){
        BaseRequest.get('/get-oder/'+this.User.id)
        .then((response)=>{
            this.Orders = response.data
            BaseRequest.get('/get-oder-dertails/'+this.User.id)
            .then((response)=>{
                this.OrderDetails = response.data                 
                for(var i = 0; i < this.Orders.length; i++){
                        this.TotalMoney.push({
                            id : this.Orders[i].id_order,
                        })
                }
                this.TotalMoney.forEach(order=>{
                    order.Money = 0
                    for(var a = 0; a < this.OrderDetails.length; a++){
                        if(this.OrderDetails[a].id_order==order.id){
                            order.Money += Number(this.OrderDetails[a].totalmoneys)
                        }
                    }
                })
            })
        })
    },
    methods:{
        CancelOrder:function(Order, status){
            if(confirm('Bạn Có Thật Sự Muốn Hủy Đơn Hàng Này')){
                this.Loading = true
                BaseRequest.post('/cancel-order/'+Order.id_order+'/'+Order.id_user+'/'+status)
                .then((response)=>{
                    this.Orders = response.data
                    this.Loading = false
                })
            }
        },
        Received:function(Order, status){
            if(confirm('Bạn Xác Nhận Đã Nhận Được Hàng Và Thanh Toán Cho Người Gửi')){
                this.Loading = true
                BaseRequest.post('/cancel-order/'+Order.id_order+'/'+Order.id_user+'/'+status)
                .then((response)=>{
                    this.Orders = response.data
                    this.Loading = false
                })
            }
        },
        GetOrder(Id){
            this.GetIdOrder=Id
        },
        ReviewsSetOrder(orders){
            this.Orders = orders
        }
    },
    watch:{
        Orders(){
            for(var i = 0; i<this.Orders.length;i++){
                if(this.Orders[i].status==0){
                    this.Control = false
                }
                if(this.Orders[i].status==1){
                    this.Delivery = false
                }
                if(this.Orders[i].status==2){
                    this.Delivered = false
                }
                if(this.Orders[i].status==4){
                    this.Delivered = false
                }
                if(this.Orders[i].status==5){
                    this.Delivered = false
                }
                if(this.Orders[i].status==3){
                    this.Canceled = false
                }
                
            }
        },
    },
    filters:{
        MoneyFormat:function(money){
            return (new Intl.NumberFormat('de-DE').format(money)+' VND');
        },
        TypeProduct:function(types){
            if(types == 0){
                return(types = 'ĐỒNG HỒ NAM')
            }
            else{
                return(types = 'ĐỒNG HỒ NAM')
            }
        }, 
        Status:function(types){
            if(types == 0){
                return(types = 'ĐANG XỬ LÝ')
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
    },
}
</script>

<style scoped src = "@/assets/styles/frontend/User_order.css">

</style>