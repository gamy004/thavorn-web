<template>
  <div>
    <div class="sec-form">
      <div class="sec-form grow-1 mr-lg-2 mb-3">
        <div class="head-form">ค้นหาลูกค้า</div>
        <input type="text"  ref="search_imformation" class="form-control" @keyup="search" v-model="searchKeyWord" @keydown.down = 'selectUp' @keydown.up = 'selectDown' @keyup.enter='selectEnter' required>
        <div class="form-control hint" 
        v-for="(item, index) in pawn_item_suggest_id" 
        @click="clickSuggest(item)" 
        :key="item"
        :class="{ 'active': index === select }"  >
          {{item}}
        </div>
      </div>
    </div>
    <div class="h-flex-row-s-flex-col">

      <div class="sec-form grow-1 mr-lg-2">
        <div class="head-form">ชื่อ</div>
        <input type="text"  ref="first_name" class="form-control" v-model="userData.first_name" required>
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
    <div class="sec-form">
      <div class="head-form">Note</div>
      <textarea id="textarea-note" class="form-control" v-model="userData.note" ></textarea>
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
        email: "",
        note:""
      },
      suggest_id: [],
      tmpUser: [],
      suggestStatus: false,
      searchKeyWord: "",
      pawn_item_suggest_id: [],
      pawnItemStatus: true,
      tmpUser: [],
      select: 0
    }
  },
  methods: {
    updateSex(val) {
      this.sex = val;
    },
    selectUp() {
      this.select++
      if (this.select === this.pawn_item_suggest_id.length) {
        this.select--
      }
    },
    selectDown() {
      this.select--
      if (this.select < 0) {
        this.select++
      }
    },
    selectEnter() {
      this.searchKeyWord = this.pawn_item_suggest_id[this.select]
      this.search()
    },

    async search(e) {
      if (e && (e.keyCode === 38 || e.keyCode === 40 || e.keyCode === 13)) {
        return
      }
      this.select = 0
      let item = this.searchKeyWord
      console.log('search');
      if (item && item.length) {
        let user =  await this.getUser(item)
        if(user && user.length && user[0].full_name === item) {
          // click hint
          console.log('search 2 if');
          this.clickSuggest(item)
          this.pawnItemStatus = false
          this.pawn_item_suggest_id = []
        }
        else if(user && user.length >0 ) {
          this.pawn_item_suggest_id = []
          this.tmpUser = user
          for (let i = 0; i < this.tmpUser.length; i++) {
            if (this.tmpUser[i].full_name === item) {
              this.clickSuggest(item)
              this.pawnItemStatus = false
              this.pawn_item_suggest_id = []
            }
          }
          user.forEach( ele => {
            if (ele.full_name && ele.full_name.match(item)) {
              this.pawn_item_suggest_id.push(ele.full_name)
            }
          });
        }else {
            this.pawn_item_suggest_id = []
        }
      }else {
          this.pawn_item_suggest_id = []
      }
    },
    async clickSuggest(id) {
      console.log('clickSuggest');
      let status = true
      let user = await window.api.get("users", {
        params: {
          search: 
            {
              keyword: id,
              fields:['first_name','last_name']
            }
          }
        });
      user = user.data.users[0]
      console.log('asd',user);
      
      this.updateUserData(user)
      this.searchKeyWord = ""
      this.pawn_item_suggest_id = []
      this.pawnItemStatus = true
    },
    updateUserData(val) {
      this.userData = {
        id : val.id,
        first_name : val.first_name,
        last_name : val.last_name,
        identity_card_id : val.identity_card_id,
        gender : val.gender,
        phone_number: val.phone_number,
        line: val.line,
        facebook: val.facebook,
        email: val.email,
        note: val.note
      }
    },
    async getUser (item) {
      let user = await window.api.get("users", {
        params: {
          search: 
            {
              keyword: item,
              fields:['first_name','last_name']
            }
          }
        });
      return user.data.users
    },
  },
  watch: {
    userData:{
      deep: true,
      immediate: true,
      handler(userData) {
        this.$emit("emit:information",this.userData)
      }
    }
  },
  mounted() {
    this.$refs.search_imformation.focus();
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.grow-1{
  flex-grow: 1;
}
.head-form{
  margin-bottom: 6px;
}
.active{
  background-color: rgb(148, 148, 148);
}
</style>
