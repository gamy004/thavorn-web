<template>
  <div>
      <Table :data="userData"/>
  </div>
</template>

<script>
import Vue from 'vue';
import Table from './formShowUser';

export default Vue.extend({
  name: 'showUserData',
  components:{
    Table
  },
  data() {
    return {
        userData:[]
    }
  },
  methods: {
      async getUserData(sort) {
          let res = await window.api.get(`users`)
          this.userData = res.data.users
      }
  },
  computed: {

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
