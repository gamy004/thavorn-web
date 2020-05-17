<template>
  <div class="navbar navbar-expand-lg navbar-light cusnev shadow-sm">
    <img v-if="logo" src="../assets/logo.svg">
  </div>
</template>

<script>
import Vue from 'vue';

export default Vue.extend({
  name: 'nevbar',
  props: {
    msg: String,
    logo: {
      type : [Boolean, Number],
      default : false
    }
  },
  data() {
    return {
      goldPrice:0
    }
  },
  mounted() {
    this.getGoldPrice();
  },
  methods: {
    checkCommas(nStr) {
      nStr += '';
      let x = nStr.split('.');
      let x1 = x[0];
      let x2 = x.length > 1 ? '.' + x[1][0]+x[1][1] : '';
      let rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      console.log(x1 + x2);
      
      return x1 + x2;
    }
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.shadow-sm {
    -webkit-box-shadow: 0 0.125rem 0rem rgba(0, 0, 0, 0.075) !important;
    box-shadow: 0 0.125rem 0rem rgba(0, 0, 0, 0.075) !important;
    background-color: white;
}
img{
  height: 25px;
  width: auto;
}
.navbar{
  align-content: center;
}
.cusnev{
  width: 100%;

  height: 50px;;
}
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.navbar{
  justify-content: space-between;
}
</style>
