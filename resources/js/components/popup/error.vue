<template>
    <div v-if="show" class="full-screen">
        <div class="flex-popup" >
            <div class="x-button mb-1" @click="closePop">x</div>
            <div class="flex-center" v-text="message"></div>
            <button class="flex-center btn btn-primary m-2 mt-4" @click="closePop">Done</button>
        </div>
        
        
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
    padding: 5px 15px 30px 15px;
    border: 1px solid #e9e9e9;
    border-radius: 8px;
    justify-content: center;
    background-color: #ffffff;
    color: #000;
    font-size: 26px;
    flex-flow: column;
}
.x-button{
    display: flex;
    justify-content: flex-end;
    font-size: 20px;
}
.flex-center{
    display: flex;
    justify-content: center;
}
</style>
