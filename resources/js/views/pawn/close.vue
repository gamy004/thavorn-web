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
                  <label class="col-md-12" for="inputCustomerInfo"
                    >ค้นหาจากฐานข้อมูลลูกค้า</label
                  >
                </div>
                <div class="form-row">
                  <b-form-group class="col-sm-10">
                    <b-form-input
                      name="customerInfo"
                      type="text"
                      id="inputCustomerInfo"
                      placeholder="ระบุชื่อ, นามสกุล, เลขบัตรประจำตัวประชาชน หรือเลขบัตรจำนำ"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group class="col-sm-2">
                    <button
                      @click.prevent="searchExtend"
                      class="btn btn-primary btn-md"
                    >
                      ค้นหา
                    </button>
                  </b-form-group>
                </div>
                <div class="row mt-5">
                  <div class="col-xl-12 d-block">
                    <h4
                      v-show="true"
                      style="text-align: center"
                      class="text-black-50"
                    >
                      กรุณากรอกข้อมูลเพื่อทำการค้นหา
                    </h4>
                    <h4
                      v-show="true"
                      style="text-align: center"
                      class="text-black-50"
                    >
                      ไม่พบข้อมูลที่ต้องการ กรุณาตรวจสอบความถูกต้องอีกครั้ง
                    </h4>
                    <div v-show="true">
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
                            v-for="(extend, index) in extendTemps"
                            :key="`extend-${index}`"
                          >
                            <th scope="row">{{ extend.pawn_on }}</th>
                            <td>{{ extend.pawn_items }}</td>
                            <td>{{ extend.pawn_value }}</td>
                            <td>{{ extend.pawn_interest }}</td>
                            <td>
                              <button
                                @click.prevent="pawnReply(extend.pawn_on)"
                                class="btn btn-success btn-sm ml-3"
                              >
                                ไถ่ถอน
                              </button>

                              <!-- Modal สรุปรายการไถ่ถอน -->
                              <b-modal
                                :id="`pawn-reply-modal-${extend.pawn_on}`"
                                no-close-on-backdrop
                              >
                                <template
                                  slot="modal-header"
                                  class="modal-header ml-3 mr-3"
                                >
                                  <h4>สรุปรายการไถ่ถอน</h4>
                                </template>
                                <div class="modal-body">
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <b class="ft-s-16">เลขที่บัตรจำนำ</b>
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <b class="ft-s-16">ผู้จำนำ</b>
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <b class="ft-s-16">จำนวนสินค้า</b>
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <b class="ft-s-16">รายการสินค้าจำนำ</b>
                                      <table
                                        class="table table-hover table-striped table-bordered mt-3"
                                      >
                                        <thead class="thead-light">
                                          <tr>
                                            <th scope="col">ประเภทของทอง</th>
                                            <th scope="col">
                                              น้ำหนักทอง (กรัม)
                                            </th>
                                            <th scope="col">มูลค่า (บาท)</th>
                                            <th scope="col">ความเสียหาย</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr
                                            v-for="(
                                              extend, index
                                            ) in extendTemps"
                                            :key="`extend-${index}`"
                                          >
                                            <th scope="row">
                                              {{ extend.pawn_on }}
                                            </th>
                                            <td>{{ extend.pawn_items }}</td>
                                            <td>{{ extend.pawn_value }}</td>
                                            <td>{{ extend.pawn_interest }}</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <b class="ft-s-16">อัตราดอกเบี้ย</b>
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-6">
                                      <b class="ft-s-16">วันที่มาจำนำ</b>
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                    <div class="col-6">
                                      <b class="ft-s-16">วันที่ต่อดอกล่าสุด</b>
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-6">
                                      <b class="ft-s-16"
                                        >รวมมูลค่าสินค้า(บาท)</b
                                      >
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                    <div class="col-6">
                                      <b class="ft-s-16">ดอกเบี้ย(บาท)</b>
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <h2>รวมยอดชำระ(บาท)</h2>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12">
                                      <b-form-checkbox
                                        id="checkbox-pawn-card"
                                        v-model="status"
                                        name="checkbox-pawn-card"
                                        :value="false"
                                        :unchecked-value="true"
                                      >
                                        <h4>ไม่มีบัตรจำนำ</h4>
                                      </b-form-checkbox>
                                      <fieldset class="mt-2" :disabled="status">
                                        <b>อัพโหลดหลักฐาน</b>
                                        <button
                                          class="btn btn-primary btn-sm ml-3"
                                        >
                                          อัพโหลด
                                        </button>
                                      </fieldset>
                                    </div>
                                  </div>
                                </div>
                                <template
                                  slot="modal-footer"
                                  class="modal-footer ml-3 mr-3"
                                >
                                  <button
                                    type="button"
                                    class="btn btn-secondary"
                                    @click="closePawnReply(extend.pawn_on)"
                                  >
                                    <a class="ft-s-16">ปิดหน้าต่าง</a>
                                  </button>
                                  <button type="button" class="btn btn-success">
                                    <a class="ft-s-16">ไถ่ถอน</a>
                                  </button>
                                </template>
                              </b-modal>
                            </td>
                          </tr>
                        </tbody>
                      </table>
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
export default {
  components: {},

  data() {
    return {
      status: true,
      extendTemps: [
        {
          pawn_on: "01/00001",
          pawn_items: "3",
          pawn_value: "36,000",
          pawn_interest: "5",
        },
        {
          pawn_on: "01/00002",
          pawn_items: "3",
          pawn_value: "36,000",
          pawn_interest: "5",
        },
      ],
    };
  },
  computed: {
    test() {
      return "color: rgb(235, 235, 228) !important;";
    },
  },

  methods: {
    searchExtend() {},
    pawnReply(id) {
      this.$bvModal.show(`pawn-reply-modal-${id}`);
    },
    closePawnReply(id) {
      this.$bvModal.hide(`pawn-reply-modal-${id}`);
    },
  },
};
</script>
