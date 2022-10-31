<template>
<div class="products_management">
    <AddProduct/>
    <ProductDetails :Setproductdetails ="productdetails"></ProductDetails>
    <Insurances :SetInsurances ="insurances"></Insurances>
    <ImageProduct :SetImage ="idimage"></ImageProduct>
    <div class="title">
        <p>Quản lý sản phẩm </p>
    </div>
    <div class="table_product">
        <button type="button" class="btn btn-light" style="color:rgb(117, 116, 116);" @click="$store.state.addproduct = false">Thêm sản phẩm</button>

        <div class="ip_btn_search">
            <input class="ip_search" type="text" placeholder="Search">
            <button class="btn-search" ><i class="fas fa-search"></i></button> 
        </div>
        <div class="table" >
            <hr>
            <table >
                <tr>
                    <th>ID</th>
                    <th>TÊN SẢN PHẨM</th>
                    <th>LOẠI SẢN PHẨM</th>
                    <th>ẢNH</th>
                    <th>TÌNH TRẠNG</th>
                    <th>GIÁ</th>
                    <th><i class="fas fa-check"></i></th>
                 
                </tr>
                <tr v-for="(product) in products" :key="product.id" @click="getproduct(product)" class="row_table">
                    <td >{{product.id}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.type_product|TypeProduct}}</td>
                    <td><img :src="$store.state.UrlImage+product.image" style="max-width:80px;max-height:40px" ></td>
                     <td>{{product.status|StatusProduct}}</td>
                    <td>{{product.price|MoneyFormat}}</td>
                    <td><input type="checkbox" v-model="product.checked" ></td>
                </tr>
            </table>          
            <hr>  
        </div>
        <div class="button_check">
            <input type="checkbox" v-model="checkedAll">   
            <label for="inlineRadio1">Chọn tất cả</label>         
            <button @click="deleteCheck()" type="button" class="btn btn-dark btn-sm">Xóa &#10006;</button>
        </div>
    </div>
    <div class="product_information">
        <div v-if="ShowInformation" class="InforProduct">
            <h3>THÔNG TIN SẢN PHẨM</h3>
            <div class="flex_product">
                <div class="flex_left">
                    <table class="iftable">
                        <tr>
                            <td>ID:</td>
                            <td >{{setproduct.id}}</td>
                        </tr>
                        <tr>
                            <td>Tên sản phẩm:</td>
                            <td><input type="text" v-model="setproduct.name" ></td>
                        </tr>
                        <tr>
                            <td>Mô tả:</td>
                            <td><textarea name="" id="" cols="40" rows="10" v-model="setproduct.description" ></textarea></td>
                        </tr>
                        <tr>
                            <td>Loại đồng hồ:</td>
                            <td><select  name="type_product" v-model="setproduct.type_product">
                                    <option :value="setproduct.type_product" >{{setproduct.type_product|TypeProduct}}</option>
                                    <option v-if="setproduct.type_product==1" value="0" >Đồng hồ nam</option>
                                    <option v-if="setproduct.type_product==0" value="1" >Đồng hồ nữ</option>
                                </select>                                
                            </td>
                        </tr>                        
                        <tr>
                            <td>Thương hiệu:</td>
                            <td><input style="text-transform:capitalize;" type="text" v-model="setproduct.trademark" ></td>
                        </tr>
                        <tr>
                            <td>Tình trạng:</td>
                            <td><select  name="status_product" v-model="setproduct.status">
                                    <option :value="setproduct.status" >{{setproduct.status|StatusProduct}}</option>
                                    <option v-if="setproduct.status==1" value="0" >Còn hàng</option>
                                    <option v-if="setproduct.status==0" value="1" >Hết hàng</option>
                                </select>                                
                            </td>
                        </tr>
                        <tr>
                            <td>Giá (VND):</td>
                            <td><input type="number" v-model="setproduct.price" ></td>
                        </tr>                                                
                    </table>
                </div>
                <div class="flex_right">
                    <button @click="$store.state.imagesProduct = false,getImage()" class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Hình ảnh</button>
                    <div class="image">
                        <br><img v-if="addimage==null" @click="chooseimage" :src="$store.state.UrlImage+setproduct.image" alt="">
                        <br><img v-if="viewimage" @click="chooseimage" :src="viewimage" alt="">
                        <input @change="uploadimage" ref="image" type="file" style="display:none">
                        <table class="tablepromotion">
                            <tr>
                                <td><button @click="$store.state.productdetails = false,getproductdetails()" class="btn_product">Chi tiết sản phẩm</button></td>
                                <td><button @click="$store.state.insurances = false,getInsurance()" class="btn_product">Chính sánh bảo hành</button></td>
                            </tr>
                            <tr>
                                <th>Khuyến mãi(%)</th>
                                <th>Giá Khuyến mãi</th>
                            </tr>
                            <tr>
                                <td><input type="number" min="0" max="100"
                                 v-model="PercentPromotion" ></td>
                                <td><input type="text" disabled :value="setproduct.promotion_price|MoneyFormat"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="btn_information">
                <p :class="{'error':message}">{{message}}</p>
            <button @click="cancel">Hủy</button>
            <button @click="update" :disabled="loading">
                 <span :class="{'spinner-border spinner-border-sm':loading}"></span>{{status}}</button>
            </div>            
        </div>
        <div v-if="NotShowInformation" class="Placeholder">
            <h2>Chọn một sản phẩm để xem chi tiết</h2>
        </div>

    </div>
</div>
</template>

<script>
    import BaseRequest from '@/BaseRequest'
    import ProductDetails from './ChangeProductDetails.vue'
    import Insurances from './Insurances.vue'
    import AddProduct from "./Add_product.vue"
    import ImageProduct from "./ImageProduct.vue"
    // import EditProduct from "./Edit_product.vue"
    import {mapActions,mapState} from 'vuex'
    export default {
        components:{
            AddProduct,
            ProductDetails,
            Insurances,
            ImageProduct
            // EditProduct
        },
        data(){
            return{
                products:[
                ],
                setproduct:{ 
                },
                productdetails:{},
                insurances:{},
                idimage:'',
                checkedAll:false,
                ShowInformation:false,
                NotShowInformation:true,
                addimage:null,
                viewimage:'',
                message:'',
                status:'Cập nhật',
                PercentPromotion:0,
                loading:false,
            }
        },
        created(){
            BaseRequest.GetAdmin('/add-product')
            .then((response) =>{ 
                this.products=response.data
                this.products.forEach(product=>{
                     product.checked = false 
                });
            })
            .catch(() =>{
                this.$router.push({name:'login_admin'})
            })
        },
        computed:{ 
        ...mapState(['addproducts']),
        },
        methods:{
            ...mapActions(['loadAdd']),
            deleteCheck : function(){
                var x
                this.products.find((e)=>{
                    if(e.checked == true){
                        x=1
                    }
                })
                if(x==1){
                    if(confirm('Bạn có muốn xóa sản phẩm đã chọn?')){
                        let Products = this.products
                        BaseRequest.PostAdmin('/deletes',{Products})
                        .then(response =>{
                            this.$store.state.addproducts = response.data
                            this.checkedAll = false
                        })
                    }
                }
                else{
                    alert('Bạn chưa chọn sản phẩm nào')
                }
            },
            chooseimage(){
                this.$refs.image.click()
            },
            cancel(){
                this.ShowInformation = false
                this.NotShowInformation = true
                this.viewimage = ''
                this.addimage = null
                
            },
            uploadimage(e){
                console.log(e)
                this.addimage = e.target.files[0]
                let image = new FileReader
                image.readAsDataURL(this.addimage)
                image.onload = e =>{
                    this.viewimage = e.target.result
                }
            },
            getproduct:function(product){
                this.setproduct = product

                this.ShowInformation = true
                this.NotShowInformation = false
                this.viewimage = ''
                this.addimage = null                
            },
            update() {
                const formdata = new FormData
                this.status = 'loading...'
                this.loading = true  

                formdata.append('image',this.addimage)
                formdata.append('name',this.setproduct.name)
                formdata.append('type_product',this.setproduct.type_product)
                formdata.append('status',this.setproduct.status)
                formdata.append('price',this.setproduct.price)
                formdata.append('description',this.setproduct.description)
                formdata.append('trademark',this.setproduct.trademark)

                formdata.append('id_product',this.setproduct.id)
                formdata.append('price_promotion',this.setproduct.promotion_price)
                BaseRequest.PostAdmin('/update/'+this.setproduct.id,formdata)
                .then((response)=>{
                    this.$store.state.addproducts = response.data
                    this.message = 'cập nhật thành công'
                    this.status = 'Cập nhật'
                    this.loading = false
                    setTimeout(()=>{
                        this.message =null;
                    },2000)                      
                })
                .catch(()=>{
                    this.message = 'lỗi! Vui lòng Kiểm tra lại'
                    this.status = 'Cập nhật'
                    this.loading = false
                    setTimeout(()=>{
                        this.message =null;
                    },2000)                                           
                })
            },
            getproductdetails(){
                this.productdetails.id = this.setproduct.id
                this.productdetails.batery = this.setproduct.batery
                this.productdetails.material = this.setproduct.material
                this.productdetails.material_glass = this.setproduct.material_glass
                this.productdetails.glass_shape = this.setproduct.glass_shape
                this.productdetails.glass_size = this.setproduct.glass_size
                this.productdetails.waterproof_lever = this.setproduct.waterproof_lever
                this.productdetails.color = this.setproduct.color
                this.productdetails.origin = this.setproduct.origin
            },
            getInsurance(){
                this.insurances.id = this.setproduct.id
                this.insurances.content = this.setproduct.content
            },
            getImage(){
                this.idimage = this.setproduct.id
            }

        },
        filters:{
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
            StatusProduct:function(status){
                if(status == 0){
                    return(status = 'Còn hàng')
                }
                else{
                    return(status = 'Hết hàng')
                }
            }
        },
        watch:{
            checkedAll:function(){
                if(this.checkedAll==true){
                    this.products.forEach(product=>{
                        product.checked = true 
                    });
                }
                else{
                    this.products.forEach(product=>{
                        product.checked = false
                    });
                }
            },
            addproducts:function(){
                this.products = this.addproducts
                this.products.forEach(product=>{
                    product.checked = false
                });
            },
            setproduct:function(){
                if(this.setproduct.promotion_price==null||this.setproduct.promotion_price==0){
                    this.PercentPromotion = 0
                     this.setproduct.promotion_price = 0
                }
                else{
                this.PercentPromotion =100-(this.setproduct.promotion_price/this.setproduct.price)*100
                this.setproduct.promotion_price =(this.setproduct.price)-((this.PercentPromotion*this.setproduct.price)/100)
                }
            },
            PercentPromotion:function(){
                if(this.PercentPromotion==0){
                    this.setproduct.promotion_price = 0
                }else{
                this.setproduct.promotion_price =(this.setproduct.price)-((this.PercentPromotion*this.setproduct.price)/100)
                }
            }
        }
    }
</script>

<style scoped>

.products_management{
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
.table_product{
    width: 80%;
    margin: auto;
}
.ip_btn_search{
    float: right;
    margin-bottom: 10px;
}
.ip_btn_search>input{
    border:none;
    border-bottom: 1px solid rgb(117, 116, 116);
    color: rgb(117, 116, 116);
    background:rgb(236, 234, 234);
}
.ip_btn_search>input[type = text]{
    outline: none;
}

[placeholder]:focus::-webkit-input-placeholder {
    transition: text-indent 0.4s 0.4s ease;
    text-indent: -100%;
}

 .btn-search{
    height: 40px;
    width: 40px;
    border-radius: 50%;
    color: rgb(117, 116, 116);
    background: white;
    border: none;
    box-shadow:0 0 5px rgb(151, 150, 150) ;
    margin:0 50px 0 10px;
 }
.button_check{
    margin:10px 0 10px 0 ;
    padding-bottom: 20px;
    border-bottom:1px solid rgb(214, 213, 213);
}
.button_check>button{
    margin-left:10px;
    float: right;
}
.table{
    width: 100%;
    max-height: 600px;
    overflow: auto;
    margin: 0;
}
table {
  border-collapse: collapse;
  width: 100%;
  background: white;
  border-radius: 10px;
  overflow: hidden;
}
.row_table>td{
    height: 40px;
    line-height: 40px;
}
.row_table:hover{
    background: rgb(245, 244, 244);
}
.product_information{
    width: 80%;
    margin:auto;
    background: white;
    border-radius: 10px;
}
.InforProduct{
    margin:20px;
}
.InforProduct>h3{
    padding-top:10px ;
    text-align: center;
}
.flex_product{
    display: flex;
    margin:0 40px 40px 40px;
    color: black;
    border-radius: 10px; 
}
.flex_product>div{
    margin: 10px;
}
.flex_left{
    width: 60%;
}
.flex_left>table>tr>td{
    padding: 10px;
}
.iftable>tr>td>textarea, .iftable>tr>td>input, .iftable>tr>td>select{
    outline: none;
    width: 400px;
    border: none;
    background: rgb(249, 253, 215);
}
.btn_information, .Placeholder{
    text-align: center;
}
.btn_information>button{
    color: white;
    padding: 10px 50px 10px 50px;
    margin: 10px 40px 10px 40px;
    border: none;
    border-radius: 20px;
    background: rgb(136, 134, 134);
    transition: all 0.5s;
}
.btn_information>button:hover{
    background: rgb(107, 126, 23);
    color: rgb(197, 253, 124);
}
.flex_right{
    width: 40%;
    text-align: center
}
.add-experience{
    background:rgb(247, 247, 109);
}
.add-experience:hover{
    background:rgb(243, 243, 4);
}
.image{
    width: 80%;
    background: white;
    margin: auto;
}
.image>img{
    max-width: 80%;
    cursor: pointer;
    transition: all 0.5s;
}
.image>img:hover{
    box-shadow: 0 0 10px rgb(32, 32, 32);
}
.Placeholder>h2{
    padding: 20px;
}
.tablepromotion{
    width: 350px;
    margin: auto;
    margin-top:10px;
    color: rgb(177, 177, 0);
}
.tablepromotion>tr>td>input[type=text]{
    width: 160px;
}
.tablepromotion>tr>th{
    text-align: left;
}
.tablepromotion>tr>td{
    text-align: left;
}
.btn_product{
    padding: 3px;
    font-size: 14px;
    border: none;
    background: rgb(247, 247, 109);
    color: rgb(37, 41, 1);
    border-radius: 10px;
    margin-bottom: 20px;
}
.btn_product:hover{
    background:rgb(243, 243, 4);
}
.error{
  color:red;
  font-weight: bold;
  font-size: 16px;
  text-transform: uppercase;
}
</style>