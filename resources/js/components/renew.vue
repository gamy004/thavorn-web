<template>
  <div>
    <section class="card">
      <h2>ข้อมูลการจำนำ</h2>
      <search @listPawn="updateData" />

      <div class="h-flex-col-s-flex-row mt-5">
        <div class="col-12 col-lg-6 m-0 m-lg-2 p-0">
          <div class="form-group">
            <label>เลขที่บัตรจำนำ</label>
            <select class="width-max" v-model="pawn_id">
              <option v-for="id in Object.keys(idList) " :key="id" v-text="idList[id]" :value="id"></option>
            </select>
          </div>
          <show-data-renew
            :pawn_id="pawn_id"
            :pawnItem="pawnData"
            @emitmouthCount="updatemouthCount"
          />
        </div>

        <div class="col-lg-6 col-12 mt-5 p-0 m-lg-2">
          <show-payments :pawn_id="pawn_id" />
          <show-item class="mt-4" :pawnItem="pawnData" />
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Vue from "vue";
import search from "./form/searchForPawn.vue";
import showItem from "./form/showPwanItem.vue";
import showDataRenew from "./form/showDataRenew.vue";
import ShowPayments from "./showData/showPayments.vue";

export default Vue.extend({
  name: "redeem",
  components: {
    search,
    showItem,
    showDataRenew,
    ShowPayments
  },
  data() {
    return {
      idList: {},
      pawn_id: "",
      pawnData: [],
      mouthCount: 1
    };
  },
  methods: {
    updateData(list) {
      if (list && Object.keys(list).length) {
        this.idList = list;
        this.pawn_id = Object.keys(list)[0];
        this.getPawnData(this.pawn_id);
      }
    },
    async getPawnData(pawn_id) {
      let res = await window.api.get(`pawn_user_items`, {
        params: {
          filters: [
            {
              key: "pawn_id",
              value: pawn_id
            }
          ]
        }
      });
      this.pawnData = res.data.pawn_items;
    },
    updatemouthCount(val) {
      this.mouthCount = val;
    }
  },
  watch: {
    pawn_id: {
      handler(pawn_id) {
        if (pawn_id) {
          this.getPawnData(pawn_id);
        }
      }
    }
  }
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.h-flex-row-s-flex-col {
  display: flex;
  flex-flow: row;
  @media (max-width: 991px) {
    flex-flow: column;
  }
}
.width-max {
  width: 100%;
}
</style>
