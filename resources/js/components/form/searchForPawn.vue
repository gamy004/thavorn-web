<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ หรือ เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="numberSearch" @keyup="search(numberSearch)" required>
      <div class="form-control hint" v-for="item in pawn_item_suggest_id" @click="updateFormNumber(item)" :key="item" >{{item}}</div>
    </div>

    <div class="sec-form">
      <div class="head-form">ชื่อ</div>
      <div type="text" class="form-control" v-text="active_user.first_name"></div>
      <div class="head-form">นามสกุล</div>
      <div type="text" class="form-control" v-text="active_user.last_name"></div>
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
        name_suggest:[],
        active_user:{}
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
      console.log('search');
      this.emitList([])
      if (item) {
        let res1 = await window.api.get("pawn_user_items", {
        params: {
          search: 
            {
              keyword: item,
              fields:['pawn_no','identity_card_id','first_name']
            }
          }
        });
        // console.log(1515, res1.data.pawn_items[0].pawn_no, res1.data.pawn_items[0].identity_card_id ,item);
        if (this.pawnItemStatus && res1.data && (res1.data.pawn_items[0].pawn_no === item || res1.data.pawn_items[0].identity_card_id === item || res1.data.pawn_items[0].first_name === item) ) {
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
            }
          });
          pawn_no_list = [...new Set(pawn_no_list)]
          this.pawn_item_suggest_id = [...new Set(this.pawn_item_suggest_id)]
          if (this.pawn_item_suggest_id.length === 1 && this.pawn_item_suggest_id[0].length === item.length) {
              this.pawn_item_suggest_id = []
              this.nameSearch = ""
              this.active_user = {
                first_name : res1.data.pawn_items[0].first_name,
                last_name : res1.data.pawn_items[0].last_name
              }
              console.log('zxc',output);
              
              this.emitList(output)
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
      for (let i = 0; i < this.tmpPawnItem.length; i++) {
        if (this.tmpPawnItem[i].identity_card_id === id || this.tmpPawnItem[i].pawn_no === id || this.tmpPawnItem[i].first_name === id) {
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

    async pushPawnList(key) {
        console.log('pushPawnList');
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
        let output = {}
        console.log('res1 :',res1.data.pawn_items);
        res1 = res1.data.pawn_items
        res1.forEach( item => {
            this.$set(output, item.pawn_id, item.pawn_no)
            // listNumber.push(item.pawn_no)
        });
        // listNumber = [...new Set(listNumber)]

        this.active_user = {
          first_name : res1[0].first_name,
          last_name : res1[0].last_name
        }
        console.log('listNumber :',listNumber);
        
        this.emitList(output)
    },
    emitList(list) {
        console.log('emit');
      
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
