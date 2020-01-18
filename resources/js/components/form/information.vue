<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขบัตรประชาชน</div>
      <input type="Number" class="form-control" v-model="cardNumber" required>
    </div>
    <div class="h-flex-row-s-flex-col">
      <div class="sec-form grow-1 mr-lg-2">
        <div class="head-form">ชื่อ</div>
        <input type="text" class="form-control" v-model="name" required>
      </div>
      <div class="sec-form grow-1">
        <div class="head-form">นามสกุล</div>
        <input type="text" class="form-control" v-model="surname" required>
      </div>
    </div>
    <div class="sec-form">
      <div class="head-form">เพศ</div>
      <div class="flex-row">
        <div class="form-check mr-3">
          <input class="form-check-input" type="radio" name="exampleRadios" id="sexRadios1" value="male" v-model="sex" checked>
          <label class="form-check-label" for="exampleRadios1">
          ชาย
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="exampleRadios" id="sexRadios2" value="female"  v-model="sex">
          <label class="form-check-label" for="exampleRadios2">
          หญิง
          </label>
        </div>
      </div>
      </div>
    <div class="sec-form">
      <div class="head-form">เบอร์โทรศัพท์</div>
      <input type="text" class="form-control" v-model="phone" required>
    </div>
    <div class="sec-form">
      <div class="head-form">Fackbook</div>
      <input type="text" v-model="facebook" class="form-control">
    </div>
    <div class="sec-form">
      <div class="head-form">Line</div>
      <input type="text" v-model="line" class="form-control">
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'imformation',
  data() {
    return {
      name : "",
      surname : "",
      cardNumber : "",
      sex : "male",
      phone: "",
      line: "",
      facebook: "",
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
