<template>
    <div class="add_product " v-bind:class="{set_left: newss}" >
        <p>Thêm tin tức</p>
        <p class="close" @click="$store.state.news = true"><i class="fas fa-times fa-2x"></i></p>
        <div class="addproduct">
            <p class="error">{{messages}}</p>
            <div class="from_addproduct"> 
                <div>
                    <div class="form_right from">
                        <div  class="picture">
                        <img  v-if="PlaceholderImage"  src="@/assets/Placeholder_Image.jpg" style="max-width:300px;max-height:300px">
                        <img  v-if="viewImage"  :src="viewImage" style="max-width:300px;max-height:300px">
                        </div>
                        <br><button class="image" @click="chooseimage">Chọn hình ảnh</button>
                        <input ref="image" type="file" style="display:none" @change="uploadimage" >
                    </div> 
                    
                </div>
                <div class="title_content">
                    <input type="text" v-model="Addnews.title" placeholder="Tiêu đề" style="width:400px; outline:none" >
                    <textarea v-model="Addnews.content" placeholder="Nội dung" id="" cols="70" rows="13" style="outline:none;margin-top:10px"></textarea>
                </div>
            </div>
            <div class="btn_add">
                <button @click="addproduct" :disabled="loading" >
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
    data(){
        return{
            Addnews:{
                title:'',
                content:''
            },
            addImage:'',
            messages:'',
            status:'Thêm tin tức',
            loading:false,
            viewImage:'',
            PlaceholderImage:true
        }
    },
    computed:{
        ...mapGetters(['newss']),
        ...mapState(['news']),
    },
    methods:{
        uploadimage(even){
            this.PlaceholderImage = false
            let reader = new FileReader();
            this.addImage = even.target.files[0]
            reader.readAsDataURL(this.addImage);
            reader.onload = even =>{
                this.viewImage = even.target.result
            }
        },
        chooseimage(){
            this.$refs.image.click()
        },
        addproduct(){
            this.loading=true
            this.status = 'Loading'

            const formdata = new FormData
            formdata.append('image',this.addImage)
            formdata.append('title',this.Addnews.title)
            formdata.append('content',this.Addnews.content)

            BaseRequest.PostAdmin('/add-news',formdata)
            .then((response) =>{  
                this.$emit('SetNew',response.data)

                this.messages='Thêm tin tức thành công'
                this.Addnews.title=''
                this.Addnews.content=''
                this.addImage=''
                this.viewImage=''
                this.PlaceholderImage=true

                this.loading = false
                this.status='Thêm tin tức'
                // window.location.reload()
            })
            .catch(error =>{
               this.messages = error.response.data.message
               this.loading = false
               this.status='Thêm tin tức'
            })
        }
    },
    
}
</script>

<style scoped>
.add_product{
    top: 0;
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0, 0.9);
    overflow: hidden;
    transition:  0.5s;
}
.set_left{
    height:0%;
}

.add_product>p{
    color: white;
    font-size: 20px;
    margin: 20px;
    text-align: center;
    text-transform: uppercase ;
}
.close{
    width: 30px;
    height: 30px;
    position: absolute;
    right: 30px;
    top: 30px;
}
.addproduct{
    width:  86%;
    margin: auto;
    background: rgb(94, 109, 112);
    border-radius:20px;
    box-shadow: 0 0 10px rgb(252, 252, 252);
    overflow: hidden;
}
.from_addproduct{
    display: flex;
    width: 80%;
    margin: auto;
}.from_addproduct>div{
    margin: 10px;
    padding: 20px;
}
.form_left{
    width: 450px;
}
.form_right{
    width: 350px;
}
.from>input:focus{
    box-shadow: 0 0 4px red;
}
.from>span{
    color: white;
}
.picture{
    width: 300px;
    height: 300px;
    line-height: 290px;
    background: white;
    border-radius: 10px;
    text-align: center;
    overflow: hidden;
}
.image{
    width: 300px;
    padding: 10px ;
    background: rgb(160, 224, 243);
    color: black;
    border-radius:10px ;
    border:none;
    transition: all 0.5s ease;
}
.btn_add{
    width: 50%;
    padding-bottom: 10px;
    margin: auto !important;
}
.image:hover, .btn_add>button:hover{
    background: rgb(252, 250, 250);
}.btn_add>button{
    width: 100%;
    padding: 10px 20px;
    border:none;
    border-radius:5px ;
    transition: all 0.5s ease;
    background: rgb(160, 224, 243);
}
.error{
  color: rgb(245, 211, 21);
  font-size: 13px;
  text-transform: uppercase;
  padding-left:20px ;
}
</style>