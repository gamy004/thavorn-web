<template>
  <div>
    <div class="h-flex-col-s-flex-row">

        <div class="col-12 col-lg-4 m-0 m-lg-2 p-0">
            <div class="sec-form">
                <div class="head-form">ประเภทของทอง</div>
                
                <select class="form-control" v-model="activeGlodData.item_category_id">
                    <option v-for="item in category_item" :key="item.id" :value="item.id" v-text="item.item_category"></option>
                </select>
            </div>

            <div class="sec-form">
                <div class="head-form">น้ำหนักทอง</div>

                <div class="flex-row">
                    <input type="text" class="form-control" v-model="activeGlodData.item_weight">
                    <span class="item-flex-center ml-1">กรัม</span>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">มูลค่าทอง</div>

                <div class="flex-row">
                    <input type="number" class="form-control" v-model="activeGlodData.item_value">
                    <span class="item-flex-center ml-1">บาท</span>
                </div>
            </div>

            <div class="sec-form">
                <div class="head-form">ความเสียหาย</div>
                    <div class="flex-column">
                    <div class="form-check mr-3" v-if="damage_item" v-for="item in damage_item" :key="item.id" @click="updateDamage(item.id)">
                        <input class="form-check-input " type="radio" :name="item.item_damage" :id="item.id" :value="item.id" v-model="activeGlodData.item_damage_id" >
                        <label class="form-check-label" :for="item.item_damage">
                        {{item.item_damage}}
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
                    <tr v-for="(item, index) in tableData" 
                    :key="index" 
                    v-bind:class="[editIndex === index ? 'activeClass' : 'notSelect']" 
                    @click="getToForm(item,index)">
                        <td>{{calCatetory(item.item_category_id)}}</td>
                        <td>{{item.item_weight}}</td>
                        <td>{{item.item_value}}</td>
                        <td>{{calDamage(item.item_damage_id)}}</td>
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
        activeGlodData: {
            id: null,
            item_category_id: null,
            item_weight: null,
            item_value: null,
            item_damage_id: 1,
        },
        editIndex : null,
        category_item : [],
        damage_item: [],
        sumPrice: 0
    }
  },
  props: {
    data: {
        type: Array,
        defult: []
    },
  },
  watch: {
    data: {
      handler(data) {
        this.tableData = data
      }
    },
    tableData: {
        deep: true,
        handler(tableData) {
            this.calPrice()
        }
    }
  },
  mounted() {
      this.getCategoryItem()
      this.getItemDamage()
  },
  computed: {

  },
  methods: {
    calCatetory(id) {
        if (this.category_item) {
            let cat = this.category_item
            let output = ""
            for (let i = 0; i < cat.length; i++) {
                if (cat[i].id === id) {
                    output = cat[i].item_category
                    break;
                }
            }
            return output
        }
    },
    calDamage(id) {
        console.log('in',id,this.damage_item);
        
        if (this.damage_item) {
            let dam = this.damage_item
            let output = ""
            for (let i = 0; i < dam.length; i++) {
                if (dam[i].id === id) {
                    output = dam[i].item_damage
                    break;
                }
            }
            return output
        }
    },
    calPrice() {
        let output = 0;
        if(this.tableData && this.tableData.length) {
            this.tableData.forEach( item => {
                output +=  parseInt(item.item_value)
            });
        }
        this.sumPrice = output
    },
    async getItemDamage() {
        let res = await window.api.get(`item_damages`)
        this.damage_item = res.data.item_damages
    },
    async getCategoryItem() {
        let res = await window.api.get(`item_categories`)
        this.category_item = res.data.item_categories
    },
    updateDamage(val) {
      this.activeGlodData.item_damage_id = val;
    },
    async addGold() {
        if (this.editIndex === null) {
            this.tableData.push(this.activeGlodData)
            this.clearForm()
            this.$emit('emit:gold', this.tableData)
        }else{
            this.tableData[this.editIndex] = this.activeGlodData
            if (this.activeGlodData.id) {
                //Update DB pawn
                window.api.patch(`pawn_items/${this.activeGlodData.id}`, {
                    item_category_id : this.activeGlodData.item_category_id,
                    item_weight : this.activeGlodData.item_weight,
                    item_value : this.activeGlodData.item_value,
                    item_damage_id : this.activeGlodData.item_damage_id,
                });
            }
            this.clearForm()
            this.calPrice()
        }
    },
    clearForm() {
        this.activeGlodData = {
            id: null,
            item_category_id: null,
            item_weight: null,
            item_value: null,
            item_damage_id: 1,
        }
        this.editIndex = null
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
    },
    getToForm(data,index) {
        this.editIndex = index
        this.activeGlodData.id = data.id
        this.activeGlodData.item_category_id = data.item_category_id
        this.activeGlodData.item_weight = data.item_weight
        this.activeGlodData.item_value = data.item_value
        this.activeGlodData.item_damage_id = data.item_damage_id
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
.activeClass{
    background-color: rgb(255, 156, 156) !important;
    &:hover{
        background-color: rgb(255, 125, 125) !important;
    }
}
</style>
