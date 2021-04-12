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
              <pawn-user-searcher>
                <template v-slot:search-result="{ pawnUsers = [] }">
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
                </template>
              </pawn-user-searcher>
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
      ต่ออายุดอกเบี้ยเรียบร้อยแล้ว
    </b-toast>
  </div>
</template>

<script>
import { datetimeMixin, searchMixin } from "../../mixins";
import PawnUserItem from "../../models/PawnUserItem";
import PawnUserSearcher from "../../components/pawn-users/searcher";
import PawnDetail from "./modal/pawnDetail";
import PawnRenew from "./modal/pawnRenew";

export default {
  mixins: [datetimeMixin, searchMixin],

  components: {
    PawnUserSearcher,
    PawnDetail,
    PawnRenew,
  },

  data() {
    return {
      selectedDetailPawnNo: null,
      selectedRenewPawnNo: null,
      showDetail: false,
      showRenew: false,
      toastSuccess: false,
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
    },
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
        data: { ...updatedPawn },
      });

      this.showRenew = false;
    },
  },
};
</script>
