<template>
  <div>
    <div class="h-flex-col-s-flex-row">
        <div class="col-lg-9 col-12 m-0 m-lg-2 p-0">
            <div class="sec-form">
                <div class="head-form">เงินต้น</div>

                <div class="flex-row">
                    <div type="text" class="form-control gray" v-text="sumPriceStart"></div>
                    <span class="item-flex-center ml-1">บาท</span>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">วันที่มาจำนำ</div>

                <div class="flex-row">
                    <div type="text" class="form-control mr-28-px gray" v-text="createDate"></div>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">วันที่ต่อดอกล่าสุด</div>

                <div class="flex-row">
                    <div type="text" class="form-control mr-28-px gray" v-text="lastUpdate"></div>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">จำนวนเดือนที่จะต่อดอก</div>

                <div class="flex-row">
                    <input class="form-control mr-28-px" type="number" min="1" @keyup="checklimitword" v-model="mouthCount">
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">Total</div>

                <div class="flex-row">
                    <div type="text" class="form-control show-total gray" v-text="total"></div>
                    <span class="item-flex-center ml-1">บาท</span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-12 mt-5 p-0 m-lg-2">
            <div class="sec-form">
                <div class="head-form">ดอกเบี้ย(%)</div>
                <div class="flex-row">
                    <div type="text" class="form-control gray" v-text="interest_rate"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="item-flex-start ml-1">
        <button type="button" class="btn btn-primary btn-lg mt-3" @click="reload" v-if="status_complete === 0" >ชำระเงิน</button>
        <button type="button" class="btn btn-primary btn-lg mt-3 btn-gray"  v-else-if="status_complete === 1" >ไถ่ถอนเรียบร้อย</button>
    </div>
    <error ref="error" />
  </div>
</template>

<script>
import Vue from 'vue';
import moment from 'moment'
import { log } from 'util';
import error from '../popup/error.vue'

export default Vue.extend({
  name: 'CommitRenew',
  components:{
      error
  },
  data() {
    return {
        createDate: "",
        lastUpdate: "",
        sumPriceStart: 0,
        interest_rate: 0,
        mouthCount: 1,
        pawn_id: "",
        status_complete: 0
    }
  },
  props: {
    pawnItem: {
        type: Array,
        defult: []
    },
  },
  watch: {
      pawnItem: {
          async handler(pawnItem) {
              if (pawnItem && pawnItem.length) {
                    //interset_rate
                    this.status_complete = pawnItem[0].complete
                    let res = await window.api.get(`pawns/${pawnItem[0].pawn_id}`);
                    this.pawn_id = res.data.pawns.id
                    this.interest_rate = res.data.pawns.interest_rate 
                    //Date
                    let createDate =new Date(res.data.pawns.created_at)
                    let lastDate = new Date()
                    res.data.pawns.next_paid_at 
                        ? lastDate = new Date(res.data.pawns.next_paid_at)
                        : lastDate = new Date(res.data.pawns.created_at)
                    this.createDate = moment(createDate, 'DD/MM/YYYY').format('DD/MM/YYYY')
                    this.lastUpdate = moment(lastDate, 'DD/MM/YYYY').format('DD/MM/YYYY')
                    //start price
                    this.sumPriceStart = 0
                    pawnItem.forEach( item => {
                        this.sumPriceStart += parseFloat(item.item_value)
                    });
              }
          }
      },

  },
  mounted() {

  },
  computed: {
      total() {
          let out = ((parseFloat(this.sumPriceStart)*parseFloat(this.interest_rate))/100)*parseFloat(this.mouthCount)
          return out.toFixed(2)
      }
  },
  methods: {
    async reload() {
        try {
            await window.api.post(`pawns/${this.pawn_id}/pay`,{
                amount : this.total,
                month_amount : this.mouthCount
            })
            this.$refs.error.setShowPop(1,'Data has been updated.')
        } catch (error) {
            this.$refs.error.setShowPop(1,'ERROR')
        }

        // await window.api.post(`pawns/${this.pawn_id}/pay`,{
        //     amount : this.total,
        //     month_amount : this.mouthCount
        // }).catch(
        //     this.$refs.error.setShowPop(1,'ERROR')
        // ).then(() => {
        //     this.$refs.error.setShowPop(1,'Data has been updated.')
        // })

    },
    checklimitword() {
      if (this.mouthCount.length === 0 || this.mouthCount.length === undefined) {
        this.mouthCount = ""
      }
      else if (this.mouthCount < 1) {
        this.mouthCount = 1
      }
    },
  }
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.mr-28-px {
    margin-right: 28px;
}
.show-total{
    height: 60px;
    text-align: center;
    padding: 15px !important;
}
.gray {
    background-color: rgb(221, 221, 221);
}
.btn-gray {
    background-color: rgb(221, 221, 221);
    border: 0;
    color: black;
}
</style>
