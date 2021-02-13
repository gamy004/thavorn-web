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
                            <th scope="col">วันที่มาจำนำ</th>
                            <th scope="col">วันที่ครบกำหนดดอกเบี้ย</th>
                            <th scope="col">วันที่อัพเดทล่าสุด</th>
                            <th scope="col">การกระทำ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(extend, index) in extendTemps"
                            :key="`extend-${index}`"
                          >
                            <th scope="row">{{ extend.pawn_on }}</th>
                            <td>{{ extend.pawn_day }}</td>
                            <td>{{ extend.pawn_dok }}</td>
                            <td>{{ extend.pawn_update }}</td>
                            <td>
                              <a
                                href="#"
                                @click.prevent="pawnDetail(extend.pawn_on)"
                                >ดูรายละเอียด</a
                              >
                              <button
                                @click.prevent="pawnRenew(extend.pawn_on)"
                                class="btn btn-primary btn-sm ml-3"
                              >
                                ต่ออายุ
                              </button>

                              <!-- Modal ดูรายละเอียดข้อมูลการจำนำ -->
                              <b-modal
                                :id="`pawn-detail-modal-${extend.pawn_on}`"
                                no-close-on-backdrop
                              >
                                <template
                                  slot="modal-header"
                                  class="modal-header ml-3 mr-3"
                                >
                                  <h4>ข้อมูลการจำนำ</h4>
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
                                      <b class="ft-s-16">จำนำสินค้า</b>
                                      <div>{{ extend.pawn_on }}</div>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <b class="ft-s-16">ประวัติการจำนำ</b>
                                      <div>{{ extend.pawn_on }}</div>
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
                                      <div>{{ extend.pawn_dok }}</div>
                                    </div>
                                    <div class="col-6">
                                      <b class="ft-s-16">วันที่ต่อดอกล่าสุด</b>
                                      <div>{{ extend.pawn_update }}</div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12">
                                      <a
                                        href="#"
                                        class="ft-s-16"
                                        @click="pawnItems(extend.pawn_on)"
                                        >แสดงรายการภายในบัตร</a
                                      >
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
                                    @click="closePawnDetail(extend.pawn_on)"
                                  >
                                    <a class="ft-s-16">ปิดหน้าต่าง</a>
                                  </button>
                                  <button
                                    type="button"
                                    class="btn btn-primary"
                                    @click="pawnRenew(extend.pawn_on)"
                                  >
                                    <a class="ft-s-16">ต่ออายุดอกเบี้ย</a>
                                  </button>
                                </template>
                              </b-modal>

                              <!-- Modal แสดงรายการสินค้าภายในบัตร -->
                              <b-modal
                                :id="`pawn-list-item-modal-${extend.pawn_on}`"
                                no-close-on-backdrop
                              >
                                <template
                                  slot="modal-header"
                                  class="modal-header ml-3 mr-3"
                                >
                                  <h4>รายการสินค้าในบัตร</h4>
                                </template>
                                <div class="modal-body">
                                  <div class="row mb">
                                    <div class="col-12">
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
                                            <td>{{ extend.pawn_on }}</td>
                                            <td>{{ extend.pawn_on }}</td>
                                            <td>{{ extend.pawn_on }}</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                                <template
                                  slot="modal-footer"
                                  class="modal-footer ml-3 mr-3"
                                >
                                  <button
                                    type="button"
                                    class="btn btn-primary"
                                    @click="closePawnItems(extend.pawn_on)"
                                  >
                                    <a class="ft-s-16">ปิดหน้าต่างนี้</a>
                                  </button>
                                </template>
                              </b-modal>

                              <!-- Modal การต่ออายุดอกเบี้ย -->
                              <b-modal
                                :id="`pawn-renew-modal-${extend.pawn_on}`"
                                no-close-on-backdrop
                              >
                                <template
                                  slot="modal-header"
                                  class="modal-header ml-3 mr-3"
                                >
                                  <h4>รายการต่ออายุดอกเบี้ย</h4>
                                </template>
                                <div class="modal-body">
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <b class="ft-s-16"
                                        >เลือกเดือนที่ต่ออายุ</b
                                      >
                                      <div class="card card-box mt-2 mb-5">
                                        <div class="card-header bg-light">
                                          <div class="card-header--title">
                                            <b>Datepicker</b>
                                          </div>
                                        </div>
                                        <div class="card-body">
                                          <div
                                            class="datepicker-wrapper-flush"
                                            data-toggle="datepicker"
                                          ></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-4">
                                    <div class="col-12">
                                      <b class="ft-s-16"
                                        >สรุปเดือนที่ต่ออายุดอกเบี้ย</b
                                      >
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12">
                                      <h2>รวมยอดชำระ(บาท)</h2>
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
                                    @click="closePawnRenew(extend.pawn_on)"
                                  >
                                    <a class="ft-s-16">ปิดหน้าต่าง</a>
                                  </button>
                                  <button type="button" class="btn btn-success">
                                    <a class="ft-s-16">ต่ออายุ</a>
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
      extendTemps: [
        {
          pawn_on: "01/00001",
          pawn_day: "3 พ.ย 2020",
          pawn_dok: "3 มี.ค 2021",
          pawn_update: "15 ม.ค 2021",
        },
        {
          pawn_on: "01/00002",
          pawn_day: "3 พ.ย 2020",
          pawn_dok: "3 มี.ค 2021",
          pawn_update: "15 ม.ค 2021",
        },
      ],
    };
  },

  methods: {
    searchExtend() {},
    pawnDetail(id) {
      this.$bvModal.show(`pawn-detail-modal-${id}`);
    },
    pawnRenew(id) {
      this.$bvModal.hide(`pawn-detail-modal-${id}`);
      this.$bvModal.show(`pawn-renew-modal-${id}`);
    },
    pawnItems(id) {
      this.$bvModal.hide(`pawn-detail-modal-${id}`);
      this.$bvModal.show(`pawn-list-item-modal-${id}`);
    },
    closePawnDetail(id) {
      this.$bvModal.hide(`pawn-detail-modal-${id}`);
    },
    closePawnRenew(id) {
      this.$bvModal.hide(`pawn-renew-modal-${id}`);
    },
    closePawnItems(id) {
      this.$bvModal.hide(`pawn-list-item-modal-${id}`);
      this.$bvModal.show(`pawn-detail-modal-${id}`);
    },
  },
};
</script>
