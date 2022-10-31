<template>
    <div class="product_details " v-bind:class="{set_left: imagesProduct}" >
        <p>HÌNH ẢNH SẢN PHẨM </p>
        <p class="close" @click="$store.state.imagesProduct = true"><i class="fas fa-times fa-2x"></i></p>
        <div class="productdetails">
                <div class="form_left">
                    <div class="error">{{messages}}</div>
                    <div class="tables">
                    <table class="table">
                        <tr>
                            <th>XÓA </th>
                            <th>HÌNH ẢNH</th>
                            <th>MÔ TẢ</th>
                        </tr>
                        <tr v-for="image in images" :key="image.id" >
                            <td><i @click="DeleteImages(image)" class="far fa-trash-alt"></i></td>
                            <td><img :src="UrlImage+image.images" alt=""></td>
                            <td>{{image.descriptions}}</td>
                        </tr>                      
                    </table>
                    </div>
                    <div class="addimage">
                        <table class="table">
                            <tr>
                                <th colspan="2">Thêm Ảnh</th>
                                <th >Mô tả</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div @click="ChooseImage()" class="btn-addimage">
                                        <i v-if="viewimage==null" class="far fa-plus-square fa-2x"></i>
                                        <img v-if="viewimage"  :src="viewimage" alt="">
                                    </div>
                                </td>
                                <td>
                                    <input v-model="descriptions" type="text">
                                </td>
                            </tr>
                        </table>
                        <input @change="getimage" ref="image" type="file" style="display:none">
                    </div>
                    <div class="btn_update">
                    <button class="btn_add" @click="UpDateImage()" :disabled="loading" >
                        <span :class="{'spinner-border spinner-border-sm':loading}"></span>{{status}}
                    </button> 
                    </div>                   
                </div>
        </div>
    </div>
</template>

<script>
import {mapGetters,mapState} from 'vuex'
import BaseRequest from '@/BaseRequest'
export default {
    props:[
        'SetImage'
        ],
    data(){
        return{
            addimage:'',
            descriptions:'',
            viewimage:null,
            messages:'',
            status:'CẬP NHẬT',
            loading:false,
            images:{}
        }
    },
    computed:{
        ...mapState(['UrlImage']),
        ...mapGetters(['imagesProduct']),
    },
    methods:{
        ChooseImage(){
            this.$refs.image.click()
        },
        getimage(e){
            this.addimage = e.target.files[0]
            let image = new FileReader
            image.readAsDataURL(this.addimage)
            image.onload = e =>{
                this.viewimage = e.target.result
            }      
        },
        UpDateImage(){
            this.status='Loading...'
            this.loading=true
            const formdata = new FormData

            formdata.append('images',this.addimage)
            formdata.append('id_product',this.SetImage)
            formdata.append('descriptions',this.descriptions)

            BaseRequest.PostAdmin('/add-images',formdata)
            .then((response)=>{
                this.images = response.data
                this.status='CẬP NHẬT'
                this.loading=false
                this.viewimage = null,
                this.descriptions=''
            })
            .catch((error)=>{
                this.messages = error.response.data.message
                this.status='CẬP NHẬT'
                this.loading=false                
            })
        },
        DeleteImages:function(image){
            BaseRequest.PostAdmin('/delete-images',image)
            .then((response)=>{
                this.images = response.data
            })
        }

    },
    watch:{
        SetImage(){
        BaseRequest.GetAdmin('/get-images/'+this.SetImage)
        .then((response)=>{
            this.images = response.data
        })
        }
    }
}
</script>

<style scoped>
table{
    width: 100%;
    margin-top:20px;
}
td>img, .btn-addimage>img{
    width: 40px;
}
.btn-addimage:hover{
    cursor: pointer;
}
tr{
    text-align: center;
}
.fa-trash-alt:hover{
    color: red;
}
.tables{
    height: 300px;
    overflow: auto;
}
.addimage>table>tr>th{
    color: rgb(214, 193, 3);
}
.addimage>table>tr>td>input{
    width: 150px;
    background: rgb(248, 223, 140);
    height: 30px;
    border:none;
    outline: none;
}
.fa-plus-square:hover{
    color: rgb(214, 193, 3);
    cursor: pointer;
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