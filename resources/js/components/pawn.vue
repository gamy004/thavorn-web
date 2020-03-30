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
      <saveSection @click:save="saveData" />
    </section>
  </div>
</template>

<script>
import Vue from 'vue';
import information from './form/information.vue'
import goldForm from './form/goldForm.vue'
import interest from './form/interest.vue'
import saveSection from './saveSection.vue'

export default Vue.extend({
  components:{
    information,
    goldForm,
    interest,
    saveSection
  },
  data() {
    return {
        userData : {},
        goldData : [],
        interest : 3
    }
  },
  methods: {
    updateInformation(data) {
      this.userData = data
    },
    updateGold(data) {
      this.goldData = data
    },
    updateInterest(data) {
      this.interest = parseInt(data)
    },
    saveData() {
      let pawn = {
        pawn_no : null,
        user : this.userData,
        pawn_items : this.goldData,
        interest_rate : this.interest
      }
      window.api.post(`pawns`, {pawn});
      console.log('Sent data',pawn);
    }
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
