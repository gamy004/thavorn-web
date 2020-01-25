<template>
  <div>
    <section class="card">
      <h2>ข้อมูลส่วนตัวลูกค้า</h2>
      <information />
    </section>
    <section class="card">
      <h2>ข้อมูลทอง</h2>
      <goldForm />
    </section>
    <section class="card">
      <h2>ส่วนดอกเบี้ย</h2>
      <interest />
      <saveSection />
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
  name: 'nevbar',
  components:{
    information,
    goldForm,
    interest,
    saveSection
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
