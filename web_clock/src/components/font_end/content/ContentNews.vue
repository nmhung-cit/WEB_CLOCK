<template>
 <div class="body">
     <Loading v-if="loading"></Loading>
     <div v-if="loading == false" class="flex_news">
         <div class="flex_right">
             <div class="category-menu">
                  <p>TIN MỚI NHẤT</p>
                  <div  class="show-all-news">
                    <div v-for="news in NewNews" :key="news.id_news" class="news-menu" 
                    @click="$router.push({name:'contentnews',params:{id_news:news.id_news}}),idnews=news.id_news">
                        <div class="img-news">
                            <img :src="UrlImageNews+news.image" alt="">
                        </div>
                        <div class="title-news">
                            <router-link to="#">{{news.title}}</router-link>
                        </div>
                    </div>
                  </div>                                  
              </div>
         </div>
         <div class="flext_left">
             <div class="title">
             <p>TIN TỨC </p>
             <h3>{{Newss.title}}</h3>
             <p>{{Newss.created_at}}</p>
             </div>
             <div class="content_image">
                 <img :src="UrlImageNews+Newss.image" alt="">
             </div>
             <div class="content">
                 {{Newss.content}}
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
            idnews:this.$route.params.id_news,
            Newss:{},
            NewNews:{},
            loading:true
        }
    },
    created(){
        window.scrollTo(0,0)
        BaseRequest.get('/get-new-news')
        .then((response)=>{
            this.NewNews = response.data
        })
        BaseRequest.get('/get-new-details/'+this.idnews)
        .then((response)=>{
            this.Newss = response.data
            this.loading = false
        })
    },
    computed:{
        ...mapState(['UrlImageNews'])
    },
    watch:{
        idnews:function(){
        this.loading = true
        BaseRequest.get('/get-new-details/'+this.idnews)
        .then((response)=>{
            this.Newss = response.data
            this.loading = false
        })
        }
    }
}
</script>

<style scoped src = "@/assets/styles/frontend/ContentNew.css">

</style>