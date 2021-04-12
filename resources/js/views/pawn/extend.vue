<template>
  <div>
    <div class="page-title page-title--alt">
      <div class="row">
        <div class="col-xl-7 d-block d-xl-flex align-items-center">
          <div class="pr-0 pr-xl-4 mb-4 mb-xl-0">
            <div
              class="d-70 mx-auto rounded font-size-xxl bg-white text-center shadow-sm"
            >
              <font-awesome-icon icon="clock" class="text-primary mt-1" />
            </div>
          </div>
          <div>
            <h5 class="display-4 mt-1 mb-2 font-weight-bold">
              ต่ออายุดอกเบี้ย
            </h5>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลสินค้าจำนำ</h5>
            </div>
            <div class="card-body">
              <form>
                <div class="form-row">
                  <label class="col-md-12" for="inputCustomerInfoExtend"
                    >ค้นหาจากฐานข้อมูลลูกค้า</label
                  >
                </div>
                <div class="form-row">
                  <div class="col-sm-10">
                    <b-form-input
                      name="inputCustomerInfoExtend"
                      type="text"
                      id="inputCustomerInfoExtend"
                      placeholder="ระบุชื่อ, นามสกุล, เลขบัตรประจำตัวประชาชน หรือเลขบัตรจำนำ"
                      v-model="searchInput"
                      :disabled="loading"
                    ></b-form-input>
                  </div>
                  <div class="col-sm-2">
                    <button
                      class="btn btn-primary btn-md"
                      :disabled="loading"
                      @click.prevent="searchPawnByCustomerData"
                    >
                      ค้นหา
                    </button>
                  </div>
                </div>
                <div class="row mt-5">
                  <div class="col-xl-12 d-block">
                    <h4
                      v-if="!search"
                      style="text-align: center"
                      class="text-black-50"
                    >
                      กรุณากรอกข้อมูลเพื่อทำการค้นหา
                    </h4>
                    <div v-else>
                      <b-spinner
                        v-if="loading"
                        label="Fetching pawn"
                        variant="primary"
                      ></b-spinner>
                      <h4
                        v-else-if="
                          !loading && pawnUsers && pawnUsers.length == 0
                        "
                        style="text-align: center"
                        class="text-black-50"
                      >
                        ไม่พบข้อมูลที่ต้องการ กรุณาตรวจสอบความถูกต้องอีกครั้ง
                      </h4>
                      <div
                        v-else-if="
                          !loading && pawnUsers && pawnUsers.length > 0
                        "
                      >
                        <span>ผลการค้นหา</span>
                        <table
                          class="table table-hover table-striped table-bordered mt-3 mb-5"
                        >
                          <thead class="thead-light">
                            <tr>
                              <th scope="col">เลขที่บัตรจำนำ</th>
                              <th scope="col">วันที่มาจำนำ</th>
                              <th scope="col">วันที่ครบกำหนดดอกเบี้ย</th>
                              <th scope="col">วันที่อัพเดทล่าสุด</th>
                              <th scope="col">การกระทำ</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(pawnUser, index) in pawnUsers"
                              :key="`pawnUser-${index}`"
                            >
                              <th scope="row">{{ pawnUser.pawn_no }}</th>
                              <td>
                                {{
                                  formatingDatetime(
                                    pawnUser.created_at,
                                    "DD MMM YYYY"
                                  )
                                }}
                              </td>
                              <td>
                                {{
                                  formatingDatetime(
                                    pawnUser.next_paid_at,
                                    "DD MMM YYYY"
                                  )
                                }}
                              </td>
                              <td>
                                {{
                                  formatingDatetime(
                                    pawnUser.updated_at,
                                    "DD MMM YYYY"
                                  )
                                }}
                              </td>
                              <td>
                                <small class="my-2 mr-2">
                                  <a
                                    href="#"
                                    @click.prevent.stop="
                                      showPawnDetail(pawnUser.pawn_no)
                                    "
                                    >ดูรายละเอียด</a
                                  >
                                </small>
                                <button
                                  @click.prevent.stop="
                                    showPawnRenew(pawnUser.pawn_no)
                                  "
                                  class="btn btn-primary btn-sm my-2"
                                >
                                  ต่ออายุ
                                </button>

                                <!-- Modal ดูรายละเอียดข้อมูลการจำนำ -->
                                <pawn-detail
                                  v-if="selectedDetailPawnNo === pawnUser.pawn_no"
                                  @renew="onRenewed"
                                  :pawn="pawnUser"
                                  v-model="showDetail"
                                ></pawn-detail>

                                <!-- Modal การต่ออายุดอกเบี้ย -->
                                <pawn-renew
                                  v-if="selectedRenewPawnNo === pawnUser.pawn_no"
                                  :pawn="pawnUser"
                                  @update:pawn="onPawnRenewUpdated"
                                  v-model="showRenew"
                                ></pawn-renew>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <b-toast
      id="pawn-extend-toast-success"
      variant="success"
      solid
      no-close-button
      v-model="toastSuccess"
    >
      ต่ออายุดอกเบี้ยสำเร็จเรียบร้อย
    </b-toast>
  </div>
</template>

<script>
import { datetimeMixin, searchMixin } from "../../mixins";
import PawnUserItem from "../../models/PawnUserItem";
import PawnDetail from "./modal/pawnDetail";
import PawnRenew from "./modal/pawnRenew";
import Datepicker from "vuejs-datepicker";

export default {
  mixins: [datetimeMixin, searchMixin],

  components: {
    PawnDetail,
    PawnRenew,
    Datepicker,
  },

  data() {
    return {
      selectedDetailPawnNo: null,
      selectedRenewPawnNo: null,
      showDetail: false,
      showRenew: false,
      toastSuccess: false
    };
  },

  watch: {
    showDetail(v) {
      if (!v) {
        this.selectedDetailPawnNo = null;
      }
    },

    showRenew(v) {
      if (!v) {
        this.selectedRenewPawnNo = null;
      }
    }
  },

  methods: {
    showPawnDetail(id) {
      this.selectedDetailPawnNo = id;
      this.showDetail = true;
      // this.$bvModal.show(`pawn-detail-modal-${id}`);
    },
    showPawnRenew(id) {
      this.selectedRenewPawnNo = id;
      this.showRenew = true;
      // this.$bvModal.hide(`pawn-detail-modal-${id}`);
      // this.$bvModal.show(`pawn-renew-modal-${id}`);
    },

    onRenewed(id) {
      this.selectedRenewPawnNo = id;
      this.showDetail = false;
      this.showRenew = true;
    },

    onPawnRenewUpdated(updatedPawn) {
      this.toastSuccess = true;

      PawnUserItem.update({
        where: updatedPawn.id,
        data: { ...updatedPawn }
      });

      this.showRenew = false;
    }
  },
};
</script>
