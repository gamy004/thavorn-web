<template>
  <div>
    <section class="card">
      <h2>ข้อมูลการจำนำ</h2>
      <SearchInformation @sentDataPawnItem="updateData" />
      <goldForm class="mt-20" :data="pawnItem" />
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
    }
  },
  methods: {
    updateData(data) {
      this.pawnItem = data
    }
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
