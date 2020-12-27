<template>
  <div>
    <section class="card">
      <h2>ข้อมูลการจำนำ</h2>
      <SearchInformation @sentDataPawnItem="updateData" @emit:information="updateInformation"/>
      <goldForm class="mt-20" :data="pawnItem"/>
      <saveSection class="mt-5" @click:save="saveData" />
    </section>
  </div>
</template>

<script>
import Vue from 'vue';
import goldForm from './form/goldForm.vue'
import interest from './form/interest.vue'
import saveSection from './saveSection.vue'
import SearchInformation from './searchInformation'

export default Vue.extend({
  name: 'updatepawn',
  components:{
    goldForm,
    interest,
    saveSection,
    SearchInformation
  },
  data() {
    return {
        pawnItem : [],
        userData : {},
        pawnId : ""
    }
  },
  methods: {
    updateData(data) {
      this.pawnItem = data
    },

    updateInformation(data,pawnId) {
      this.userData = data
      this.pawnId = pawnId
    },
    async saveData() {
      let res = await window.api.get(`/pawns`, {
        params: {
          filters: [
            {
              key: "pawn_no",
              value: this.pawnId,
              operator: "eq"
            }
          ]
        }
      })
      res = res.data.pawns[0]
      console.log(res);
      
      
      if (res.id) {
        let pawn = {
          user : this.userData,
          pawn_items : this.pawnItem,
        }
        window.api.patch(`pawns/${res.id}`, {pawn});
        console.log('Sent data',pawn);
      }else {
        
      }

    }
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
