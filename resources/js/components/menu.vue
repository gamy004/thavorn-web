<template>
  <div class="color-cus">
    <menu-item
      v-for="item in menuOBJ"
      :imgURL="item.img"
      :msg="item.msg"
      :key="item.msg"
      v-bind:class="[item.val === route ? 'active' : null]"
      @click.native="clickRoute(item.val)"
    />
    <menu-item
    :imgURL="db.img"
    :msg="db.msg"
    :key="db.msg"
    v-bind:class="[db.val === route ? 'active' : null]"
    @click.native="clickRoute(db.val)"
    />
    <menu-item
    class="db-chile"
    v-for="item in dbObj"
    :msg="item.msg"
    :key="item.msg"
    v-bind:class="[item.val === route ? 'active' : null]"
    @click.native="clickRoute(item.val)"
    />
  </div>
</template>

<script>
import Vue from "vue";
import navbar from "./nevbar.vue";
import menuItem from "./menuItem.vue";
import axios from "axios";

export default Vue.extend({
  name: "menul",
  components: {
    navbar,
    menuItem
  },
  props: {
    msg: String
  },
  data() {
    return {
      menuOBJ: [
        {
          msg: "การจำนำ",
          img: "images/hand.svg",
          val: "pawn"
        },
        {
          msg: "ต่ออายุดอกเบี้ย",
          img: "images/clock.svg",
          val: "renew"
        },
        // {
        //   msg: "ขอเพิ่มข้อมูล",
        //   img: "images/income.svg",
        //   val: "updatepawn"
        // },
        {
          msg: "ไถ่ถอน",
          img: "images/switch.svg",
          val: "redeem"
        },
      ],
      db: {
          msg: "ข้อมูล",
          img: "images/database.svg",
          val: "db"
        },
      dbObj:[
        {
          msg: "ข้อมูลลูกค้า",
          img: "images/database.svg",
          val: "dbUser"
        },
        {
          msg: "ข้อมูลการจำนำ",
          img: "images/database.svg",
          val: "dbPawn"
        },
      ],
      goldPrice: 0
    };
  },
  computed: {
    route() {
      return this.$route.path.substr(1, this.$route.path.length);
    }
  },
  methods: {
    clickRoute(val) {
      console.log(val);
      this.$router.replace(val);
    },
  },
  mounted() {
    
  }
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.color-cus {
  background-color: #2f353a;
}
img {
  height: 30px;
  width: auto;
}
.active {
  background-color: #3e4449;
}
</style>
