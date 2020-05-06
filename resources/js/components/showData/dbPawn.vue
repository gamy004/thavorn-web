<template>
  <div>
      <div class="tap-bar min-width-1440" @click="updateshow('showOverPawnData')">ภาพรวมการจำนำ</div>
      <div v-if="showOverPawnData" class="flex-column mt-3 mb-3">

          <div class="flex-row">
            <div class="flex-row col-3 item-flex-start">
                <div class="bold">บัตรจำนำทั้งหมด :</div>
                <div class="ml-2">{{count_pawn_card}}</div>
            </div>
            <div class="flex-row col-3 item-flex-start">
                <div class="bold">จำนวนของจำนำทั้งหมด :</div>
                <div class="ml-2">{{count_pawn_item}}</div>
            </div>
            <div class="flex-row col-3 item-flex-start">
                <div class="bold">มูลค่าการจำนำทั้งหมด :</div>
                <div class="ml-2">{{sumAll.toLocaleString()}}</div>
            </div>
          </div>

          <div class="flex-row">

            <div class="flex-row col-3 item-flex-start">
                <div class="bold">บัตรจำนำที่ไถ่ถอนแล้ว :</div>
                <div class="ml-2">{{countCom}}</div>
            </div>
            <div class="flex-row col-3 item-flex-start">
                <div class="bold">มูลค่าการจำนำที่ไถ่ถอนแล้ว :</div>
                <div class="ml-2">{{sumCom.toLocaleString()}}</div>
            </div>

          </div>
          <div class="flex-row">

            <div class="flex-row col-3 item-flex-start">
                <div class="bold">บัตรจำนำที่ยังไม่ไถ่ถอน :</div>
                <div class="ml-2">{{countActive}}</div>
            </div>
            <div class="flex-row col-3 item-flex-start">
                <div class="bold">มูลค่าการจำนำที่ยังไม่ไถ่ถอน :</div>
                <div class="ml-2">{{sumActive.toLocaleString()}}</div>
            </div>

          </div>
      </div>
      <div class="tap-bar min-width-1440" @click="updateshow('showPawnData')">ข้อมูลการจำนำ</div>
      <div v-if="showPawnData">
          <show-pawn-data @pushData="updateData" />
      </div>
  </div>
</template>

<script>
import Vue from 'vue';
import showUserData from './showUserData'
import showPawnData from './showPawnData'
import moment from 'moment'

export default Vue.extend({
    name: 'db',
    components:{
        showUserData,
        showPawnData
    },
    data() {
        return {
            showPawnData: 1,
            showOverPawnData: 1,
            pawn:[],
            pawn_item:[],
            sumAll:0,
            sumActive:0,
            sumCom:0,
            count_pawn_item:0,
            count_pawn_card:0,
            tableData:[],
            countCom:0,
            countActive:0,
        }
    },
    methods: {
        updateshow(type) {
            if (type === 'showPawnData') {
                this.showPawnData = !this.showPawnData
            }else if(type === 'showOverPawnData') {
                this.showOverPawnData = !this.showOverPawnData
            }
        },
        async updateData(pawn,pawn_item) {
            this.pawn = pawn
            this.pawn_item = pawn_item
            await this.matchData()
            await this.sum()
        },
        sum() {
            this.sumAll = 0
            this.sumActive = 0
            this.sumCom = 0
            this.count_pawn_card = 0
            this.count_pawn_item=  this.pawn_item.length
            this.pawn_item.forEach( ele => {
                console.log('zzz',ele.item_value);
                if (ele.item_value) {
                    let tmp = parseFloat(ele.item_value)
                    this.sumAll += tmp
                    if(ele.complete === 1) {
                        this.sumCom += tmp
                    }else if (ele.complete === 0) {
                        this.sumActive += tmp
                    }
                }
            });
            this.countCom = 0
            this.countActive = 0
            this.tableData.forEach(ele => {
                if (ele.pawn_item.length) {
                    this.count_pawn_card++
                    if (ele.complete === 1) {
                        this.countCom++
                    }else if (ele.complete === 0) {
                        this.countActive++
                    }
                }
            });

        },
        matchData() {
            this.tableData = []
            const pawn = this.pawn
            const pawn_item = this.pawn_item
            for (let i = 0; i < pawn.length; i++) {
                let tmp = {
                    pawn_no: pawn[i].pawn_no,
                    complete: pawn[i].complete,
                    created_at : this.calCreated_at(pawn[i].created_at),
                    next_paid_at : this.calNext_paid_at(pawn[i].next_paid_at, pawn[i].created_at),
                    latest_paid_at: this.calLatest_paid_at(pawn[i].latest_paid_at, pawn[i].created_at),
                    pawn_item: []
                }
                for (let j = 0; j < pawn_item.length; j++) {
                    if (tmp.pawn_no === pawn_item[j].pawn_no) {     
                        tmp.pawn_item.push(pawn_item[j])
                    }
                }
                this.tableData.push(tmp)
            }
        },
        calCreated_at(created_at) {
            const createDate =new Date(created_at)
            return moment(createDate, 'DD/MM/YYYY').format('DD/MM/YYYY')
        },
        calNext_paid_at(next_paid_at, created_at) {
            if (next_paid_at) {
                const paid_at =new Date(next_paid_at)
                return moment(paid_at, 'DD/MM/YYYY').format('DD/MM/YYYY')
            }else {
                const createDate =new Date(created_at)
                return moment(createDate, 'DD/MM/YYYY').format('DD/MM/YYYY')
            }
        },
        calLatest_paid_at(latest_paid_at, created_at) {
            if (latest_paid_at) {
                const latest_at =new Date(latest_paid_at)
                return moment(latest_at, 'DD/MM/YYYY').format('DD/MM/YYYY')
            }else {
                const createDate =new Date(created_at)
                return moment(createDate, 'DD/MM/YYYY').format('DD/MM/YYYY')
            }
        },
    },
    computed: {
        
    },
    watch: {
    },


});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.tap-bar {
    display: flex;
    justify-content: center;
    padding: 20px 0;
    background-color: #3490dc;
    color: white;
    border-bottom: 0.5px solid #237cc5;
    border-top: 0.5px solid #237cc5;
    font-size: 20px;
}
</style>
