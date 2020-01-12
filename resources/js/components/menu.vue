<template>
  <div class="color-cus">
      <menu-item msg="asdasdsss" />
  </div>
</template>

<script>
import Vue from 'vue';
import navbar from './nevbar.vue'
import menuItem from './menuItem.vue'

export default Vue.extend({
  name: 'menul',
  components: {
    navbar,
    menuItem
  },
  props: {
    msg: String,
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
