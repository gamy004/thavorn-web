<template>
  <div>
    <div class="cus-flex flex-row p-3 hover-change-color max-w">
      <img class="mr-3 fill-white" :src="imgURL">
      <div v-if="msg" class="flex-center text-white">{{msg}}</div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import navbar from './nevbar.vue'
import { Stream } from 'stream';

export default Vue.extend({
  name: 'menuItem',
  components: {
    navbar
  },
  props: {
    msg: [String,Number],
    imgURL: String
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.color-cus{
  background-color: #2f353a
}
img{
  height: 1.8rem;
  width: auto;
}
.flex-center{
  align-items: center;
  display: flex;
}
.fill-white{
  filter: invert(0.8);
}
.hover-change-color:hover{
  background-color: #20a8d8;
  transition: background-color linear 100ms;
  .fill-white{
    filter: invert(1);
  }
}
.max-w{
  max-width: 240px;
  min-width: 129px;
}
</style>
