<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="cardNumber" required>
    </div>

    <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ</div>
      <input type="text" class="form-control" v-model="cardNumber" required>
    </div>
    <div class="mt-5">
      <div class="h-flex-row-s-flex-col">
        <div class="sec-form grow-1 mr-lg-2">
          <div class="head-form">ชื่อ</div>
          <div type="text" class="form-control">{{name}}</div>
        </div>
        <div class="sec-form grow-1">
          <div class="head-form">นามสกุล</div>
          <div type="text" class="form-control">{{surname}}</div>
        </div>
      </div>
      
      <div class="sec-form">
        <div class="head-form">ประเภททอง</div>
        <div type="text" class="form-control">{{}}</div>
      </div>

      <div class="sec-form">
        <div class="head-form">น้ำหนักทอง</div>
        <div type="text" class="form-control">{{}}</div>
      </div>

      <div class="sec-form">
        <div class="head-form">จำนวนเดือน</div>
        <div type="text" class="form-control">{{}}</div>
      </div>

      <div class="sec-form">
        <div class="head-form">จำนวนดอก(%)</div>
        <div type="text" class="form-control">{{}}</div>
      </div>

      <div class="sec-form" v-if="type === 'redeem' ">
        <div class="head-form">วันที่ล่าสุด</div>
        <div type="text" class="form-control">{{}}</div>
      </div>

      <div v-if="type === 'renew' ">
        <div class="sec-form">

          <div class="head-form">วันที่ล่าสุด</div>
          <div type="text" class="form-control">renew</div>

          <div class="form-check mt-2">
            <input type="checkbox" class="form-check-input" id="forgetCard" v-model="forgetCard">
            <label class="form-check-label" for="forgetCard">บัตรหาย</label>
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'redeemform',
  props: {
    type: ''
    //redeem , renew
  },
  data() {
    return {
        name : "",
        surname : "",
        cardNumber : "",
        forgetCard : false
    }
  },
  methods: {
    updateForgetCard() {
      if(this.forgetCard === 1){
        this.forgetCard = 0
      }else if(this.forgetCard === 0){
        this.forgetCard = 1
      }
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
