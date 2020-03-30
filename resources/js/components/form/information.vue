<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="userData.cardNumber" required>
      <div class="form-control hint" v-for="item in suggest_id" :key="item" @click="updateForm(item)">{{item}}</div>
    </div>
    <div class="h-flex-row-s-flex-col">
      <div class="sec-form grow-1 mr-lg-2">
        <div class="head-form">ชื่อ</div>
        <input type="text" class="form-control" v-model="userData.name" required>
      </div>
      <div class="sec-form grow-1">
        <div class="head-form">นามสกุล</div>
        <input type="text" class="form-control" v-model="userData.surname" required>
      </div>
    </div>
    <div class="sec-form">
      <div class="head-form">เพศ</div>
      <div class="flex-row">
        <div class="form-check mr-3" @click="updateSex('M')">
          <input class="form-check-input" type="radio" value="M" v-model="userData.sex" checked>
          <label class="form-check-label">
          ชาย
          </label>
        </div>
        <div class="form-check" @click="updateSex('F')">
          <input class="form-check-input" type="radio" value="F"  v-model="userData.sex">
          <label class="form-check-label">
          หญิง
          </label>
        </div>
      </div>
      </div>
    <div class="sec-form">
      <div class="head-form">เบอร์โทรศัพท์</div>
      <input type="text" class="form-control" v-model="userData.phone" required>
    </div>
    <div class="sec-form">
      <div class="head-form">Fackbook</div>
      <input type="text" v-model="userData.facebook" class="form-control">
    </div>
    <div class="sec-form">
      <div class="head-form">Line</div>
      <input type="text" v-model="userData.line" class="form-control">
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  data() {
    return {
      userData : {
        id : null,
        name : "",
        surname : "",
        cardNumber : "",
        sex : "M",
        phone: "",
        line: "",
        facebook: "",
      },
      suggest_id: [],
      tmpUser: [],
      suggestStatus: false,
    }
  },
  methods: {
    updateSex(val) {
      this.sex = val;
    },
    updateForm(id) {
      for (let i = 0; i < this.tmpUser.length; i++) {
        if (this.tmpUser[i].identity_card_id === id) {
          this.suggestStatus = true
          let res = this.tmpUser[i]
          this.userData.id = res.id
          this.userData.cardNumber = res.identity_card_id
          this.userData.surname = res.last_name
          this.userData.name = res.first_name
          this.userData.sex = res.gender
          this.userData.facebook = res.facebook
          this.userData.line = res.line
          this.userData.phone = res.phone_number
          break;
        }
      }
    }
  },
  watch: {
    userData: {
      deep: true,
      async handler(userData) {
        let res1 = await window.api.get("users", {
        params: {
          filters: [
            {
              key: "identity_card_id",
              value: userData.cardNumber,
              operator: "ct"
            }
          ]
        }
        });
        console.log(res1.data.users);
        if (this.suggestStatus) {
          this.suggestStatus = false
          this.suggest_id = []
          this.tmpUser = []
        }
        else if(res1.data.users.length > 0 && this.userData.cardNumber.length > 0) {
          let res = res1.data.users
          this.suggest_id = []
          this.tmpUser = res
          res.forEach( item => {
            this.suggest_id.push(item.identity_card_id)
            if (this.suggest_id !== userData.cardNumber) {
              userData.id = null
            }
          });
        }else {
          this.suggest_id = []
          this.tmpUser = []
        }
        this.$emit("emit:information",this.userData)
      }
    },
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
