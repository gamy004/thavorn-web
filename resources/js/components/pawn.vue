<template>
  <div>
    <section>
        <h2>ข้อมูลส่วนตัวลูกค้า</h2>
    </section>
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'nevbar',
  props: {
    msg: String,
    logo: {
      type : [Boolean, Number],
      default : false
    }
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
