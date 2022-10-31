<template>
 <div class="body">
     <Loading v-if="loading"></Loading>
     <div v-if="loading == false" class="title">
         <h4>TIN TỨC</h4>
     </div>
     <div  v-if="loading == false" class="flex_news">
         <div class="flext_left">
             <div class="category-menu">
                  <p>TIN MỚI NHẤT</p>
                  <div  class="show-all-news">
                    <div v-for="news in NewNews" :key="news.id_news" class="news-menu">
                        <div class="img-news">
                            <img :src="UrlImageNews+news.image" alt="">
                        </div>
                        <div class="title-news" @click="$router.push({name:'contentnews',params:{id_news:news.id_news}})">
                            {{news.title}}
                        </div>
                    </div>
                  </div>                                  
              </div>
         </div>
         <div class="flext_right">
            <div v-for="news in Newss" :key="news.id_news" class="news"
            @click="$router.push({name:'contentnews',params:{id_news:news.id_news}})">
                <div class="imageNews">
                    <img :src="UrlImageNews+news.image" alt="">
                </div>
                <div class="titleNews">{{news.title}}</div>
                <div class="content">
                    {{news.content}}
                </div>
            </div>
         </div>
     </div>
 </div>
</template>

<script>
import BaseRequest from '@/BaseRequest'
import {mapState} from 'vuex'
import Loading from './Loading.vue'
export default {
    components:{
        Loading
    },
    data(){
        return{
            Newss:{},
            NewNews:{},
            loading:true
        }
    },
    beforeCreate(){
        window.scrollTo(0,0)
        BaseRequest.get('/user-get-news')
        .then((response)=>{
            this.Newss = response.data
            this.loading = false
        })
        BaseRequest.get('/get-new-news')
        .then((response)=>{
            this.NewNews = response.data
        })
    },
    computed:{
        ...mapState(['UrlImageNews'])
    }
}
</script>

<style scoped src = "@/assets/styles/frontend/News_clock.css">

</style>