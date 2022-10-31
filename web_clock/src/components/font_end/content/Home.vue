<template>
    <div>
        <Slide/>
        <Content/>
    </div>    
</template>

<script>
import Slide from './content_home/Slide.vue'
import Content from './content_home/Content.vue'

export default {
    name: 'Home',
    components:{
        Slide,
        Content
    },
    created(){
        window.scrollTo(0,0)
    }
}
</script>

<style scoped>

</style>