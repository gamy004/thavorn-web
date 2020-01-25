<template>
  <div>
    <div class="h-flex-col-s-flex-row">

        <div class="col-12 col-lg-4 m-0 m-lg-2 p-0">
            <div class="sec-form">
                <div class="head-form">ประเภทของทอง</div>
                
                <select class="form-control" v-model="inputType">
                    <option value="asd" key="asd">asd</option>
                    <option value="a151sd" key="a151sd">151</option>
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
                    <div class="form-check mr-3" @click="updateDamage('hasDamage')">
                        <input class="form-check-input " type="radio" name="exampleRadios" id="sexRadios1" value="มีตำหนิ" v-model="inputDamage" >
                        <label class="form-check-label" for="exampleRadios1">
                        ไม่เสียหาย
                        </label>
                    </div>
                    <div class="form-check" @click="updateDamage('noDamage')">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="sexRadios2" value="ไม่มีตำหนิ"  v-model="inputDamage" checked>
                        <label class="form-check-label" for="exampleRadios2">
                        เสียหาย
                        </label>
                    </div>
                </div>
            </div>

            <div class="sec-form">
                <button @click="addGold" class=" btn btn-primary">อัพเดทตาราง</button>
            </div>

        </div>
        
        <div class="col-lg-8 col-12 mt-5 p-0 m-lg-2">

            <table>
                <tbody>
                    <tr class="bg-primary text-white">
                        <th>ประเภททอง</th>
                        <th>น้ำหนัก(กรัม)</th>
                        <th>มูลค่า(บาท)</th>
                        <th>ความเสียหาย</th>
                        <th></th>
                    </tr>
                    <tr v-for="(item, index) in tableData" :key="item.type">
                        <td>{{item.type}}</td>
                        <td>{{item.width}}</td>
                        <td>{{item.price}}</td>
                        <td>{{item.damage}}</td>
                        <td @click="removeIndex(index)"> X </td>
                    </tr>
                </tbody>
            </table>
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
        tableData : [],
        inputDamage: 'noDamage',
        inputGoldWidth: '',
        goldPrice: '',
        inputType: ''
    }
  },
  methods: {
    updateDamage(val) {
      this.inputDamage = val;
    },
    addGold() {
        let obj = {
            type: this.inputType,
            width: this.inputGoldWidth,
            price: this.goldPrice,
            damage: this.inputDamage,
        }
        this.tableData.push(obj)
    },
    removeIndex(index) {
        this.tableData.splice(index,1);
    },
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
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

table {
    border-collapse: collapse;
    width: 100%;
    text-align: center;
    border-radius: calc(1px + 0.2vw);
    font-size: calc(9px + 0.5vw);
}

table td, table th {
    padding: 1vw;
}

table tr:nth-child(even){background-color: #f2f2f2;}
table tr:hover {background-color: #ddd;}
table th {
    font-weight: 400;
}
</style>
