<template>
  <div>
    <navbar :logo="1" />
    <div class="col-12 p-0 flex-row">
      <menul class="col-2 max-width m-0 p-0"></menul>
      <router-view class="p-0 w-100 able-overflow main"></router-view>
    </div>
  </div>
</template>

<script>
import navbar from './components/nevbar.vue'
import menul from './components/menu.vue'

export default {
  name: 'app',
  components: {
    navbar,
    menul
  }
};
</script>

<style>
body{
  margin: 0;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  display: flex;
  flex-flow: column;
}

.w-cus{
  min-width: 180px;
}
.able-overflow{
  height: calc(100vh - 50px);
  overflow-y: scroll;
}
.max-width{
  max-width: 240px;
}
</style>
