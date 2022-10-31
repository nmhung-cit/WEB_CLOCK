<template>
  <div>
    <Loading v-if="User == false"></Loading>
    <div v-if="User !== false || User == true">
      <Header />
      <Menu />
      <Contents />
      <Footer />
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import Header from './layout/Header_web.vue'
import Menu from './layout/Menu.vue'
import Contents from './layout/Contents.vue'
import Footer from './layout/Footer_web.vue'
import Loading from './content/Loading.vue'

export default {
  components: {
    Header,
    Menu,
    Contents,
    Footer,
    Loading
  },
  data() {
    return {
    }
  },
  methods: {
    ...mapActions(['CheckUser']),
  },
  computed: {
    ...mapState(['User'])
  },
  mounted() {
    this.CheckUser();
  },
}
</script>

<style>
* {
  font-family: "Roboto", sans-serif;
}
</style>
