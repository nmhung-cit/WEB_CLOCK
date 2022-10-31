<template>
  <div class="slide_container">
    <div ref="imgslide" class="slide_img">
      <img ref = "img" class="slide_img" v-for="img in ImgSlide" :key="img.id_slide" :src="UrlImageSlide+img.image" alt="Img Slide">
    </div>
    <div class="QuantityDot">
      <span v-for="dot in Quantityimg/SizeSlide" :key="dot" class="dot" :class="{'dot_active':TransformPX == dot*SizeSlide-SizeSlide}" @click="CurrentSlide(dot*SizeSlide-SizeSlide),DeleteTime()"></span>
    </div>
    <div class="next" @click="PlushSlide(SizeSlide),DeleteTime()" ><i class="fas fa-chevron-circle-right fa-3x" ></i></div>
    <div class="prev" @click="PlushSlide(-SizeSlide),DeleteTime()" ><i class="fas fa-chevron-circle-left fa-3x" ></i></div>
  </div>
</template>

<script>
import {mapState} from 'vuex'
import BaseRequest from '@/BaseRequest'
export default {
  data(){
    return{
      ImgSlide:{},
      Quantityimg:0,
      Click:0,
      SizeSlide:1,
      TransformPX:0,
    }
  },
 created(){
    BaseRequest.get('/user-get-slide')
    .then((response)=>{
      this.ImgSlide = response.data
      this.$nextTick(()=>{
        this.SizeSlide = this.$refs.imgslide.clientWidth
      this.IndexSlide()
      })
    })
  },
  computed:{
      ...mapState(['UrlImageSlide']),
  },
  methods:{
    IndexSlide(){
      this.Quantityimg = this.$refs.img.length * this.SizeSlide;
    },
    CurrentSlide(n){
      this.ShowSlider(this.TransformPX = n)
    },
    PlushSlide:function(n){
      this.ShowSlider(this.TransformPX += n)
    },
    ShowSlider(n){
      if(n > this.Quantityimg - this.SizeSlide){
        this.TransformPX = 0
      }
      if(n < 0){
        this.TransformPX = this.Quantityimg - this.SizeSlide
      }
      
      this.$refs.imgslide.style.transform = 'translate3d(-'+ 100*(this.TransformPX/this.SizeSlide) +'%,0px,0px )'
    
    },
    TimeClick:function(){
      this.time = setInterval(() => {
        if(this.Click == 0){
        this.PlushSlide(this.SizeSlide)
        }
      }, 6000);
    },
    DeleteTime:function(){
      clearTimeout(this.settime)
      this.Click = 1;
      this.settime = setTimeout(() => {
          if(this.Click == 1)
          {
             this.Click = 0
          }
          }, 10000);
    },
  },
  mounted(){
    this.TimeClick()
    // window.addEventListener('resize', ()=>{
    //   if(this.TransformPX != 0){
    //     let x = this.$refs.imgslide.clientWidth
    //     this.TransformPX = this.TransformPX - this.SizeSlide + x
    //     console.log(x)
    //     this.$refs.imgslide.style.transform = 'translate3d(-'+this.TransformPX+'px,0px,0px )'
    //     }
    //     this.SizeSlide = this.$refs.imgslide.clientWidth
    //     console.log(this.SizeSlide)
    // })
  },
  beforeDestroy(){
    clearInterval(this.time)
    clearTimeout(this.settime)
  },
}
</script>
<style scoped src = "@/assets/styles/frontend/Slide.css">

</style>