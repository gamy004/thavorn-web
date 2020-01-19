<template>
  <div>
    <div class="h-flex-col-s-flex-row">

        <div class="col-12 col-lg-4 m-0 m-lg-2 p-0">
            <div class="sec-form">
                <div class="head-form">ประเภทของทอง</div>
                
                <select class="form-control">
                    <option value="asd">asd</option>
                    <option value="a151sd">151</option>
                </select>
            </div>

            <div class="sec-form">
                <div class="head-form">น้ำหนักทอง</div>

                <div class="flex-row">
                    <input type="text" class="form-control" v-model="inputGoldWidth">
                    <span class="item-flex-center ml-1">กรัม</span>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">มูลค่าทอง</div>

                <div class="flex-row">
                    <input type="text" class="form-control" v-model="goldPrice">
                    <span class="item-flex-center ml-1">บาท</span>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">ความเสียหาย</div>
                    <div class="flex-column">
                    <div class="form-check mr-3">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="sexRadios1" value="hasDamage" v-model="inputDamage" >
                        <label class="form-check-label" for="exampleRadios1">
                        ไม่เสียหาย
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="sexRadios2" value="noDamage"  v-model="inputDamage" checked>
                        <label class="form-check-label" for="exampleRadios2">
                        เสียหาย
                        </label>
                    </div>
                </div>
            </div>

            <div class="sec-form">
                <button class=" btn btn-primary">อัพเดทตาราง</button>
            </div>

        </div>

        <div class="col-lg-8 col-12 mt-5 p-0 m-lg-2">
            <div class="w-100 border-cus border-radius-cus">
                <div class="flex-row w-100 flex-cus pt-20 pb-20 bg-primary text-white">
                    <div>ประเภททอง</div>
                    <div>น้ำหนัก(กรัม)</div>
                    <div>มูลค่า(บาท)</div>
                    <div>ความเสียหาย</div>
                </div>
                <div v-for="item in tableData" :key="item.type" class="flex-row w-100 flex-cus hover-table pt-10 pb-10 border-radius-cus">
                    <div>{{item.type}}</div>
                    <div>{{item.width}}</div>
                    <div>{{item.price}}</div>
                    <div>{{item.damage}}</div>
                </div>
            </div>
        </div>

    </div>
    
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'goldForm',
  data() {
    return {
        tableData : [
            {
                type: 'asd',
                width: '100',
                price: '1500',
                damage: 'yes'
            },
            {
                type: 'asd',
                width: '100',
                price: '1500',
                damage: 'yes'
            }
        ],
        inputDamage: 'noDamage',
        inputGoldWidth: '',
        goldPrice: '',

    }
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
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
  flex-grow: 1;
}
.border-cus{
    border: rgba(0,0,0,0.2) solid 1px;
}
.border-radius-cus{
    border-radius: 5px;
}
</style>
