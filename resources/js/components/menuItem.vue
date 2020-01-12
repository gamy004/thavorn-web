<template>
  <div>
      <div v-if="msg">{{msg}}</div>
  </div>
</template>

<script>
import Vue from 'vue';
import navbar from './nevbar.vue'

export default Vue.extend({
  name: 'menuItem',
  components: {
    navbar
  },
  props: {
    msg: [String,Number],
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.color-cus{
        background-color: #2f353a
}
img{
  height: 30px;
  width: auto;
}
</style>
