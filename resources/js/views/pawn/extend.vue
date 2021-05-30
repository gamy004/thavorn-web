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
              <pawn-user-searcher
                ref="pawnUserSearcher"
                :fields="fields"
                search-fn="searchPawnByCustomerData"
              >
                <template #cell(created_at)="data">
                  {{ formatingDatetime(data.item.created_at, "DD MMM YYYY") }}
                </template>

                <template #cell(next_paid_at)="data">
                  {{ formatingDatetime(data.item.next_paid_at, "DD MMM YYYY") }}
                </template>

                <template #cell(updated_at)="data">
                  {{ formatingDatetime(data.item.updated_at, "DD MMM YYYY") }}
                </template>

                <template #cell(action)="data">
                  <small class="mr-2">
                    <a href="#" @click.prevent.stop="showPawnDetail(data.item)"
                      >ดูรายละเอียด</a
                    >
                  </small>

                  <button
                    @click.prevent.stop="showPawnRenew(data.item)"
                    class="btn btn-primary btn-sm"
                  >
                    ต่ออายุ
                  </button>
                </template>
              </pawn-user-searcher>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal ดูรายละเอียดข้อมูลการจำนำ -->
    <pawn-detail
      v-if="selectedDetailPawn"
      @renew="onRenewed"
      :pawn="selectedDetailPawn"
      v-model="showDetail"
    ></pawn-detail>

    <!-- Modal การต่ออายุดอกเบี้ย -->
    <pawn-renew
      v-if="selectedRenewPawn"
      :pawn="selectedRenewPawn"
      @update:pawn="onPawnRenewUpdated"
      v-model="showRenew"
    ></pawn-renew>

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
import { datetimeMixin } from "../../mixins";
import PawnUserItem from "../../models/PawnUserItem";
import PawnUserSearcher from "../../components/pawn-users/searcher";
import PawnDetail from "./modal/pawnDetail";
import PawnRenew from "./modal/pawnRenew";

export default {
  mixins: [datetimeMixin],

  components: {
    PawnUserSearcher,
    PawnDetail,
    PawnRenew,
  },

  data() {
    return {
      selectedDetailPawn: null,
      selectedRenewPawn: null,
      showDetail: false,
      showRenew: false,
      toastSuccess: false,
      fields: [
        { key: "pawn_no", label: "เลขที่บัตรจำนำ" },
        { key: "created_at", label: "วันที่มาจำนำ" },
        { key: "next_paid_at", label: "วันที่ครบกำหนดดอกเบี้ย" },
        { key: "updated_at", label: "วันที่อัพเดทล่าสุด" },
        { key: "action", label: "", tdClass: "text-center" },
      ],
    };
  },

  watch: {
    showDetail(v) {
      if (!v) {
        this.selectedDetailPawn = null;
      }
    },

    showRenew(v) {
      if (!v) {
        this.selectedRenewPawn = null;
      }
    },
  },

  methods: {
    showPawnDetail(data) {
      this.selectedDetailPawn = new PawnUserItem({ ...data });
      this.showDetail = true;
    },
    showPawnRenew(data) {
      this.selectedRenewPawn = new PawnUserItem({ ...data });
      this.showRenew = true;
    },

    onRenewed(data) {
      this.selectedRenewPawn = new PawnUserItem({ ...data });
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
      this.$refs.pawnUserSearcher.refresh();
    },
  },
};
</script>
