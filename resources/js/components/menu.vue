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
    async getGoldPrice() {
      let onzToBath = 0.47295;
      // UserApiTest path tests/Unit/UserApiTest.php
      let res1 = await window.api.get("users", {
        params: {
          filters: [
            {
              key: "identity_card_id",
              value: "nPIZ",
              operator: "ct"
            }
          ]
        }
      });

      //   let res2 = await window.api.post("pawns/1/close", {
      //     amount: 91612.88
      //   });
      // let res2 = await window.goldPriceApi.get();
      // console.log(1234,res2.data.items[0].xauPrice*onzToBath);
    }
  },
  mounted() {
    this.getGoldPrice();
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
