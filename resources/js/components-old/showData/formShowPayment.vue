<template>
  <div>
    <div class="h-flex-col-s-flex-row">
        <table>
            <tbody>
                <tr class="bg-primary text-white">
                    <th>มูลค่า</th>
                    <th>จำนวนเดือน</th>
                    <th>เดือน</th>
                    <th>วันที่ชำระ</th>
                </tr>
                <tr v-for="(item, index) in data" :key="index" >
                    <td>{{item.amount}}</td>
                    <td>{{item.month_amount}}</td>
                    <td>{{showMM(item.time_start_at, item.time_end_at, item.month_amount)}}</td>
                    <td>{{setDate(item.created_at)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import moment from 'moment'

export default Vue.extend({
  name: 'paymenttable',

  data() {
    return {

    }
  },
  props:{
    data: {
        type: Array,
        defult: []
    },
  },
  methods: {
    setDate(data) {
      let tmp =new Date(data)
      tmp = moment(tmp, 'DD/MM/YYYY').format('DD/MM/YYYY h:mm:ss a')
      return tmp
    },
    showMM(start, end, month_amount) {
      if (month_amount === 0) {
        return '-'
      }else{
        let data = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
        let dateStart =  parseInt(start.substring(5,8))
        let dateEnd =  parseInt(end.substring(5,8))
        let count = dateEnd-dateStart
        let output = ""
        for (let i = 0; i < count; i++) {
          if (i) {
            output += " | "
          }
          output += data[dateStart]
          dateStart++
        }
        return output
      }
      
    }
  },
  computed: {

  },
  watch: {

  },
  mounted() {

  },


});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
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
