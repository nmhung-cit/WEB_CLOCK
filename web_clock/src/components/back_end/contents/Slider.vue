<template>
<div class="body">
    <IconLoading v-if="Loading"></IconLoading>
    <div class="title">
        <p>Quản lý slide</p>
    </div>
    <div class="order-details">
        <div class="table-details" >
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>HÌNH ẢNH</th>
                    <th>XÓA</th>
                </tr>
                <tr v-for="image in ImageSlide" :key="image.id_slide">
                    <td>{{image.id_slide}}</td>
                    <td><img :src="UrlImageSlide+image.image" alt=""></td>
                    <td @click="DeleteImageSlide(image)"><i class="far fa-trash-alt"></i></td>
                </tr>               
            </table>
        </div>
        <div class="add_image">
            <label for="">THÊM ẢNH</label>
            <div @click="ChooseImage" class="btn-addimage">
                <i v-if="ViewsImage==null" class="far fa-plus-square fa-2x"></i>
                <img v-if="ViewsImage!==null" :src="ViewsImage" alt="">
            </div>
            <input @change="GetImage" ref="chossemage" type="file" style="display:none">
            <br><button :disabled="ViewsImage==null" @click="UpImageSlide">CẬP NHẬT</button>
        </div>
    </div>
</div>    
</template>

<script>
import BaseRequest from '@/BaseRequest'
import {mapState} from 'vuex'
import IconLoading from '@/components/font_end/content/IconLoading.vue'
export default {
    components:{
        IconLoading,
    },
    data(){
        return{
            Image:'',
            ViewsImage:null,
            ImageSlide:{},
            Loading:false,
        }
    },
    created(){
        BaseRequest.GetAdmin('/get-slide')
        .then((response)=>{
            this.ImageSlide = response.data
        })
    },
    computed:{
        ...mapState(['UrlImageSlide'])
    },
    methods:{
        ChooseImage(){
            this.$refs.chossemage.click()
        },
        GetImage(e){
            this.Image = e.target.files[0]
            let image = new FileReader
            image.readAsDataURL(this.Image)
            image.onload = e => {
                this.ViewsImage = e.target.result
            }
        },
        UpImageSlide(){
            this.Loading =true
            const formdata = new FormData
            formdata.append('image',this.Image)
            BaseRequest.PostAdmin('/add-image-slide',formdata)
            .then((response)=>{
                this.ImageSlide = response.data
                this.ViewsImage=null
                this.Loading = false
            })
        },
        DeleteImageSlide(image){
            BaseRequest.PostAdmin('/delete-image-slide',image)
            .then((response)=>{
                this.ImageSlide = response.data
            })
        }
    },
    
}
</script>

<style scoped>
table{
    width: 100%;
    text-align: center;
}
th,td{
    padding: 16px;
}
td>img{
    width: 100px;
}
td>button{
    width: 100px;
    padding: 6px;
    background: rgb(248, 238, 152);
    font-size: 14px;
    border: none;
    margin: 4px 4px;
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
.fa-trash-alt:hover{
    color: red;
}
.fa-plus-square:hover{
    color: rgb(255, 187, 0);
}
.add_image{
    width: 80%;
    margin: auto;
    background: white;
    text-align: center;
}
.add_image>label{
    font-size: 18px;
    font-weight: 600;
    padding: 10px 20%;
}
.btn-addimage{
    padding: 10px 20%;
    display: inline-block;
}
.btn-addimage>img{
    width: 100px;
}
.add_image>button{
    padding: 10px;
    margin: 20px;
    border:none;
    background: rgb(255, 187, 0);
    color: white;
}
.add_image>button:hover{
    background:rgb(255, 192, 65);
}
</style>