<template>
    <div class="add_product " v-bind:class="{set_left: load}" >
        <p>Thêm sản phẩm</p>
        <p class="close" @click="$store.state.addproduct = true"><i class="fas fa-times fa-2x"></i></p>
        <div class="addproduct">
            <div class="from_addproduct">
                <div class="form_left from">
                    <div :class="{'error':messages}">{{messages}}</div>

                    <input v-model="product.name" type="text" name="name" placeholder="Tên sản phẩm">
                    <textarea v-model="product.description" type='text' name="description" id="" cols="50" rows="6" placeholder="Mô tả sản phẩm"></textarea>
                    <input style="text-transform:capitalize;" v-model="product.trademark" type="text" name="trademark" placeholder="Thương hiệu">
                    <select name="type_product" v-model="product.type_product">
                        <option disabled value="">Loại đồng hồ</option>
                        <option value="0" >Đồng hồ nam</option>
                        <option value="1" >Đồng hồ nữ</option>
                    </select>
                    <input class="price" v-model="product.price" type="number" placeholder="Giá sản phẩm: VND" >
                    <input ref="image" type="file" style="display:none" @change="uploadimage" >
                </div>
                <div class="form_right from">
                    <div class="picture">
                    <img v-if="PlaceholderImage"  src="@/assets/Placeholder_Image.jpg" style="max-width:300px;max-height:300px">
                    <img v-if="viewImage"  :src="viewImage" style="max-width:300px;max-height:300px">
                    </div>
                    <br><button class="image" @click="chooseimage">Chọn hình ảnh</button>
                </div>
            </div>
            <button @click="addproduct" class="btn_add" :disabled="loading" >
                <span :class="{'spinner-border spinner-border-sm':loading}"></span>{{status}}
            </button> 
        </div>
    </div>
</template>

<script>
import {mapGetters,mapState} from 'vuex'
import BaseRequest from '@/BaseRequest'
export default {
    data(){
        return{
            product:{
                name:'',
                description:'',
                trademark:'',
                price:'',
                type_product:'',
            },
            addImage:'',
            messages:'',
            status:'Thêm sản phẩm',
            loading:false,
            viewImage:'',
            PlaceholderImage:true
        }
    },
    computed:{
        ...mapGetters(['load']),
        ...mapState(['addproducts']),
    },
    methods:{
        uploadimage(even){
            this.PlaceholderImage = false
            let reader = new FileReader();
            this.addImage = even.target.files[0]
            reader.readAsDataURL(this.addImage);
            reader.onload = even =>{
                this.viewImage = even.target.result
                console.log(even)
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
            formdata.append('name',this.product.name)
            formdata.append('description',this.product.description)
            formdata.append('trademark',this.product.trademark)
            formdata.append('price',this.product.price)
            formdata.append('type_product',this.product.type_product)

            BaseRequest.PostAdmin('/add-product',formdata)
            .then((respose) =>{  
                this.$store.state.addproducts = respose.data
                this.$store.state.addproducts.forEach(product => {
                    product.checked = false
                });

                this.messages='Thêm sản phẩm thành công'
                this.product.name=''
                this.product.description=''
                this.product.trademark=''
                this.product.price=''
                this.product.type_product=''
                this.addImage=''
                this.viewImage=''
                this.PlaceholderImage=true

                this.loading = false
                this.status='Thêm sản phẩm'
                // window.location.reload()
            })
            .catch(error =>{
               this.messages = error.response.data.message
               this.loading = false
               this.status='Thêm sản phẩm'
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
    width: 800px;
    margin: auto;
    background: rgb(94, 109, 112);
    border-radius:20px;
    box-shadow: 0 0 10px rgb(252, 252, 252);
    overflow: hidden;
}
.from_addproduct{
    width: 800px;
    margin: auto;
    display: flex;
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
.from>select, .from>input, .from>textarea{
    width: 300px;
    padding: 5px ;
    margin: 10px 0px 10px 0px;
    border: none;
    outline: none;
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
.image:hover, .btn_add:hover{
    background: rgb(252, 250, 250);
}.btn_add{
    margin: 0px 150px 20px 150px;
    width: 500px;
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
}
</style>