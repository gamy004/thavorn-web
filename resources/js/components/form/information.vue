<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="cardNumber" required>
      <div class="form-control hint" v-for="item in suggest_id" :key="item" @click="updateForm(item)">{{item}}</div>
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
        <div class="form-check mr-3" @click="updateSex('M')">
          <input class="form-check-input" type="radio" value="M" v-model="sex" checked>
          <label class="form-check-label">
          ชาย
          </label>
        </div>
        <div class="form-check" @click="updateSex('F')">
          <input class="form-check-input" type="radio" value="F"  v-model="sex">
          <label class="form-check-label">
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
  data() {
    return {
      name : "",
      surname : "",
      cardNumber : "",
      sex : "M",
      phone: "",
      line: "",
      facebook: "",
      suggest_id: [],
      tmpUser: [],
      suggestStatus: false
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
          this.cardNumber = res.identity_card_id
          this.surname = res.last_name
          this.name = res.first_name
          this.sex = res.gender
          this.facebook = res.facebook
          this.line = res.line
          this.phone = res.phone_number
          console.log( res.identity_card_id);
          break;
        }
      }
    }
  },
  watch: {
    cardNumber: {
      async handler(cardNumber) {

        let res1 = await window.api.get("users", {
        params: {
          filters: [
            {
              key: "identity_card_id",
              value: cardNumber,
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
        else if(res1.data.users.length > 0 && this.cardNumber.length > 0) {
          let res = res1.data.users
          this.suggest_id = []
          this.tmpUser = res
          res.forEach( item => {
            this.suggest_id.push(item.identity_card_id)
          });
        }else {
          this.suggest_id = []
          this.tmpUser = []
        }

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
