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
                <div class="head-form">วันที่ไถ่ถอน</div>

                <div class="flex-row">
                    <div type="text" class="form-control mr-28-px gray" v-text="today"></div>
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
    <div class="cus">
        <button type="button" class="btn btn-primary btn-lg mt-3" @click="reload">ชำระเงิน</button>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import moment from 'moment'
import { log } from 'util';

export default Vue.extend({
  name: 'CommitRedeem',
  data() {
    return {
        createDate: "",
        lastUpdate: "",
        sumPriceStart: 0,
        interest_rate: 0,
        pawn_id: ""
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
                    let res = await window.api.get(`pawns/${pawnItem[0].pawn_id}`);
                    this.pawn_id = res.data.pawns.id
                    this.interest_rate = res.data.pawns.interest_rate 
                    //Date
                    let createDate =new Date(res.data.pawns.created_at)
                    let lastDate =new Date(res.data.pawns.updated_at)
                    this.createDate = moment(createDate, 'DD/MM/YYYY').format('DD/MM/YYYY')
                    this.lastUpdate = moment(lastDate, 'DD/MM/YYYY').format('DD/MM/YYYY')
                    //start price
                    this.sumPriceStart = 0
                    pawnItem.forEach( item => {
                        this.sumPriceStart += parseInt(item.item_value)
                    });
              }
          }
      },

  },
  mounted() {

  },
  computed: {
      total() {
          let ld = parseInt(this.lastUpdate.substring(0,2))
          let lm = parseInt(this.lastUpdate.substring(3,5))
          let ly = parseInt(this.lastUpdate.substring(6,11))

          let td = parseInt(this.today.substring(0,2))
          let tm = parseInt(this.today.substring(3,5))
          let ty = parseInt(this.today.substring(6,11))

          let dd = td - ld
          let dm = tm - lm
          let dy = ty - ly

          if (dy === 0) {
            if ( dm > 0 ) {
                let base = ((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)*dm
                if ( dd > 0) {
                    if ( dd <= 15 ) {
                        return parseInt(this.sumPriceStart)+base+(((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)/2)
                    }else {
                        return parseInt(this.sumPriceStart)+base+((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)
                    }
                }else if ( dd <= 0) {
                    dd += 30
                    base = ((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)*(dm-1)
                    if ( dd <= 15 ) {
                        return parseInt(this.sumPriceStart)+base+(((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)/2)
                    }else {
                        return parseInt(this.sumPriceStart)+base+((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)
                    }
                }else {
                    return 'error'
                }
            }else if ( dm === 0 ) {
                if ( dd > 0) {
                    if ( dd <= 15 ) {
                        return parseInt(this.sumPriceStart)+((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)/2
                    }else {
                        return parseInt(this.sumPriceStart)+(parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100
                    }
                }else if ( dd <= 0) {
                    return 0
                }
            }else if ( dm < 0 ) {
                return 0
            }
          }else if ( dy > 0 ) {
            dm += dy*12
            let base = ((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)*dm
            if ( dd > 0) {
                if ( dd <= 15 ) {
                    return parseInt(this.sumPriceStart)+base+(((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)/2)
                }else {
                    return parseInt(this.sumPriceStart)+base+((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)
                }
            }else if ( dd <= 0) {
                dd += 30
                base = ((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)*(dm-1)
                if ( dd <= 15 ) {
                    return parseInt(this.sumPriceStart)+base+(((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)/2)
                }else {
                    return parseInt(this.sumPriceStart)+base+((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)
                }
            }else {
                return 'error'
            }
          }else if ( dy < 0 ) {
              return 0
          }
          return  'error'
      },
      today() {
          const today = moment();
          let output = moment(today, 'DD/MM/YYYY').format('DD/MM/YYYY')
          return output
      }
  },
  methods: {
    async reload() {
        await window.api.delete(`pawns/${this.pawn_id}`);
        location.reload();
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
.cus{
    display: flex;
    justify-content: center;
}
</style>
