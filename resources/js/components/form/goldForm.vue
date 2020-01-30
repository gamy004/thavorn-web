<template>
  <div>
    <div class="h-flex-col-s-flex-row">

        <div class="col-12 col-lg-4 m-0 m-lg-2 p-0">
            <div class="sec-form">
                <div class="head-form">ประเภทของทอง</div>
                
                <select class="form-control" v-model="item_category_id">
                    <option value="1" key="asd">asd</option>
                    <option value="2" key="a151sd">151</option>
                </select>
            </div>

            <div class="sec-form">
                <div class="head-form">น้ำหนักทอง</div>

                <div class="flex-row">
                    <input type="text" class="form-control" v-model="item_weight">
                    <span class="item-flex-center ml-1">กรัม</span>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">มูลค่าทอง</div>

                <div class="flex-row">
                    <input type="number" class="form-control" v-model="item_value">
                    <span class="item-flex-center ml-1">บาท</span>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">ความเสียหาย</div>
                    <div class="flex-column">
                    <div class="form-check mr-3" @click="updateDamage('hasDamage')">
                        <input class="form-check-input " type="radio" name="exampleRadios" id="sexRadios1" value="0" v-model="item_damage_id" >
                        <label class="form-check-label" for="exampleRadios1">
                        ไม่เสียหาย
                        </label>
                    </div>
                    <div class="form-check" @click="updateDamage('noDamage')">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="sexRadios2" value="1"  v-model="item_damage_id" checked>
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
            <div v-if="tableData.length">รวมมูลค่า(บาท)  {{sumPrice}}</div>
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
        item_damage_id: 0,
        item_weight: '',
        item_value: '',
        item_category_id: ''
    }
  },
  computed: {
      sumPrice() {
        let output = 0;
        if(this.tableData && this.tableData.length) {
            this.tableData.forEach( item => {
                output +=  parseInt(item.price)
            });
        }
        return output
      }
  },
  methods: {
    updateDamage(val) {
      this.item_damage_id = val;
    },
    addGold() {
        let obj = {
            type: this.item_category_id,
            width: this.item_weight,
            price: this.item_value,
            damage: this.item_damage_id,
        }
        this.tableData.push(obj)
    },
    removeIndex(index) {
        this.tableData.splice(index,1);
    },
    exchangeIdToDamageValue(id) {
        for (let i = 0; i < this.damage.length; i++) {
            if (this.damage[i].id === id) {
                return this.damage[i].item_damage
            }
        }
        return 'Error'
    }
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
