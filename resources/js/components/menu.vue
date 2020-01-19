<template>
  <div class="color-cus">
    <menu-item v-for="item in menuOBJ" :imgURL="item.img" :msg="item.msg" :key="item.msg" />
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
  data() {
    return{
      menuOBJ: [
        {
          msg : "การจำนำ",
          img : "images/hand.svg"
        },
        {
          msg : "ต่ออายุดอกเบี้ย",
          img : "images/clock.svg"
        },
        {
          msg : "ไถ่ถอน",
          img : "images/switch.svg"
        },
      ]
    }
  }
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
