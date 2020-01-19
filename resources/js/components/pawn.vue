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
  </div>
</template>

<script>
import Vue from 'vue';
import information from './form/information.vue'
import goldForm from './form/goldForm.vue'

export default Vue.extend({
  name: 'nevbar',
  components:{
    information,
    goldForm
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
