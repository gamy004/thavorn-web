<template>
  <div>
    <div class="page-title page-title--alt">
      <div class="row">
        <div class="col-xl-7 d-block d-xl-flex align-items-center">
          <div class="pr-0 pr-xl-4 mb-4 mb-xl-0">
            <div
              class="d-70 mx-auto rounded font-size-xxl bg-white text-center shadow-sm"
            >
              <font-awesome-icon icon="reply" class="text-primary mt-1" />
            </div>
          </div>
          <div>
            <h5 class="display-4 mt-1 mb-2 font-weight-bold">ไถ่ถอน</h5>
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
                  <label class="col-md-12" for="inputCustomerInfoReply"
                    >ค้นหาจากฐานข้อมูลลูกค้า</label
                  >
                </div>
                <div class="form-row">
                  <div class="col-sm-10">
                    <b-form-input
                      name="inputCustomerInfoReply"
                      type="text"
                      id="inputCustomerInfoReply"
                      placeholder="ระบุชื่อ, นามสกุล, เลขบัตรประจำตัวประชาชน หรือเลขบัตรจำนำ"
                      v-model="searchInput"
                      :disabled="loading"
                    ></b-form-input>
                  </div>
                  <div class="col-sm-2">
                    <button
                      class="btn btn-primary btn-md"
                      :disabled="loading"
                      @click.prevent="searchPawnByCustomerData()"
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
                        v-else-if="!loading && pawns && pawns.length == 0"
                        style="text-align: center"
                        class="text-black-50"
                      >
                        ไม่พบข้อมูลที่ต้องการ กรุณาตรวจสอบความถูกต้องอีกครั้ง
                      </h4>
                      <div v-else-if="!loading && pawns && pawns.length > 0">
                        <span>ผลการค้นหา</span>
                        <table
                          class="table table-hover table-striped table-bordered mt-3 mb-5"
                        >
                          <thead class="thead-light">
                            <tr>
                              <th scope="col">เลขที่บัตรจำนำ</th>
                              <th scope="col">จำนวนสินค้า (ชิ้น)</th>
                              <th scope="col">มูลค่าสินค้า (บาท)</th>
                              <th scope="col">อัตราดอกเบี้ย (%)</th>
                              <th scope="col">การกระทำ</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(pawn, index) in pawns"
                              :key="`pawn-${index}`"
                            >
                              <th scope="row">{{ pawn.pawn_no }}</th>
                              <td>{{ pawnItemCount(pawn.pawn_no) }}</td>
                              <td>
                                {{ sumPawnItemValueByPawnNo(pawn.pawn_no) }}
                              </td>
                              <td>{{ pawn.interest_rate }}</td>
                              <td>
                                <button
                                  @click.prevent="showPawnReply(pawn.pawn_no)"
                                  class="btn btn-success btn-sm ml-3"
                                >
                                  ไถ่ถอน
                                </button>

                                <!-- Modal สรุปรายการไถ่ถอน -->
                                <pawn-reply :pawn="pawn"></pawn-reply>
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
  </div>
</template>

<script>
import { datetimeMixin, searchMixin } from "../../mixins";
import PawnReply from "./modal/pawnReply";

export default {
  mixins: [datetimeMixin, searchMixin],

  components: {
    PawnReply,
  },

  data() {
    return {};
  },
  computed: {},

  methods: {
    showPawnReply(id) {
      this.$bvModal.show(`pawn-reply-modal-${id}`);
    },
  },
};
</script>
