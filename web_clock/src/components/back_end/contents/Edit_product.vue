<template>
<div>
    <form @submit.prevent="addimage">
    <input type="file" @change="getimage">
    <button type="submit">gủi</button>
    </form>
</div>
</template>
<script>
const axios = require('axios');
export default {
    data(){
        return{
            image:''
        }
    },
    methods:{
        getimage(even){
            console.log(even.target.files[0])
            this.image = even.target.files[0]
        },
        addimage(){
            const formdata = new FormData
            formdata.set('image',this.image)
            axios.post('http://127.0.0.1:8000/api/demo',formdata)
        }
    }
}
</script>