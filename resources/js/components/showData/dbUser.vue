<template>
  <div>
      <div class="tap-bar min-width-1440" @click="updateshow('showUserData')">ข้อมูลลูกค้า</div>
      <div v-if="showUserData">
          <show-user-data class="min-width-1440" />
      </div>
  </div>
</template>

<script>
import Vue from 'vue';
import showUserData from './showUserData'
import showPawnData from './showPawnData'

export default Vue.extend({
  name: 'db',
  components:{
    showUserData,
  },
  data() {
    return {
        showUserData: 1,
    }
  },
  methods: {
      updateshow(type) {
          if (type === 'showUserData') {
            this.showUserData = !this.showUserData
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
