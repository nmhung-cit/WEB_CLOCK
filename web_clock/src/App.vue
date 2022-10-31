<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>

export default {
  name: 'App',
  data(){
    return{
    }
  },
}
</script>

<style>

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
::-webkit-scrollbar {
  width: 10px;
}
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
}
::-webkit-scrollbar-thumb {
  background: rgb(252, 194, 36); 
}
::-webkit-scrollbar-thumb:hover {
  background: rgb(218, 160, 2); 
}


</style>
