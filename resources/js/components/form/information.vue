<template>
  <div>
    <div class="sec-form">
      <div class="sec-form grow-1 mr-lg-2 mb-3">
        <div class="head-form">ค้นหาลูกค้า</div>
        <input type="text"  ref="search-imformation" class="form-control" @keyup="search(searchKeyWord)" v-model="searchKeyWord" required>
        <div class="form-control hint" v-for="item in pawn_item_suggest_id" @click="updateFormNumber(item)" :key="item" >{{item}}</div>
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
      searchKeyWord: "",
      pawn_item_suggest_id: [],
      pawnItemStatus: true,
      tmpPawnItem: []
    }
  },
  methods: {
    updateSex(val) {
      this.sex = val;
    },

    async search(item) {
      console.log('search');
      if (item) {
        let res1 = await window.api.get("pawn_user_items", {
        params: {
          search: 
            {
              keyword: item,
              fields:['pawn_no','identity_card_id','first_name','last_name']
            }
          }
        });
        if (this.pawnItemStatus && res1.data && (res1.data.pawn_items[0].pawn_no === item || res1.data.pawn_items[0].identity_card_id === item || res1.data.pawn_items[0].first_name === item || res1.data.pawn_items[0].last_name === item) ) {
          this.updateFormNumber(item)
          this.pawnItemStatus = false
          this.pawn_item_suggest_id = []
          this.tmpPawnItem = []
        }
        else if(res1.data.pawn_items.length > 0) {
          let output = {}
          let res = res1.data.pawn_items
          let pawn_no_list = []
          this.pawn_item_suggest_id = []
          this.tmpPawnItem = res
          res.forEach( ele => {
            pawn_no_list.push(ele.pawn_no)
            if (ele.pawn_no && ele.pawn_no.match(item)) {
              this.pawn_item_suggest_id.push(ele.pawn_no)
              this.$set(output, ele.pawn_id, ele.pawn_no)
            }else if (ele.identity_card_id && ele.identity_card_id.match(item)) {
              this.pawn_item_suggest_id.push(ele.identity_card_id)
              this.$set(output, ele.pawn_id, ele.pawn_no)
            }else if (ele.first_name && ele.first_name.match(item)) {
              this.pawn_item_suggest_id.push(ele.first_name)
              this.$set(output, ele.pawn_id, ele.pawn_no)
            }else if (ele.last_name && ele.last_name.match(item)) {
              this.pawn_item_suggest_id.push(ele.last_name)
              this.$set(output, ele.pawn_id, ele.pawn_no)
            }
          });
          pawn_no_list = [...new Set(pawn_no_list)]
          this.pawn_item_suggest_id = [...new Set(this.pawn_item_suggest_id)]
          if (this.pawn_item_suggest_id.length === 1 && this.pawn_item_suggest_id[0].length === item.length) {
              this.pawn_item_suggest_id = []
              this.searchKeyWord = ""
              this.updateUserData(res1.data.pawn_items[0])
              console.log('zxc',output);
          }
        }else {
            this.pawn_item_suggest_id = []
            this.tmpPawnItem = []
        }
      }else {
          this.pawn_item_suggest_id = []
      }
    },
    async updateFormNumber(id) {
      console.log('updateFormNumber');
      let status = true
      let pawnItem = []
      let res = await window.api.get("pawn_user_items", {
        params: {
          search: 
            {
              keyword: id,
              fields:['pawn_no','identity_card_id','first_name','last_name']
            }
          }
        });
      res = res.data.pawn_items[0]
      let res2 = await window.api.get(`users/${res.customer_id}`);
      this.updateUserData(res2.data.users)
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
        email: val.email
      }
    }
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
    this.$refs.first_name.focus();
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
