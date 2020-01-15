<template>
  <div>
    <section class="card">
      <h2>ข้อมูลส่วนตัวลูกค้า</h2>
      <information />
    </section>
    <section class="card">
      <h2>ข้อมูลทอง</h2>

    </section>
  </div>
</template>

<script>
import Vue from 'vue';
import information from './form/information.vue'

export default Vue.extend({
  name: 'nevbar',
  components:{
    information
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
