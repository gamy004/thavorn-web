<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ หรือ เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="pawnId" required>
      <div class="form-control hint" v-for="item in pawn_item_suggest_id" @click="updateForm(item)" :key="item" >{{item}}</div>
    </div>
    <!-- <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ</div>
      <input type="text" class="form-control" v-model="pawnId" required>
    </div> -->
    <div class="h-flex-row-s-flex-col">
      <div class="sec-form grow-1 mr-lg-2">
        <div class="head-form">ชื่อ</div>
        <div type="text" class="form-control showData" v-text="userData.first_name"></div>
      </div>
      <div class="sec-form grow-1">
        <div class="head-form">นามสกุล</div>
        <div type="text" class="form-control showData" v-text="userData.last_name"></div>
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
      pawnId: "",
      pawn_item_suggest_id: [],
      tmpPawnItem: [],
      pawnItemStatus: false,

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
    }
  },
  methods: {
    async search(item) {
      if (item) {
        let res1 = await window.api.get("pawn_user_items", {
        params: {
          search: 
            {
              keyword: item,
              fields:['pawn_no','identity_card_id']
            }
          }
        });
        // console.log(1515, res1.data.pawn_items[0].pawn_no, res1.data.pawn_items[0].identity_card_id ,item);
        if (this.pawnItemStatus && res1.data && (res1.data.pawn_items[0].pawn_no === item || res1.data.pawn_items[0].identity_card_id === item) ) {
          this.pawnItemStatus = false
          this.pawn_item_suggest_id = []
          this.tmpPawnItem = []
        }
        else if(res1.data.pawn_items.length > 0) {
          let res = res1.data.pawn_items
          this.pawn_item_suggest_id = []
          this.tmpPawnItem = res
          res.forEach( ele => {
            if (ele.pawn_no.match(item)) {
              this.pawn_item_suggest_id.push(ele.pawn_no)
            }else if (ele.identity_card_id.match(item)) {
              this.pawn_item_suggest_id.push(ele.identity_card_id)
            }
          });
          this.pawn_item_suggest_id = [...new Set(this.pawn_item_suggest_id)]
        }else {
          this.pawn_item_suggest_id = []
          this.tmpPawnItem = []
        }
      }
    },
    async updateForm(id) {
      let status = true
      let pawnItem = []
      for (let i = 0; i < this.tmpPawnItem.length; i++) {
        if (this.tmpPawnItem[i].identity_card_id === id || this.tmpPawnItem[i].pawn_no === id) {
          let res = this.tmpPawnItem[i]
          if (status) {
            this.pawnItemStatus = true
            this.pawnId = id
  
            let userId = this.tmpPawnItem[i].identity_card_id
            let resUser = await window.api.get("users", {
            params: {
              filters: [
                {
                  key: "identity_card_id",
                  value: userId,
                  operator: "eq"
                }
              ]
            }
            });
            let userData = resUser.data.users[0]
            this.userData.id = userData.id
            this.userData.first_name = userData.first_name
            this.userData.last_name = userData.last_name
            this.userData.identity_card_id = userData.identity_card_id
            this.userData.gender = userData.gender
            this.userData.facebook = userData.facebook
            this.userData.line = userData.line
            this.userData.email = userData.email
            this.userData.phone_number = userData.phone_number

            pawnItem.push(res)
            status = false
          }else {
            pawnItem.push(res)
          }
        }
      }
      if (pawnItem) {
        this.$emit('sentDataPawnItem',pawnItem)
        this.$emit('emit:information',this.userData,this.pawnId)
      }
    }
  },
  watch: {
    pawnId: {
      async handler(pawnId) {
        this.search(pawnId)
      }
    },
  },
  mounted() {

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
</style>
