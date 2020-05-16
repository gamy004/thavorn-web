<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ หรือ เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="numberSearch" @keyup="search(numberSearch)" required>
      <div class="form-control hint" v-for="item in pawn_item_suggest_id" @click="updateFormNumber(item)" :key="item" >{{item}}</div>
    </div>

    <div class="sec-form">
      <div class="head-form">ชื่อ</div>
      <input type="text" class="form-control" v-model="nameSearch" @keyup="searchName(nameSearch)" required>
      <div class="form-control hint" v-for="item in name_suggest" @click="updateFormName(item)"  :key="item" >{{item}}</div>
    </div>

  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'SearchForm',
  props: {
    type: ''
    //redeem , renew
  },
  data() {
    return {
        numberSearch:"",
        nameSearch:"",
        pawn_item_suggest_id: [],
        name_suggest:[]
    }
  },
  watch: {
    // numberSearch: {
    //   async handler(numberSearch) {
    //     this.search(numberSearch)
    //   }
    // },

  },
  methods: {
    async search(item) {
      this.emitList([])
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
          let pawn_no_list = []
          this.pawn_item_suggest_id = []
          this.tmpPawnItem = res
          res.forEach( ele => {
            pawn_no_list.push(ele.pawn_no)
            if (ele.pawn_no.match(item)) {
              this.pawn_item_suggest_id.push(ele.pawn_no)
            }else if (ele.identity_card_id.match(item)) {
              this.pawn_item_suggest_id.push(ele.identity_card_id)
            }
          });
          pawn_no_list = [...new Set(pawn_no_list)]
          this.pawn_item_suggest_id = [...new Set(this.pawn_item_suggest_id)]
          if (this.pawn_item_suggest_id.length === 1 && this.pawn_item_suggest_id[0].length === item.length) {
              this.pawn_item_suggest_id = []
              this.nameSearch = ""
              this.emitList(pawn_no_list)
          }
        }else {
            this.pawn_item_suggest_id = []
            this.tmpPawnItem = []
        }
      }else {
          this.pawn_item_suggest_id = []
      }
    },

    async searchName(item) {
      this.emitList([])
      if (item) {
        let res1 = await window.api.get("pawn_user_items", {
        params: {
          search: 
            {
              keyword: item,
              fields:['first_name']
            }
          }
        });
        // console.log(1515, res1.data.pawn_items[0].pawn_no, res1.data.pawn_items[0].identity_card_id ,item);
        if (this.pawnItemStatus && res1.data && res1.data.pawn_items[0].first_name === item ) {
          this.pawnItemStatus = false
          this.name_suggest = []
          this.tmpPawnItem = []
        }
        else if(res1.data.pawn_items.length > 0) {
          let res = res1.data.pawn_items
          let pawn_no_list = []
          this.name_suggest = []
          this.tmpPawnItem = res
          res.forEach( ele => {
              this.name_suggest.push(ele.first_name)
              pawn_no_list.push(ele.pawn_no)
          });
          this.name_suggest = [...new Set(this.name_suggest)]
          pawn_no_list = [...new Set(pawn_no_list)]
          if (this.name_suggest.length === 1 && this.name_suggest[0].length === item.length) {
              this.name_suggest = []
              this.numberSearch = ""
              this.emitList(pawn_no_list)
          }
        }else {
            this.name_suggest = []
            this.tmpPawnItem = []
        }
      }else {
          this.name_suggest = []
      }
    },

    async updateFormNumber(id) {
      let status = true
      let pawnItem = []
      for (let i = 0; i < this.tmpPawnItem.length; i++) {
        if (this.tmpPawnItem[i].identity_card_id === id || this.tmpPawnItem[i].pawn_no === id) {
          let res = this.tmpPawnItem[i]
          if (status) {
            this.pawnItemStatus = true
            this.numberSearch = id
            status = false
            this.nameSearch = ""
            this.pushPawnList(id)
            this.pawn_item_suggest_id = []
            break
          }
        }
      }
    },

    async updateFormName(id) {
      let status = true
      let pawnItem = []
      for (let i = 0; i < this.tmpPawnItem.length; i++) {
        if (this.tmpPawnItem[i].first_name === id) {
          let res = this.tmpPawnItem[i]
          if (status) {
            this.pawnItemStatus = true
            this.nameSearch = id
            status = false
            this.numberSearch = ""
            this.pushPawnList(id)
            this.name_suggest = []
            break
          }
        }
      }
    },

    async pushPawnList(key) {
        let res1 = await window.api.get("pawn_user_items", {
        params: {
        search: 
            {
            keyword: key,
            fields:['pawn_no','identity_card_id','first_name']
            }
        }
        });
        let listNumber = []
        res1 = res1.data.pawn_items
        res1.forEach( item => {
            listNumber.push(item.pawn_no)
        });
        listNumber = [...new Set(listNumber)]
        this.emitList(listNumber)
    },
    emitList(list) {
        this.$emit('listPawn',list)
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
