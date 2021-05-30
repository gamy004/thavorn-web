<template>
  <div>
    <div class="page-title page-title--alt">
      <div class="row">
        <div class="col-xl-7 d-block d-xl-flex align-items-center">
          <div class="pr-0 pr-xl-4 mb-4 mb-xl-0">
            <div
              class="d-70 mx-auto rounded font-size-xxl bg-white text-center shadow-sm"
            >
              <font-awesome-icon icon="database" class="text-primary mt-1" />
            </div>
          </div>
          <div>
            <h5 class="display-4 mt-1 mb-2 font-weight-bold">ข้อมูลการจำนำ</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <!-- <div class="col-lg-12">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ภาพรวมการจำนำ</h5>
            </div>
            <div class="card-body"></div>
          </div>
        </div> -->

        <div class="col-lg-12 mt-2">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลการจำนำ</h5>
            </div>
            <div class="card-body">
              <pawn-user-searcher
                ref="pawnUserSearcher"
                :fields="fields"
                search-fn="searchAllPawnByCustomerDataWithItems"
              >
                <template #cell(customer_name)="data">
                  {{ data.item.full_name }}
                </template>

                <template #cell(created_at)="data">
                  {{ formatingDatetime(data.item.created_at, "DD MMM YYYY") }}
                </template>

                <template #cell(next_paid_at)="data">
                  {{ formatingDatetime(data.item.next_paid_at, "DD MMM YYYY") }}
                </template>

                <template #cell(updated_at)="data">
                  {{ formatingDatetime(data.item.updated_at, "DD MMM YYYY") }}
                </template>

                <!-- <template #cell(complete)="data">
                  {{ data.item.complete ? "เรียบร้อย" : "ยังไม่เรียบร้อย" }}
                </template> -->

                <template #cell(action)="data">
                  <small class="my-2 mr-2">
                    <a href="#" @click.prevent.stop="showPawnDetail(data.item)"
                      >ดูรายละเอียด</a
                    >
                  </small>
                </template>
              </pawn-user-searcher>

              <pawn-detail
                :pawn="shownPawnUserItem"
                :extendable="false"
                v-model="showDetail"
              ></pawn-detail>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { datetimeMixin } from "../../mixins";
import pawnUserSearcher from "../../components/pawn-users/searcher";
import PawnUserItem from "../../models/PawnUserItem";
import pawnDetail from "../../views/pawn/modal/pawnDetail";

export default {
  mixins: [datetimeMixin],

  components: {
    pawnDetail,
    pawnUserSearcher,
  },

  data() {
    return {
      shownPawnUserItem: new PawnUserItem(),
      showDetail: false,
      fields: [
        { key: "pawn_no", label: "เลขที่บัตรจำนำ" },
        { key: "customer_name", label: "ชื่อลูกค้า" },
        { key: "created_at", label: "วันที่มาจำนำ" },
        { key: "next_paid_at", label: "วันที่ครบกำหนดดอกเบี้ย" },
        { key: "updated_at", label: "วันที่อัพเดทล่าสุด" },
        // { key: "complete", label: "สถานะไถ่ถอน" },
        { key: "action", label: "", tdClass: "text-center" },
      ],
    };
  },

  methods: {
    showPawnDetail(data) {
      this.shownPawnUserItem = new PawnUserItem({ ...data });
      this.showDetail = true;
    },
  },
};
</script>