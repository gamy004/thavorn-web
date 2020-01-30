<template>
  <div>
    <div class="sec-form">
        <div class="head-form">จำนวนดอกเบี้ยต่อเดือน(%)</div>

        <div class="flex-row">
            <input type="text" class="form-control" v-model="interest_rate">
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
        interest_rate : '',
    }
  },
  methods: {

  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>
