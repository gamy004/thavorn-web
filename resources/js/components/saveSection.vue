<template>
  <div class="section-btn">
      <button v-if="useType === 'create'" class="btn btn-success btn-lg mr-3">บันทึก</button>
      <button v-else-if="useType === 'update'" class="btn btn-success btn-lg mr-3">บันทึก</button>
      <button class="btn btn-outline-danger btn-lg">ยกเลิก</button>
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'saveSection',
  data() {
    return {
        rate : '',
    }
  },
  props: {
    useType: {
      type : [String, Number],
      default: 'create'
    }
  },
  methods: {

  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.section-btn{
    display: flex;
    justify-content: center;
}
</style>
