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
</style>
