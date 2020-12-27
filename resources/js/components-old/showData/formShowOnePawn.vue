<template>
  <div v-if="pawn && pawn_item" class="min-width-1440">
    <div>
        <section class="flex-row bg-primary text-white border-top border-button">
            <div class="w-10 ptb-5 border-right item-flex-all-center">เลขที่บัตรจำนำ</div>
            <div class="w-10 ptb-5 border-right item-flex-all-center">ชื่อ</div>
            <div class="w-10 ptb-5 border-right item-flex-all-center">นามสกุล</div>
            <div class="flex-column w-40 border-right">
                <div class="w-100 ptb-5 border-bottom item-flex-all-center">ข้อมูลทอง</div>
                <div class="flex-row">
                    <div class="w-25 ptb-5 item-flex-all-center border-right">ประเภททอง</div>
                    <div class="w-25 ptb-5 item-flex-all-center border-right">น้ำหนัก(กรัม)</div>
                    <div class="w-25 ptb-5 item-flex-all-center border-right">มูลค่า(บาท)</div>
                    <div class="w-25 ptb-5 item-flex-all-center">ความเสียหาย</div>
                </div>
            </div>
            <div class="w-10 ptb-5 border-right item-flex-all-center">ยอดรวม</div>
            <div class="w-10 ptb-5 border-right item-flex-all-center">ต่อดอกล่าสุด</div>
            <div class="w-10 ptb-5 border-right item-flex-all-center">วันที่มาล่าสุด</div>
            <div class="w-10 ptb-5 item-flex-all-center">สถานะบัตร</div>
        </section>
        <div class="pawn-list">
            <section 
            v-if="pawn.pawn_item && pawn.pawn_item.length" 
            v-for="pawn in tableData" 
            :key="pawn.pawn_no" 
            class="flex-row border-button-cus">

                <div class="w-10 ptb-5 border-right item-flex" v-text="pawn.pawn_no"></div>

                <div class="w-10 ptb-5 border-right item-flex" 
                v-if="pawn.pawn_item && pawn.pawn_item.length" v-text="pawn.pawn_item[0].first_name">
                </div>

                <div class="w-10 ptb-5 border-right" v-else></div>

                <div class="w-10 ptb-5 border-right item-flex" 
                v-if="pawn.pawn_item && pawn.pawn_item.length" v-text="pawn.pawn_item[0].last_name">
                </div>

                <div class="w-10 ptb-5 border-right" v-else></div>

                <div class="flex-column w-40 border-right">
                    <div class="flex-row h-100" v-for="pawn_item in pawn.pawn_item">
                        <div class="w-25 item-flex-start ptb-5 border-right plr" v-text="pawn_item.item_category"></div>
                        <div class="w-25 item-flex-end ptb-5 border-right plr" v-text="parseFloat(pawn_item.item_weight).toLocaleString()"></div>
                        <div class="w-25 item-flex-end ptb-5 border-right plr" v-text="parseFloat(pawn_item.item_value).toLocaleString()"></div>
                        <div class="w-25 item-flex-start ptb-5 plr" v-text="pawn_item.item_damage"></div>
                    </div>
                </div>

                <div class="w-10 ptb-5 border-right item-flex-end plr" v-text="calValue(pawn.pawn_item)"></div>

                <div class="w-10 item-flex-center ptb-5 border-right" 
                v-text="pawn.next_paid_at">
                </div>

                <div class="w-10 item-flex-center ptb-5 border-right" 
                v-text="pawn.latest_paid_at">
                </div>

                <div class="w-10 ptb-5 item-flex-center" 
                v-text="calStatusCard(pawn.complete)">
                </div>

            </section>
        </div>

        
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import showPwanItem from '../form/showPwanItem';
import moment from 'moment'

export default Vue.extend({
    name: 'onepawn',
    components:{
        showPwanItem
    },
    data() {
        return {
            pawn_item:[],
            first_name:"",
            last_name:"",
            tableData: []
        }
    },
    props:{
        pawn: {
            type: Array,
            default: []
        },
        allPawnItem: {
            type: Array,
            default: []
        },
    },
    watch: {
        allPawnItem: {
            immediate: true,
            handler(allPawnItem) {
                if (allPawnItem && this.pawn) {
                    this.matchData()
                }
            }
        },
        pawn: {
            immediate: true,
            handler(pawn) {
                if (pawn && this.allPawnItem) {
                    this.matchData()
                }
            }
        },
    },
    methods: {
        matchData() {
            this.tableData = []
            const pawn = this.pawn
            const pawn_item = this.allPawnItem
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
        calStatusCard(val) {
            if (val) {
                return "Completed"
            }else {
                return "Active"
            }
        },
        calValue(pawn_item) {
            let out = 0
            pawn_item.forEach(ele => {
                out += parseFloat(ele.item_value)
            });
            out = out.toFixed(2)
            out = parseFloat(out).toLocaleString()
            return out
        }
    },
    computed: {

    },

    mounted() {
    },


});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
section {
    display: flex;
    flex-flow: column;
}
.margin-cus{
    margin-top: 18px;
}
.flex-cus{
    justify-content: space-around;
}
.h-flex-row-s-flex-col{
  display: flex;
  flex-flow: row;
  @media(max-width: 991px){
    flex-flow:  column;
  }
}
.grow-1{
  display: flex;
  flex-grow: 1;
}
.border-cus{
    border: rgba(0,0,0,0.2) solid 1px;
}
.border-radius-cus{
    border-radius: 5px;
}

.pawn-list > section:nth-child(even){background-color: #f2f2f2;}
.pawn-list > section:hover {background-color: #ddd;}



.border-button-cus{
    border-bottom: 1px solid #dee2e6;
}
.plr {
    padding: 5px 1.5vw;
}

</style>
