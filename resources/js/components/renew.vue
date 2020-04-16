<template>
  <div>
    <section class="card">
        <h2>ข้อมูลการจำนำ</h2>
        <search @listPawn="updateData" />
        
        <div class="h-flex-col-s-flex-row mt-5">

          <div class="col-12 col-lg-6 m-0 m-lg-2 p-0">
            <div class="form-group">
              <label>เลที่บัตรจำนำ</label>
              <select class="width-max" v-model="pawn_no">
                <option v-for="id in idList" :key="id" v-text="id"></option>
              </select>
            </div>
            <show-data-renew :pawnItem="pawnData" />
            

          </div>
          
          <div class="col-lg-6 col-12 mt-5 p-0 m-lg-2">
            <show-item class="mt-4" :pawnItem="pawnData" />
          </div>

        </div>

    </section>
  </div>
</template>

<script>
import Vue from 'vue';
import search from './form/searchForPawn.vue'
import showItem from './form/showPwanItem.vue'
import showDataRenew from './form/showDataRenew.vue'

export default Vue.extend({
  name: 'redeem',
  components:{
    search,
    showItem,
    showDataRenew
  },
  data() {
    return {
      idList:[],
      pawn_no: "",
      pawnData: []
    }
  },
  methods: {
    updateData(list) {
      if (list && list.length) {
        this.idList = list
        this.pawn_no =list[0]
        this.getPawnData(this.pawn_no)
      }
    },
    async getPawnData(pawn_no) {
      let res = await window.api.get("pawn_user_items", {
        params: {
          search: {
            keyword: pawn_no,
            fields:['pawn_no']
          }
        }
      });
      this.pawnData = res.data.pawn_items
    }
  },
  watch: {
    pawn_no: {
      handler(pawn_no) {
        if (pawn_no) {
          this.getPawnData(pawn_no)
        }
      }
    }
  },


});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.h-flex-row-s-flex-col{
  display: flex;
  flex-flow: row;
  @media(max-width: 991px){
    flex-flow:  column;
  }
}
.width-max{
  width: 100%;
}
</style>
