<template>
  <div>
      <div class="tap-bar min-width-1440" @click="updateshow('showUserData')">ข้อมูลลูกค้า</div>
      <div v-if="showUserData">
          <show-user-data class="min-width-1440" />
      </div>
      <div class="tap-bar min-width-1440" @click="updateshow('showPawnData')">ข้อมูลการจำนำ</div>
      <div v-if="showPawnData">
          <show-pawn-data />
      </div>
  </div>
</template>

<script>
import Vue from 'vue';
import showUserData from './showData/showUserData'
import showPawnData from './showData/showPawnData'

export default Vue.extend({
  name: 'db',
  components:{
    showUserData,
    showPawnData
  },
  data() {
    return {
        showUserData: 0,
        showPawnData: 0
    }
  },
  methods: {
      updateshow(type) {
          if (type === 'showUserData') {
            this.showUserData = !this.showUserData
          }else if (type === 'showPawnData') {
            this.showPawnData = !this.showPawnData
          }
      }
  },
  watch: {

  },


});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.tap-bar {
    display: flex;
    justify-content: center;
    padding: 20px 0;
    background-color: #3490dc;
    color: white;
    border-bottom: 0.5px solid #237cc5;
    border-top: 0.5px solid #237cc5;
    font-size: 20px;
}
</style>
