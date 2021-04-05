<template>
  <div>
    <div class="page-title page-title--alt">
      <div class="row">
        <div class="col-xl-7 d-block d-xl-flex align-items-center">
          <div class="pr-0 pr-xl-4 mb-4 mb-xl-0">
            <div
              class="d-70 mx-auto rounded font-size-xxl bg-white text-center shadow-sm"
            >
              <font-awesome-icon
                icon="hand-holding-usd"
                class="text-primary mt-1"
              />
            </div>
          </div>
          <div>
            <h5 class="display-4 mt-1 mb-2 font-weight-bold">การจำนำ</h5>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-6">
          <div class="card card-box mb-4">
            <div class="card-header justify-content-between">
              <h5 class="my-3">ข้อมูลส่วนตัวลูกค้า</h5>

              <b-spinner
                v-if="fetchingLastestPawnNo"
                label="Fetching latest pawn no"
                variant="primary"
                small
              ></b-spinner>

              <div v-else>
                <small v-if="pawn && pawn.pawn_no"
                  >เลขบัตรจำนำ: {{ pawn.pawn_no }}</small
                >
              </div>
            </div>
            <div class="card-body">
              <user-form v-model="pawn.user"></user-form>
            </div>
          </div>
        </div>

        <div class="col-xl-6">
          <div class="card card-box mb-4">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลสินค้าจำนำ</h5>
            </div>
            <div class="card-body">
              <pawn-item-form v-model="pawn.pawn_items"></pawn-item-form>

              <div class="form-row">
                <!-- <table
                    class="table table-hover table-striped table-bordered mt-3 mb-5"
                  >
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">ประเภทของทอง</th>
                        <th scope="col">น้ำหนักทอง (กรัม)</th>
                        <th scope="col">มูลค่า (บาท)</th>
                        <th scope="col">ความเสียหาย</th>
                        <th scope="col">การกระทำ</th>
                      </tr>
                    </thead>
                    <tbody v-if="itemLists && itemLists.length > 0">
                      <tr
                        v-for="(itemList, index) in itemLists"
                        :key="`itemList-${index}`"
                      >
                        <th scope="row">{{ itemList.item_category }}</th>
                        <td>{{ itemList.item_weight }}</td>
                        <td>{{ itemList.item_value }}</td>
                        <td>{{ itemList.item_damage }}</td>
                        <td>
                          <a
                            href=""
                            style="color: red"
                            @click.prevent.stop="deleteItemList(index)"
                            >นำออก
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table> -->
              </div>

              <div class="row">
                <label
                  class="col-12"
                  for="itemValue"
                  style="font-size: 1.1875rem; font-weight: 500"
                  >รวมมูลค่าสินค้าจำนำ</label
                >
                <b-form-group class="col-6 mb-0">
                  <b-form-input
                    name="sumValue"
                    type="text"
                    id="inputSumValue"
                    :disabled="true"
                    v-model="sumValue"
                  >
                  </b-form-input>
                </b-form-group>
                <span
                  class="col-6 d-flex align-items-center"
                  style="
                    padding-left: 0;
                    font-size: 1.1875rem;
                    font-weight: 500;
                  "
                  >บาท</span
                >

                <b-form-group
                  class="col-6 mt-3 mb-3"
                  label="อัตราดอกเบี้ย (%)"
                  label-for="interestRate"
                >
                  <b-form-input
                    name="interestRate"
                    type="number"
                    id="inputInterestRate"
                    :min="0"
                    :max="100"
                    v-model="pawn.interest_rate"
                  >
                  </b-form-input>
                </b-form-group>
              </div>

              <div class="d-flex mt-3">
                <b-button class="mr-3" variant="secondary">ละทิ้ง</b-button>
                <b-button variant="primary" @click.prevent="createPawn"
                  >บันทึก</b-button
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "../../Layout/Components/PageTitle";
import { pull, clone } from "lodash";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faHandHoldingUsd } from "@fortawesome/free-solid-svg-icons";
import vSelect from "vue-select";
import User from "models/User";
import Pawn from "models/Pawn";
import PawnItem from "models/PawnItem";
import UserForm from "components/users/form";
import PawnItemForm from "components/pawn-items/form";

library.add(faHandHoldingUsd);

export default {
  components: {
    PageTitle,
    vSelect,
    UserForm,
    PawnItemForm,
  },

  data() {
    return {
      selectedItem: new PawnItem(),
      itemLists: [],
      sumValue: "",

      pawn: new Pawn({
        pawn_no: null,
        interest_rate: 3,
        pawn_items: [],
        customer_id: null,
        user: new User(),
      }),

      itemOptions: [
        {
          text: "ทองเส้น",
          value: {
            id: 1,
            name: "ทองเส้น",
          },
        },
        {
          text: "ทองแท่ง",
          value: {
            id: 2,
            name: "ทองแท่ง",
          },
        },
      ],

      ItemDamagesOptions: [
        {
          text: "ไม่มีตำหนิ",
          value: {
            id: 1,
            name: "ไม่มีตำหนิ",
          },
        },
        {
          text: "มีตำหนิ",
          value: {
            id: 2,
            name: "มีตำหนิ",
          },
        },
      ],

      fetchingLastestPawnNo: false,
    };
  },

  methods: {
    async fetchLatestPawnNo() {
      let result;

      this.fetchingLastestPawnNo = true;

      try {
        result = await Pawn.api().get("/generate-number", { save: false });
      } catch (error) {
        console.log(error);
      } finally {
        this.fetchingLastestPawnNo = false;
      }

      const { response } = result;

      if (response && response.data && response.data.pawn_no) {
        this.$set(this.pawn, "pawn_no", response.data.pawn_no);
      }
    },

    async createPawn() {
      let result;
      const { pawn } = this;

      try {
        result = await Pawn.api().post("", {
          pawn,
          // pawn: {
          //   user: this.pawn.user,
          //   pawn_no: this.pawn.pawn_no,
          //   interest_rate: this.pawn.interest_rate,
          //   pawn_items: [],
          // },
        });
      } catch (error) {
        console.error(error);
      }
    },

    addItemList() {
      const item = {
        ...this.selectedItem,
        item_category_id: this.selectedItem.item_category.id,
        item_category: this.selectedItem.item_category.name,
        item_damage_id: this.selectedItem.item_damage.id,
        item_damage: this.selectedItem.item_damage.name,
      };
      this.itemLists.push(new PawnItem(item));
    },

    async deleteItemList(index) {
      let tmpItemList = await clone(this.itemLists);
      this.itemLists = [];
      await pull(tmpItemList, tmpItemList[index]);
      this.itemLists = await clone(tmpItemList);
    },
  },

  mounted() {
    this.fetchLatestPawnNo();
  },
};
</script>