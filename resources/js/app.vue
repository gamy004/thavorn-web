<template>
  <div>
    <navbar :logo="1" />
    <div class="col-12 p-0 flex-row">
      <menul class="w-cus  m-0 p-0"></menul>
      <router-view class="p-0 w-100 able-overflow"></router-view>
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
.flex-row{
  display: flex;
  flex-flow: row;
  justify-content: stretch;
}
.w-cus{
  min-width: 180px;
}
.able-overflow{
  height: calc(100vh - 50px);
  overflow-y: scroll;
}
::-webkit-scrollbar-track {
  border-radius: 3px;
  background-color: #d8d8d8;
}

::-webkit-scrollbar {
  width: 6px;
  height: 6px;
  background-color: #d8d8d8;
}

::-webkit-scrollbar-thumb {
  border-radius: 3px;
  background-color: #909090;
}

</style>
