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
              <pawn-user-searcher
                ref="pawnUserSearcher"
                :fields="fields"
                search-fn="searchPawnByCustomerDataWithItems"
              >
                <template #cell(action)="data">
                  <button
                    @click.prevent="showPawnReply(data.item)"
                    class="btn btn-primary btn-sm"
                  >
                    ไถ่ถอน
                  </button>
                </template>
              </pawn-user-searcher>

              <pawn-reply
                v-if="selectedReplyPawn"
                :pawn="selectedReplyPawn"
                v-model="showReply"
                @success="onClosePawnSuccess"
                @fail="toastCloseFail = true"
              ></pawn-reply>

              <b-toast
                id="pawn-close-toast-success"
                variant="success"
                solid
                no-close-button
                v-model="toastCloseSuccess"
              >
                ไถ่ถอนการจำนำสำเร็จ
              </b-toast>

              <b-toast
                id="pawn-close-toast-fail"
                variant="danger"
                solid
                no-close-button
                v-model="toastCloseFail"
              >
                ไถ่ถอนการจำนำไม่สำเร็จ
              </b-toast>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { datetimeMixin } from "../../mixins";
import PawnUserItem from "../../models/PawnUserItem";
import PawnUserSearcher from "../../components/pawn-users/searcher";
import PawnReply from "./modal/pawnReply";

export default {
  mixins: [datetimeMixin],

  components: {
    PawnUserSearcher,
    PawnReply,
  },

  data() {
    return {
      selectedReplyPawn: null,
      showReply: false,
      toastCloseFail: false,
      toastCloseSuccess: false,
      fields: [
        { key: "pawn_no", label: "เลขที่บัตรจำนำ" },
        { key: "full_name", label: "ชื่อ-สกุล ลูกค้า" },
        { key: "count_items", label: "จำนวนสินค้า (ชิ้น)" },
        { key: "total_items_value", label: "มูลค่าสินค้า (บาท)" },
        { key: "interest_rate", label: "อัตราดอกเบี้ย (%)" },
        { key: "action", label: "", tdClass: "text-center" },
      ],
    };
  },

  watch: {
    showReply(v) {
      if (!v) {
        this.selectedReplyPawn = null;
      }
    },
  },

  methods: {
    showPawnReply(data) {
      this.selectedReplyPawn = new PawnUserItem({ ...data });
      this.showReply = true;
    },

    async onClosePawnSuccess({ id, ...data }) {
      this.toastCloseSuccess = true;

      PawnUserItem.update({
        where: id,
        data,
      });

      this.$refs.pawnUserSearcher.refresh();
    },
  },
};
</script>
