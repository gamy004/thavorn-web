<template>
  <div>
    <Table :data="userData" />
  </div>
</template>

<script>
import Vue from "vue";
import Table from "./formShowUser";

export default Vue.extend({
  name: "showUserData",
  components: {
    Table
  },
  data() {
    return {
      userData: []
    };
  },
  methods: {
    async getUserData(sort) {
      let res = await window.api.get(`users`);

      // Sample api
      // window.api.get(`users`, {
      //   params: {
      //     search: {
      //       keyword: "keyword",
      //       fields: ["first_name", "last_name", "full_name"]
      //     }
      //   }
      // });
      // window.api.get(`pawns/generate-number`);
      window.api.get(`pawns/1/close-amount`);
      // window.api.get(`pawns/1/paid-amount`, {
      //   params: {
      //     month_amount: 1
      //   }
      // });

      this.userData = res.data.users;
    }
  },
  computed: {},
  watch: {},
  mounted() {
    this.getUserData("first_name");
  }
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
