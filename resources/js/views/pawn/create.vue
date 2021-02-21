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
      <div class="row mb-4">
        <div class="col-lg-6 mb-4">
          <div class="card card-box">
            <div class="card-header justify-content-between">
              <h5 class="my-3">ข้อมูลส่วนตัวลูกค้า</h5>

              <b-spinner
                v-if="fetchingLastestPawnNo"
                label="Fetching latest pawn no"
                variant="primary"
                small
              ></b-spinner>

              <div v-else>
                <small v-if="createdPawn && createdPawn.pawn_no"
                  >เลขบัตรจำนำ: {{ createdPawn.pawn_no }}</small
                >
              </div>
            </div>
            <div class="card-body">
              <form>
                <div class="form-row">
                  <b-form-group class="col-md-12">
                    <label for="inputCustomer">ค้นหาลูกค้า</label>
                    <v-select
                      name="customer"
                      id="inputCustomer"
                      class="w-100"
                      :options="customerOptions"
                      @search="fetchCustomerOptions"
                      @option:selected="updateSelectedCustomer"
                    >
                      <template #open-indicator="{ attributes }">
                        <span v-bind="attributes"> </span>
                      </template>
                    </v-select>
                  </b-form-group>
                </div>
                <div class="form-row">
                  <b-form-group
                    class="col-sm-6"
                    label-for="inputFirstname"
                    label="ชื่อ"
                  >
                    <b-form-input
                      name="firstname"
                      type="text"
                      id="inputFirstname"
                      v-model="selectedCustomer.first_name"
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    class="col-sm-6"
                    label-for="inputLastname"
                    label="สกุล"
                  >
                    <b-form-input
                      name="lastname"
                      type="text"
                      id="inputLastname"
                      v-model="selectedCustomer.last_name"
                    ></b-form-input>
                  </b-form-group>

                  <!-- <b-form-group
                    label="เพศ"
                    v-slot="{ ariaDescribedby }"
                    class="col-sm-6"
                  >
                    <b-form-radio-group
                      id="inputGender"
                      :options="genderOptions"
                      :aria-describedby="ariaDescribedby"
                      name="gender"
                      v-model="selectedCustomer.gender"
                    ></b-form-radio-group>
                  </b-form-group> -->

                  <b-form-group
                    class="col-sm-6"
                    label-for="inputPhone"
                    label="เบอร์โทรศัพท์"
                  >
                    <b-form-input
                      name="phone"
                      type="text"
                      id="inputPhone"
                      v-model="selectedCustomer.phone_number"
                    ></b-form-input>
                  </b-form-group>
                </div>
                <hr />

                <b-row>
                  <b-col>
                    <h6 class="text-black-50 mb-3">ข้อมูลเพิ่มเติมลูกค้า</h6>
                  </b-col>
                </b-row>

                <b-form-row>
                  <b-form-group
                    class="col-sm-6"
                    label-for="inputIdentityCardNo"
                    label="เลขบัตรประชาชน"
                  >
                    <b-form-input
                      name="identityCardNo"
                      type="text"
                      id="inputIdentityCardNo"
                      v-model="selectedCustomer.identity_card_id"
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    class="col-sm-6"
                    label-for="inputEmail"
                    label="Email"
                  >
                    <b-form-input
                      name="email"
                      type="email"
                      id="inputEmail"
                      v-model="selectedCustomer.email"
                    ></b-form-input>
                  </b-form-group>
                </b-form-row>

                <b-form-row>
                  <b-form-group
                    class="col-sm-6"
                    label-for="inputFacebook"
                    label="Facebook"
                  >
                    <b-form-input
                      name="facebook"
                      type="text"
                      id="inputFacebook"
                      v-model="selectedCustomer.facebook"
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    class="col-sm-6"
                    label-for="inputLine"
                    label="Line"
                  >
                    <b-form-input
                      name="Line"
                      type="text"
                      id="inputLine"
                      v-model="selectedCustomer.line"
                    ></b-form-input>
                  </b-form-group>
                </b-form-row>

                <b-form-row>
                  <b-form-group
                    class="col-sm-12"
                    label-for="textareaNote"
                    label="โน้ต"
                  >
                    <b-form-textarea
                      name="note"
                      type="text"
                      id="textareaNote"
                      rows="3"
                      max-rows="8"
                      no-auto-shrink
                      v-model="selectedCustomer.note"
                    ></b-form-textarea>
                  </b-form-group>
                </b-form-row>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-3">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลสินค้าจำนำ</h5>
            </div>
            <div class="card-body">
              <form>
                <div class="form-row">
                  <b-form-group class="col-sm-6">
                    <label for="inputItem">ประเภทของทอง</label>
                    <b-form-select
                      name="item"
                      id="itemOptions"
                      class="w-100"
                      :options="itemOptions"
                      v-model="selectedItem.item_category"
                      :value="itemOptions"
                    >
                    </b-form-select>
                  </b-form-group>

                  <b-form-group
                    label="ความเสียหาย"
                    v-slot="{ ariaDescribedby }"
                    class="col-sm-6"
                  >
                    <b-form-radio-group
                      id="inputItemDamages"
                      :options="ItemDamagesOptions"
                      :aria-describedby="ariaDescribedby"
                      name="itemDamages"
                      class="ml-3"
                      v-model="selectedItem.item_damage"
                    ></b-form-radio-group>
                  </b-form-group>

                  <b-form-group
                    class="col-sm-6"
                    label-for="itemWeight"
                    label="น้ำหนักทอง(กรัม)"
                  >
                    <b-form-input
                      name="itemWeight"
                      type="text"
                      id="inputItemWeight"
                      v-model="selectedItem.item_weight"
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    class="col-sm-6"
                    label-for="itemValue"
                    label="มูลค่า(บาท)"
                  >
                    <b-form-input
                      name="itemValue"
                      type="text"
                      id="inputItemValue"
                      v-model="selectedItem.item_value"
                    ></b-form-input>
                  </b-form-group>

                  <div class="col-12 align-items-center mb-3">
                    <b-button variant="primary" @click.prevent="addItemList"
                      >เพิ่มเข้ารายการ</b-button
                    >
                  </div>
                </div>
                <hr />

                <div class="form-row">
                  <table class="table table-hover table-striped table-bordered mt-3 mb-5"
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
                            <th scope="row"> {{ itemList.item_category }} </th>
                            <td> {{ itemList.item_weight }} </td>
                            <td> {{ itemList.item_value }} </td>
                            <td> {{ itemList.item_damage }} </td>
                            <td>
                                <a href="" style="color: red;" @click.prevent.stop="deleteItemList(index)" >นำออก </a>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                </div>

                <div class="row">
                  <label class="col-12" for="itemValue" style="font-size: 1.1875rem; font-weight: 500;">รวมมูลค่าสินค้าจำนำ</label>
                  <b-form-group
                    class="col-6 mb-0"
                  >
                    <b-form-input
                      name="sumValue"
                      type="text"
                      id="inputSumValue"  
                      :disabled="true"
                      v-model="sumValue"
                    >
                    </b-form-input>
                  </b-form-group>
                  <span class="col-6 d-flex align-items-center" style="padding-left: 0; font-size: 1.1875rem; font-weight: 500;">บาท</span>
                
                <b-form-group
                    class="col-6 mt-3 mb-3"
                    label="อัตราดอกเบี้ย (%)"
                    label-for="interestRate"
                  >
                    <b-form-input
                      name="interestRate"
                      type="number"
                      id="inputInterestRate" 
                      min="0" 
                      v-model="selectedItem.interest_rate"
                    >
                    </b-form-input>
                  </b-form-group>
                </div>
              </form>
            </div>
          </div>
          <div class="d-flex justify-content-end mt-3">
            <b-button class="mr-3" variant="secondary">ละทิ้ง</b-button>
            <b-button variant="primary" @click.prevent="createPawn"
              >บันทึก</b-button
            >
          </div>
        </div> 
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "../../Layout/Components/PageTitle";
import { debounce, keyBy, pull, clone } from "lodash";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faHandHoldingUsd, faSearch } from "@fortawesome/free-solid-svg-icons";
import vSelect from "vue-select";
import User from "models/User";
import Pawn from "models/Pawn";
import PawnItem from "models/PawnItem";

library.add(faHandHoldingUsd, faSearch);

export default {
  components: {
    PageTitle,
    vSelect,
  },

  data() {
    return {
      selectedCustomer: new User(),
      selectedItem: new PawnItem(),
      itemLists: [],
      sumValue: "",
      createdPawn: new Pawn(),
      customers: [],
      customerOptions: [],
      itemOptions: [
        { 
          text: "ทองเส้น", 
          value: {
            id: 1,
            name: "ทองเส้น"
          } 
        },
        { 
          text: "ทองแท่ง", 
          value: {
            id: 2,
            name: "ทองแท่ง"
          } 
        },
      ],
      ItemDamagesOptions: [
        { 
          text: "ไม่มีตำหนิ", 
          value: {
            id: 1,
            name: "ไม่มีตำหนิ"
          } 
        },
        { 
          text: "มีตำหนิ", 
          value: {
            id: 2,
            name: "มีตำหนิ"
          } 
        },
      ],
      genderOptions: [
        { text: "ชาย", value: "M" },
        { text: "หญิง", value: "F" },
      ],
      fetchingLastestPawnNo: false,
    };
  },

  methods: {
    async fetchCustomerOptions(keyword, loading) {
      if (!keyword.length) return;

      loading();

      try {
        let { response } = await User.api().get("users", {
          params: {
            search: {
              keyword,
              fields: ["full_name"],
            },
          },
          save: false,
        });

        if (response && response.data) {
          let { users = [] } = response.data;
          this.customers = keyBy(users, "id");
          this.customerOptions = this.makeCustomerOptions(users);
        }
      } catch (error) {
        console.error(error);
      } finally {
        loading();
      }
    },

    makeCustomerOptions(data) {
      return data.reduce((carry, record, key) => {
        carry.push({ label: record.full_name, customerId: record.id });

        return carry;
      }, []);
    },

    updateSelectedCustomer(selectedCustomerOption) {
      const { customerId } = selectedCustomerOption;

      this.selectedCustomer = new User(this.customers[customerId]);
    },

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
        this.$set(this.createdPawn, "pawn_no", response.data.pawn_no);
      }
    },

    async createPawn() {
      let result;

      try {
        result = await Pawn.api().post("", {
          pawn: {
            user: this.selectedCustomer,
            pawn_no: this.createdPawn.pawn_no,
            interest_rate: this.createdPawn.interest_rate,
            pawn_items: [],
          },
        });
      } catch (error) {
        console.error(error);
      }
    },
    
    addItemList(){
      const item = {
        ...this.selectedItem,
        item_category_id: this.selectedItem.item_category.id,
        item_category: this.selectedItem.item_category.name,
        item_damage_id: this.selectedItem.item_damage.id,
        item_damage: this.selectedItem.item_damage.name
      }
      this.itemLists.push(new PawnItem(item))
    },

    async deleteItemList(index){
      let tmpItemList = await clone(this.itemLists);
      this.itemLists = [];
      await pull(tmpItemList, tmpItemList[index])
      this.itemLists = await clone(tmpItemList);
    }
  },

  created() {
    this.fetchCustomerOptions = debounce(this.fetchCustomerOptions, 500);
  },

  mounted() {
    this.fetchLatestPawnNo();
  },
};
</script>