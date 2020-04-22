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
                <div class="head-form">จำนวนทเดือนที่จะต่อดอก</div>

                <div class="flex-row">
                    <input class="form-control mr-28-px" type="number" min="" v-model="mouthCount">
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
  name: 'CommitRenew',
  data() {
    return {
        createDate: "",
        lastUpdate: "",
        sumPriceStart: 0,
        interest_rate: 0,
        mouthCount: 1,
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
          return  ((parseInt(this.sumPriceStart)*parseInt(this.interest_rate))/100)*parseInt(this.mouthCount)
      }
  },
  methods: {
    async reload() {
        let count = parseInt(this.mouthCount)
        let output = this.calDate(count)
        console.log(output);
        
        await window.api.patch(`pawns/${this.pawn_id}`,{
            updated_at: output
        });
        location.reload();
    },
    calDate(count) {
        let set = moment(this.lastUpdate, 'DD/MM/YYYY').format('YYYY-MM-DD h:mm:ss')
        let d = parseInt(set.substring(8,10))
        let m =  parseInt(set.substring(5,7))
        let y =  parseInt(set.substring(0,4))
        let time =  set.substring(11,19)


        m = m+count
        if (m > 12) {
            let upyear = Math.floor(m/12)
            y = y+upyear
            m = m%12
        }
        if ( m === 2 && d > 28) {
            d = 28
        }else if( d > 31 && ( m === 1 || m === 3 || m === 5 || m === 7 || m === 8 || m === 10 || m === 12 ) ) {
            d = 31
        }else if( d > 30 && ( m === 4 || m === 6 || m === 9 || m === 11 )) {
            d = 30
        }

        let output = `${y}-${m}-${d} ${time}`
        console.log(set,m,d,y,' ',time,output);
        return output
    }
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
