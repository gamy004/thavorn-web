<template>
    <div v-if="show" class="full-screen">
        <div class="flex-popup" v-text="message"></div>
        <button @click="closePop">Done</button>
    </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'popup',
  components:{

  },
  data() {
    return {
        show: 0,
        message: "Don't have value"
    }
  },
  methods: {
      setShowPop(val, message) {
          this.message = message
          this.show = val
      },
      closePop() {
          if (this.message === 'ERROR') {
              this.show = 0
          }
          else if (this.show) {
              location.reload()
          }
      }
  },
  watch: {

  },


});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.full-screen{
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0,0.3);
    z-index: 3;
}
.flex-popup{
    display: flex;
    width: 35%;
    min-width: 300px;
    max-width: 500px;
    padding: 30px 15px;
    border: 1px solid #ffbac0;
    border-radius: 8px;
    justify-content: center;
    background-color: #ffb1b8;
    color: #721c24;
    font-size: 26px;
}
</style>
