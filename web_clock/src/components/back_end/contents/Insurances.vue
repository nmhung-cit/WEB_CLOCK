<template>
    <div class="product_details " v-bind:class="{set_left: insurances}" >
        <p>CHÍNH SÁCH BẢO HÀNH</p>
        <p class="close" @click="$store.state.insurances = true"><i class="fas fa-times fa-2x"></i></p>
        <div class="productdetails">
            <div class="form_left">
                <div class="error">{{messages}}</div>
                <textarea v-model="SetInsurances.content" cols="40" rows="10"></textarea>
                <div class="btn_update">
                <button @click="UpdateInsurances()" class="btn_add" :disabled="loading" >
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
        SetInsurances:Object
    },
    data(){
        return{
            messages:'',
            status:'CẬP NHẬT',
            loading:false,
        }
    },
    computed:{
        ...mapGetters(['insurances']),
    },
    methods:{

        UpdateInsurances(){
            this.loading=true
            this.status = 'Loading...'
            BaseRequest.PostAdmin('/update-insurances',this.SetInsurances)
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
    text-align: center;
}
.form_left>textarea{
    margin-top: 20px;
    outline: none;
    background: rgb(247, 247, 151);
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
.error{
  color: red;
  font-size: 16px;
  padding-top: 10px;
  height: 20px;
  text-transform: uppercase;
}
</style>