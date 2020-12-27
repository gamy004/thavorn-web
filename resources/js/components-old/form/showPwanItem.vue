<template>
  <div>
    <div class="h-flex-col-s-flex-row">
        <table>
            <tbody>
                <tr class="bg-primary text-white">
                    <th>ประเภททอง</th>
                    <th>น้ำหนัก(กรัม)</th>
                    <th>มูลค่า(บาท)</th>
                    <th>ความเสียหาย</th>
                </tr>
                <tr v-for="(item, index) in pawnItem" :key="index" >
                    <td>{{calCatetory(item.item_category_id)}}</td>
                    <td>{{item.item_weight}}</td>
                    <td>{{item.item_value}}</td>
                    <td>{{calDamage(item.item_damage_id)}}</td>
                </tr>
            </tbody>
        </table>

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
        category_item : [],
        damage_item: [],
    }
  },
  props: {
    pawnItem: {
        type: Array,
        defult: []
    },
  },
  watch: {

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
    async getItemDamage() {
        let res = await window.api.get(`item_damages`)
        this.damage_item = res.data.item_damages
    },
    async getCategoryItem() {
        let res = await window.api.get(`item_categories`)
        this.category_item = res.data.item_categories
    },
  }
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
</style>
