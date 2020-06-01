<template>
  <div>
    <div class="h-flex-col-s-flex-row">
        <table>
            <tbody>
                <tr class="bg-primary text-white">
                    <th>เลขบัตรประชาชน</th>
                    <th>ชื่อ</th>
                    <th>นามสุกล</th>
                    <th>เลขโทรศัพท์</th>
                    <th>วันที่สร้าง</th>
                </tr>
                <tr v-for="(item, index) in data" :key="index" >
                    <td>{{item.identity_card_id}}</td>
                    <td>{{item.first_name}}</td>
                    <td>{{item.last_name}}</td>
                    <td>{{item.phone_number}}</td>
                    <td>{{item.created_at}}</td>
                </tr>
            </tbody>
        </table>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'usertable',
  components:{
    
  },
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
