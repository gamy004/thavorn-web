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
              <user-form
                v-model="pawn.user"
                :disabled="fetchingLastestPawnNo || isSubmitting"
                :error="error"
              ></user-form>
            </div>
          </div>
        </div>

        <div class="col-xl-6">
          <div class="card card-box mb-4">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลสินค้าจำนำ</h5>
            </div>
            <div class="card-body">
              <pawn-item-form
                v-model="pawn.pawn_items"
                :disabled="fetchingLastestPawnNo || isSubmitting"
                :error="error"
              ></pawn-item-form>

              <b-form-row>
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
                    v-model="pawn.totalValue"
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
                    :state="error.state('pawn.interest_rate')"
                    v-model.number="pawn.interest_rate"
                  >
                  </b-form-input>

                  <b-form-invalid-feedback id="inputInterestRate-feedback">
                    {{ error.message("pawn.interest_rate") }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </b-form-row>

              <div class="d-flex mt-3">
                <b-button
                  class="mr-2"
                  variant="secondary"
                  :disabled="fetchingLastestPawnNo || isSubmitting"
                  >ละทิ้ง</b-button
                >
                <b-button
                  variant="primary"
                  :disabled="fetchingLastestPawnNo || isSubmitting"
                  @click.prevent="submit"
                >
                  <b-spinner
                    v-if="isSubmitting"
                    label="Small Spinner Pawn Form"
                  ></b-spinner>
                  <span v-else>บันทึก</span>
                </b-button>
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
import { library } from "@fortawesome/fontawesome-svg-core";
import { faHandHoldingUsd } from "@fortawesome/free-solid-svg-icons";
import vSelect from "vue-select";
import Error from "core/Error";
import User from "models/User";
import Pawn from "models/Pawn";
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
      pawn: new Pawn({
        user: new User(),
      }),

      error: new Error(),

      isSubmitting: false,

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

    async submit() {
      const { pawn } = this;

      this.isSubmitting = true;

      try {
        await Pawn.api().post("", {
          pawn,
        });
      } catch (error) {
        this.error.recordResponse(error.response);
      } finally {
        this.isSubmitting = false;
      }
    },
  },

  mounted() {
    this.fetchLatestPawnNo();
  },
};
</script>