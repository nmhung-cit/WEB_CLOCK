<template>
<div class="body">
    <IconLoading v-if="Loading"></IconLoading>
    <AddNews @SetNew="ReloadNew"></AddNews>
    <div class="title">
        <p>Quản lý tin tức</p>
    </div>
    <div class="order-details">
        <div class="btn_addnews">
            <button type="button" class="btn btn-light" style="color:rgb(117, 116, 116);" @click="$store.state.news = false">THÊM TIN TỨC</button>
        </div>
        <div class="table-details" >
            <table class="table">
            <tr>
                <th>ID</th>
                <th>TIÊU ĐỀ</th>
                <th>HÌNH ẢNH</th>
                <th>XÓA</th>
            </tr>
            
            <tr v-for="news in Newss" :key="news.id_news" @click="SetContentNews(news)" class="hoverNews">
                <td>{{news.id_news}}</td>
                <td class="title_news">{{news.title}}</td>
                <td><img :src="UrlImageNews+news.image" alt=""></td>
                <td><i @click="DeleteNews(news)" class="far fa-trash-alt"></i></td>
            </tr>
            </table>
        </div>
        <div v-if="ContentNews" class="showcontent">
            <div class="content">
                <h3>{{ContentNews.title}}</h3>
                <img :src="UrlImageNews+ContentNews.image" alt="">
                <div class="thiscontent">{{ContentNews.content}}</div>
            </div>
        </div>
    </div>
</div>    
</template>

<script>
import BaseRequest from '@/BaseRequest'
import {mapState} from 'vuex'
import IconLoading from '@/components/font_end/content/IconLoading.vue'
import AddNews from "./Add_news.vue"
export default {
    components:{
        IconLoading,
        AddNews
    },
    data(){
        return{
            Loading:false,
            Newss:{},
            ContentNews:false
        }
    },
    created(){
        BaseRequest.GetAdmin('/get-news')
        .then((response)=>{
            this.Newss = response.data
        })
    },
    computed:{
        ...mapState(['UrlImageNews'])
    },
    methods:{
        ReloadNew(news){
            this.Newss = news
        },
        DeleteNews(news){
            BaseRequest.PostAdmin('/delete-news',news)
            .then((response)=>{
                this.Newss = response.data
                this.ContentNews = false
            })
        },
        SetContentNews(news){
            this.ContentNews = news
        }
    },
    
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
td>img{
    width: 100px;
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
.hoverNews:hover{
    background: rgb(226, 226, 226);
}
.title_news{
    font-weight: 600;
}
.fa-trash-alt:hover{
    color: red;
}
.btn_addnews{
    width: 80%;
    margin: auto;
    padding-bottom: 20px;
}
.showcontent{
    width: 80%;
    margin: auto;
}
.content{
    width: 100%;
    background: white;
    color: black;
}
.content>h3{
    text-align: center;
    padding: 10px;
}
.content>img{
    width: 100%;
}
.thiscontent{
    padding: 20px;
}
</style>