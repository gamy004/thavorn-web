<template>
  <div>
    <section class="card">
      <h2>ข้อมูลส่วนตัวลูกค้า</h2>
      <information @emit:information="updateInformation" />
    </section>
    <section class="card">
      <h2>ข้อมูลทอง</h2>
      <goldForm @emit:gold="updateGold" />
    </section>
    <section class="card">
      <h2>ส่วนดอกเบี้ย</h2>
      <interest @emit:interest="updateInterest" />
      <saveSection v-if="showbutton ===1" @click:save="saveData" />
    </section>
    
    <error ref="error" />
  </div>
</template>

<script>
import Vue from 'vue';
import information from './form/information.vue'
import goldForm from './form/goldForm.vue'
import interest from './form/interest.vue'
import saveSection from './saveSection.vue'
import error from './popup/error.vue'

export default Vue.extend({
  components:{
    information,
    goldForm,
    interest,
    saveSection,
    error
  },
  data() {
    return {
        userData : {},
        goldData : [],
        interest : 3,
        showbutton : 0
    }
  },
  watch: {
    userData: {
      deep: true,
      handler(userData) {
        this.checkreq()
      }
    },
    goldData: {
      deep: true,
      handler(goldData) {
        this.checkreq()
      }
    }
  },
  methods: {
    checkreq() {
      if (   this.userData.first_name.length
          && this.userData.last_name.length
          && this.goldData.length) {
        this.showbutton = 1
      }else {
        this.showbutton = 0
      }
    },
    updateInformation(data) {
      this.userData = data
    },
    updateGold(data) {
      this.goldData = data
    },
    updateInterest(data) {
      this.interest = parseInt(data)
    },
    async saveData() {
      let pawn = {
        user : this.userData,
        pawn_items : this.goldData,
        interest_rate : this.interest
      }
      await window.api.post(`pawns`, {pawn}
      ).catch(
          this.$refs.error.setShowPop(1,'ERROR')
      ).then(() => {
          this.$refs.error.setShowPop(1,'Data has been updated.')
      })
    }
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
