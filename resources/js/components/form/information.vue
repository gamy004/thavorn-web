<template>
  <div>
    <div class="h-flex-row-s-flex-col">
      <div class="sec-form grow-1 mr-lg-2">
        <div class="head-form">ชื่อ</div>
        <input type="text"  ref="first_name" class="form-control" v-model="userData.first_name" autofocus  required>
      </div>
      <div class="sec-form grow-1">
        <div class="head-form">นามสกุล</div>
        <input type="text" class="form-control" v-model="userData.last_name" required>
      </div>
    </div>
    <div class="sec-form">
      <div class="head-form">เพศ</div>
      <div class="flex-row">
        <div class="form-check mr-3" @click="updateSex('M')">
          <input class="form-check-input" type="radio" value="M" v-model="userData.gender" checked>
          <label class="form-check-label">
          ชาย
          </label>
        </div>
        <div class="form-check" @click="updateSex('F')">
          <input class="form-check-input" type="radio" value="F"  v-model="userData.gender">
          <label class="form-check-label">
          หญิง
          </label>
        </div>
      </div>
      </div>
    <div class="sec-form">
      <div class="head-form">เบอร์โทรศัพท์</div>
      <input type="text" class="form-control" v-model="userData.phone_number" required>
    </div>
    <div class="sec-form">
      <div class="head-form">เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="userData.identity_card_id" required>
      <div class="form-control hint" v-for="item in suggest_id" :key="item" @click="updateForm(item)">{{item}}</div>
    </div>
    <div class="sec-form">
      <div class="head-form">Email</div>
      <input type="text" class="form-control" v-model="userData.email" required>
    </div>
    <div class="sec-form">
      <div class="head-form">Facebook</div>
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
        first_name : "",
        last_name : "",
        identity_card_id : "",
        gender : "M",
        phone_number: "",
        line: "",
        facebook: "",
        email: ""
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
          this.userData.identity_card_id = res.identity_card_id
          this.userData.last_name = res.last_name
          this.userData.first_name = res.first_name
          this.userData.gender = res.gender
          this.userData.facebook = res.facebook
          this.userData.line = res.line
          this.userData.phone_number = res.phone_number
          this.userData.email = res.email
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
              value: userData.identity_card_id,
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
        else if(res1.data.users.length > 0 && this.userData.identity_card_id.length > 0) {
          let res = res1.data.users
          this.suggest_id = []
          this.tmpUser = res
          res.forEach( item => {
            this.suggest_id.push(item.identity_card_id)
            if (this.suggest_id !== userData.identity_card_id) {
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
  mounted() {
    this.$refs.first_name.focus();
    console.log(this.$refs)
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
