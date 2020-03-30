<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ หรือ เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="cardNumber" required>
      <div class="form-control hint" v-for="item in pawn_item_suggest_id" @click="updateForm(item)" :key="item" >{{item}}</div>
    </div>
    <!-- <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ</div>
      <input type="text" class="form-control" v-model="pawnId" required>
    </div> -->
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
      pawnId: "",
      pawn_item_suggest_id: [],
      tmpPawnItem: [],
      pawnItemStatus: false
    }
  },
  methods: {
    updateSex(val) {
      this.sex = val;
    },
    async search(item) {
      if (item) {
        let res1 = await window.api.get("pawn_user_items", {
        params: {
          search: 
            {
              keyword: item,
              fields:['identity_card_id', 'pawn_no']
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
            this.cardNumber = id
  
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
            this.surname = userData.first_name
            this.name = userData.last_name
            pawnItem.push(res)
            status = false
          }else {
            pawnItem.push(res)
          }
        }
      }
      if (pawnItem) {
        this.$emit('sentDataPawnItem',pawnItem)
      }
    }
  },
  watch: {
    cardNumber: {
      async handler(cardNumber) {
        this.search(cardNumber)
      }
    },
  },
  mounted() {

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
