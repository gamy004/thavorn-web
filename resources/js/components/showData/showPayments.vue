<template>
  <div class="ft-cus">
      <form-show-payment :data="paymentData" />
  </div>
</template>

<script>
import Vue from 'vue';
import FormShowPayment from './formShowPayment.vue'
export default Vue.extend({
  name: 'showPayments',
  components:{
    FormShowPayment
  },
  data() {
    return {
        paymentData:[]
    }
  },
  props:{
    pawn_id: {
        defult: ""
    },
  },
  methods: {
    async getData() {
      if (this.pawn_id) {
        let res = await window.api.get(`pawns/${this.pawn_id}`,{
        params: {
          includes : ["payments:sideload"]
        }
        })
        console.log('aaa',res.data);
        this.paymentData = res.data.payments
      }
        
    }
  },
  watch: {
    pawn_id: {
      immediate:true,
      handler(pawn_id) {
        if (pawn_id) {
          this.getData()
        }
      }
    }
  },
  mounted() {
      
  },

});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
