<template>
  <div>
      <!-- <form-show-one-pawn :pawn="pawnData[0]" :allPawnItem="allPawnItem" /> -->
      <form-show-one-pawn 
      :pawn="pawnData" 
      :allPawnItem="PawnItem" 
      />
  </div>
</template>

<script>
import Vue from 'vue';
import formShowOnePawn from './formShowOnePawn.vue'
export default Vue.extend({
  name: 'showPawnData',
  components:{
    formShowOnePawn
  },
  data() {
    return {
        pawnData:[],
        PawnItem:[]
    }
  },
  methods: {
    async getUserData(sort) {
        let res = await window.api.get(`pawns`)
        this.pawnData = res.data.pawns
        let res2 = await window.api.get(`pawn_user_items`)
        this.PawnItem = res2.data.pawn_items
        this.$emit('pushData',this.pawnData,this.PawnItem)
    }
  },
  watch: {

  },
  mounted() {
      this.getUserData('first_name')
  },

});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
