<template>
  <div>
    <div class="sec-form">
        <div class="head-form">จำนวนดอกเบี้ยต่อเดือน(%)</div>

        <div class="flex-row">
            <input type="number" class="form-control" min="0" max="100" v-model="interest_rate">
        </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'interest',
  data() {
    return {
        interest_rate : 3,
    }
  },
  watch: {
    immediate: true,
    interest_rate: {
      async handler(interest_rate) {
        this.$emit('emit:interest',interest_rate)
      }
    }
  }
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>
