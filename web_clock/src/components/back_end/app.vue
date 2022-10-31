<template>
  <div >
    <Menu/>
    <Contents/>
    <Footer/>
  </div>
</template>

<script>
import Menu from './Layouts/Menus.vue'
import Contents from './Layouts/Contents.vue'
import Footer from './Layouts/footer.vue'
import BaseRequest from '@/BaseRequest'
export default {
  components: {
    Menu,
    Contents,
    Footer
  },
  data(){
    return{
    }
  },
  created() {
      BaseRequest.GetAdmin('/admin-information')
      .then(()=> { 
      })
      .catch(() => {
        window.localStorage.removeItem('admin')
        this.$router.push({name:'login_admin'})
      })
  },
}
</script>

<style>

</style>
