<template>
<div>
    <ChangePassword/>
    <IconLoading v-if="IconLoading"></IconLoading>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-6 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Thông tin nhận hàng</h4>
                </div>
                
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
                        <input type="text" class="form-control" v-model="ShipmentDetails.address"></div>
                </div>
                <div class="mt-5 text-center"><button @click="UpShipmentDetail" class="btn btn-primary profile-button" type="button">Lưu thông tin</button></div>
            </div>
        </div>
         <div class="col-md-6">
            <div class="">
                <div class="d-flex flex-column align-items-center text-center">
                    <input ref="image" type="file" accept="image/*" style="display:none" @change="UpdateImage">
                    <span @click="ChooseImage" class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Hình ảnh</span>
                    
                    <img v-if="User.image=='null'&& PlaceholderImage==false" class="image_radius mt-3" src="@/assets/user.png">
                    <img v-if="PlaceholderImage" class="image_radius mt-3" :src="ViewImage">
                    <img v-if="User.image!=='null'&& PlaceholderImage==false" class="image_radius mt-3" :src="url+User.image">
                    <span class="font-weight-bold" ref="name" ></span>
                </div><br>
                <div class="col-md-12">
                    <label class="labels">Họ và Tên:</label>
                    <input type="text" class="form-control" v-model="User.name" >
                    </div>
                <div class="col-md-12">
                    <label class="labels">Tên Tài khoản:</label>
                    <input type="text" class="form-control" v-model="User.username" disabled>
                </div>
                <div class="col-md-12">
                    <label class="labels">Địa chỉ Mail:</label>
                    <input type="email" class="form-control" v-model="User.email" >
                </div><br>
                <div class="col-md-12">
                    <input @click="$store.state.changepassword = false" type="button" class="form-control btn_password" value="Thay đổi mật khẩu" >
                </div> <br>
                 <div class="mt-5 text-center"><button @click="UpdateUser" class="btn btn-primary profile-button" type="button">Lưu thông tin</button></div>             
            </div>
        </div>
    </div>
</div>
</div>
</template>

<script>
import ChangePassword from './ChangePassword.vue'
import IconLoading from './IconLoading.vue'
import BaseRequest from '@/BaseRequest'
import {mapState,mapGetters} from 'vuex'
import VietNam from '@/DiagioiVietNam'
export default {
    components:{
        ChangePassword,
        IconLoading
    },
    data(){
        return{
            PlaceholderImage:false,
            ViewImage:'',
            AddImage:'',
            IconLoading:false,
            UserInformation:{},
            Address:VietNam,
            City_Province:'',
            Districts:'',
            Wards:'',
            Showaddress:true,
            ShipmentDetails:{
            }
        }
    },
    created(){
        if(this.User == false||this.User == true){
            this.$router.push({name:'login'})
        }
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
    },
    computed:{
        ...mapState(['User']),
        ...mapGetters(['url'])
    },
    methods:{
        ChooseImage(){
            this.$refs.image.click();
        },
        UpdateImage(even){
            this.PlaceholderImage = true
            let reader = new FileReader
            this.AddImage = even.target.files[0]
            reader.readAsDataURL(this.AddImage)
            reader.onload = even=>{
                this.ViewImage = even.target.result
            }
            
        },
        UpdateUser(){
            this.IconLoading=true

            const formdata = new FormData
            formdata.append('image',this.AddImage)
            formdata.append('name',this.User.name)
            formdata.append('email',this.User.email)
            BaseRequest.post('/updateuser',formdata)
            .then((e)=>{
                this.$store.state.User = e.data
                this.IconLoading = false
                alert('Cập nhật thành công')
            })
            .catch(()=>{
                this.IconLoading = false
                alert('Có lỗi xảy ra vui lòng kiểm tra lại')
            })
        },
        UpShipmentDetail(){
            this.IconLoading = true
            this.ShipmentDetails.id_user = this.User.id
            BaseRequest.post('/up-shipment-details',this.ShipmentDetails)
            .then((response)=>{
                this.ShipmentDetails = response.data
                this.IconLoading = false
                alert('Cập nhật thành công')
            })
            .catch(()=>{
                alert('Có lỗi xảy ra vui lòng kiểm tra lại')
                this.IconLoading = false
            })
        },
        SetShipmentDetail(){
            this.ShipmentDetails.city_province = this.City_Province.Name
            this.ShipmentDetails.district = this.Districts.Name
            this.ShipmentDetails.wards = this.Wards.Name
        }
    },
    mounted(){
        this.$refs.name.innerHTML=this.User.name   
    },
    watch:{
        User:function(){
            this.$refs.name.innerHTML=this.User.name
        }
    },
}
</script>

<style scoped>
input[type="number"]::-webkit-inner-spin-button {
    display: none;
}
.note{
    display: initial;
    position: relative;
}
.note:hover #obligatory{
    display: block;
}
#star:hover{
    color: red;
}
#obligatory{
    width: 60px;
    color: white;
    background: rgb(54, 54, 54);
    border-radius: 4px;
    position: absolute;
    text-align: center;
    top: -12px;
    left: 6px;
    display: none;
}
.form-control:focus {
    box-shadow: none;
    border-color: #ffe46e
}
.image_radius{
  width: 140px;
  height: 140px;
  border-radius:50% ;
}
.profile-button {
    background: rgb(248, 215, 68);
    box-shadow: none;
    border: none
}
.btn_password:hover{
    background:#f5cf29 ;
    color: white;
}
.profile-button:hover {
    background: #f5cf29
}

.profile-button:focus {
    background: #f5cf29;
    box-shadow: none
}
.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #f5cf29;
    color: #fff;
    cursor: pointer;
    border: solid 1px #f5cf29;
}
</style>