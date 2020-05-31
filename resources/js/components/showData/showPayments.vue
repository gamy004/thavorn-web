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
        let res = await window.api.get(`payment`)
        console.log('aaa',res.data);
        this.paymentData = res.data.payment
    }
  },
  watch: {

  },
  mounted() {
      this.getData()
  },

});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
