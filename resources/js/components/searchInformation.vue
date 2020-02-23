<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="cardNumber" required>
    </div>
    <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ</div>
      <input type="text" class="form-control" v-model="pawnId" required>
    </div>
    <div class="h-flex-row-s-flex-col">
      <div class="sec-form grow-1 mr-lg-2">
        <div class="head-form">ชื่อ</div>
        <div type="text" class="form-control showData" required>{{name}}</div>
      </div>
      <div class="sec-form grow-1">
        <div class="head-form">นามสกุล</div>
        <div type="text" class="form-control showData" required>{{surname}}</div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'searchInformation',
  data() {
    return {
      name : "",
      surname : "",
      cardNumber : "",
      sex : "M",
      phone: "",
      line: "",
      facebook: "",
      pawnId: ""
    }
  },
  methods: {
    updateSex(val) {
      this.sex = val;
    }
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.sec-form{
  margin: 12px 0 12px 0;
}

.grow-1{
  flex-grow: 1;
}
.head-form{
  margin-bottom: 6px;
}
</style>
