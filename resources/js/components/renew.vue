<template>
  <div>
    <section class="card">
        <h2>ข้อมูลการจำนำ</h2>
        <search />
        <saveSection class="mt-5" />
    </section>
  </div>
</template>

<script>
import Vue from 'vue';
import information from './form/information.vue'
import goldForm from './form/goldForm.vue'
import interest from './form/interest.vue'
import saveSection from './saveSection.vue'
import redeemForm from './form/redeemform.vue'
import search from './form/searchForPawn.vue'

export default Vue.extend({
  name: 'redeem',
  components:{
    information,
    goldForm,
    interest,
    saveSection,
    redeemForm,
    search
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
