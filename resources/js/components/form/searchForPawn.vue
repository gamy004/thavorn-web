<template>
  <div>
    <div class="sec-form">
      <div class="head-form">เลขที่บัตรจำนำ หรือ เลขบัตรประชาชน</div>
      <input type="text" class="form-control" v-model="numberSearch" @keyup="search" @keydown.down = 'selectUp' @keydown.up = 'selectDown' @keyup.enter='selectEnter' required>
      <div class="form-control hint" 
        v-for="(item, index) in pawn_item_suggest_id" 
        @click="updateFormNumber(item)" 
        :class="{ 'active': index === select }" 
        :key="item" >
          {{item}}
      </div>
    </div>

    <div class="sec-form">
      <div class="head-form">ชื่อ</div>
      <div type="text" class="form-control" v-text="active_user.first_name"></div>
      <div class="head-form">นามสกุล</div>
      <div type="text" class="form-control" v-text="active_user.last_name"></div>
      <div class="head-form">Note</div>
      <div type="text" class="form-control cus-text" v-text="active_user.note"></div>
    </div>

  </div>
</template>

<script>
import Vue from 'vue';
import { debounce } from 'lodash';

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
        active_user:{},
        tmpPawnItem: [],
        tmpUser: [],
        select: 0
    }
  },
  watch: {
    // numberSearch: {
    //   async handler(numberSearch) {
    //     this.search(numberSearch)
    //   }
    // },

  },

  mounted() {
    this.search = debounce(this.search, 300)
  },

  methods: {
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
      this.numberSearch = this.pawn_item_suggest_id[this.select]
      this.search()
    },
    async search(e) {
      if (e && (e.keyCode === 38 || e.keyCode === 40 || e.keyCode === 13)) {
        return
      }
      this.select = 0
      let item = this.numberSearch
      console.log('search');
      this.emitList([])
      if (item && item.length) {
        console.log('search first if');
        let pawn_user_items = await this.getPawnUserItem(item)
        let user =  await this.getUser(item)
        console.log(user);
        if (pawn_user_items && pawn_user_items.length && (pawn_user_items[0].pawn_no === item || pawn_user_items[0].identity_card_id === item)) {
          // click hint
          console.log('search 2 if');
          this.clickhintWork(item)
          this.pawnItemStatus = false
          this.pawn_item_suggest_id = []
        }else if(user && user.length && user[0].full_name === item) {
          // click hint
          console.log('search 2 if');
          this.clickhintWork(item)
          this.pawnItemStatus = false
          this.pawn_item_suggest_id = []
        }
        else if(pawn_user_items && user && ( pawn_user_items.length || user.length ) ) {
          // pim
          let output = {}
          let pawn_no_list = []
          this.pawn_item_suggest_id = []
          this.tmpPawnItem = pawn_user_items
          this.tmpUser = user

          console.log('search 3 if');
          for (let i = 0; i < this.tmpPawnItem.length; i++) {
            if (this.tmpPawnItem[i].pawn_no === item ||  this.tmpPawnItem[i].identity_card_id === item) {
              this.clickhintWork(item)
              this.pawnItemStatus = false
              this.pawn_item_suggest_id = []
            }
          }
          for (let i = 0; i < this.tmpUser.length; i++) {
            if (this.tmpUser[i].full_name === item) {
              this.clickhintWork(item)
              this.pawnItemStatus = false
              this.pawn_item_suggest_id = []
            }
          }
          pawn_user_items.forEach( ele => {
            if (ele.pawn_no && ele.pawn_no.match(item)) {
              this.pawn_item_suggest_id.push(ele.pawn_no)
              this.$set(output, ele.pawn_id, ele.pawn_no)
            }else if (ele.identity_card_id && ele.identity_card_id.match(item)) {
              this.pawn_item_suggest_id.push(ele.identity_card_id)
              this.$set(output, ele.pawn_id, ele.pawn_no)
            }
          });

          user.forEach( ele => {
            if (ele.full_name && ele.full_name.match(item)) {
              this.pawn_item_suggest_id.push(ele.full_name)
              this.$set(output, ele.pawn_id, ele.pawn_no)
            }
          });

        }
      }else {
        this.pawn_item_suggest_id = []
      }

      this.pawn_item_suggest_id = [ ...new Set(this.pawn_item_suggest_id) ]
    },
    async updateFormNumber(text) {
      console.log('updateFormNumber');
      let status = true
      let pawnItem = []
      this.numberSearch = text
      this.search(text)
    },
    async clickhintWork(item) {
      console.log('setup',item);
      let pawnItem = this.tmpPawnItem
      let user = this.tmpUser
      this.pawn_item_suggest_id = []

      console.log('setup in if',item);

      for (let i = 0; i < user.length; i++) {
        console.log('setup if for 1',item);
        if (user[i].full_name === item) {
          console.log('= full name');
          this.active_user = {
            first_name : user[i].first_name,
            last_name : user[i].last_name,
            note : user[i].note,
          }
          this.pushPawnList(item)
          break
        }
      }

      for (let i = 0; i < pawnItem.length; i++) {
        console.log('setup if for 2',item);
        if (pawnItem[i].pawn_no === item ||  pawnItem[i].identity_card_id === item) {
          console.log('= pawn');
          this.active_user = {
            first_name : pawnItem[i].first_name,
            last_name : pawnItem[i].last_name
          }
          this.pushPawnList(item)
          break
        }
      }
      // this.emitList(output)
    },
    async pushPawnList(item) {

      console.log('pushPawnList');
      let first_last = item.split(" ")
      let output = {}
      let pawnItem
      if (first_last.length>1) {
        for (let i = 0; i < this.tmpUser.length; i++) {
          if (this.tmpUser[i].full_name === item) {
            let user = await window.api.get("pawn_user_items", {
            params: {
              search: 
                {
                  keyword: this.tmpUser[i].id,
                  fields:['customer_id']
                }
              }
            });
            pawnItem = user.data.pawn_items
            console.log('user',pawnItem);
          }
          
        }
        if (pawnItem && pawnItem.length) {
          pawnItem.forEach( item => {
            this.$set(output, item.pawn_id, item.pawn_no)
          });
        }
      }else {
        let pawnItem = await this.getPawnUserItem(item)
        if (pawnItem && pawnItem.length) {
          pawnItem.forEach( item => {
            this.$set(output, item.pawn_id, item.pawn_no)
          });
        }
      }
      this.numberSearch = ""
      this.emitList(output)
      this.tmpPawnItem = []
      this.tmpUser = []
      this.pawn_item_suggest_id = []
    },
    emitList(list) {
        console.log('emit');
      
        this.$emit('listPawn',list)
    },
    async getPawnUserItem (item) {
      let pawn_user_items = await window.api.get("pawn_user_items", {
        params: {
          search: 
            {
              keyword: item,
              fields:['pawn_no','identity_card_id']
            }
          }
        });
      return pawn_user_items.data.pawn_items
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
.cus-text{
  min-height: 40px;
  height: auto;
}
.active{
  background-color: rgb(148, 148, 148);
}
</style>
