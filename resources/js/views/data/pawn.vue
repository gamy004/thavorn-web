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
        <div class="col-lg-12">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ภาพรวมการจำนำ</h5>
            </div>
            <div class="card-body">
              <b-spinner
                v-if="loading"
                label="Fetching pawn"
                variant="primary"
              ></b-spinner>
              <div v-else></div>
            </div>
          </div>
        </div>

        <div class="col-lg-12 mt-4">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลการจำนำ</h5>
            </div>
            <div class="card-body">
              <b-spinner
                v-if="loading"
                label="Fetching pawn"
                variant="primary"
              ></b-spinner>

              <pawn-user-searcher
                ref="pawnUserSearcher"
                :search-fn="searchFn"
                auto-fetch
              >
                <template v-slot:search-result="{ pawnUserItems = [] }">
                  <b-table
                    id="pawnTable"
                    class="mt-3 mb-5"
                    hover
                    striped
                    bordered
                    :fields="fields"
                    :items="pawnUserItems"
                    :per-page="perPage"
                    :current-page="currentPage"
                  >
                    <template #cell(pawn_no)="data">
                      {{ data.item.pawn_no }}
                    </template>

                    <template #cell(customer_name)="data">
                      {{ data.item.full_name }}
                    </template>

                    <template #cell(created_at)="data">
                      {{
                        formatingDatetime(data.item.created_at, "DD MMM YYYY")
                      }}
                    </template>

                    <template #cell(next_paid_at)="data">
                      {{
                        formatingDatetime(data.item.next_paid_at, "DD MMM YYYY")
                      }}
                    </template>

                    <template #cell(updated_at)="data">
                      {{
                        formatingDatetime(data.item.updated_at, "DD MMM YYYY")
                      }}
                    </template>

                    <template #cell(complete)="data">
                      {{ data.item.complete ? "เรียบร้อย" : "ยังไม่เรียบร้อย" }}
                    </template>

                    <template #cell(action)="data">
                      <small class="my-2 mr-2">
                        <a
                          href="#"
                          @click.prevent.stop="showPawnDetail(data.item)"
                          >ดูรายละเอียด</a
                        >
                      </small>
                    </template>
                  </b-table>

                  <b-pagination
                    v-model="currentPage"
                    :total-rows="pawnUserItems.length"
                    :per-page="perPage"
                    aria-controls="pawnTable"
                  ></b-pagination>
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
import { datetimeMixin, searchMixin } from "../../mixins";
import Pawn from "models/Pawn";
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
      users: [],
      loading: false,
      searchFn: searchMixin.methods.searchAllPawnByCustomerDataWithItems,
      shownPawnUserItem: new PawnUserItem(),
      showDetail: false,
      perPage: 50,
      currentPage: 1,
      fields: [
        { key: "pawn_no", label: "เลขที่บัตรจำนำ" },
        { key: "customer_name", label: "ชื่อลูกค้า" },
        { key: "created_at", label: "วันที่มาจำนำ" },
        { key: "next_paid_at", label: "วันที่ครบกำหนดดอกเบี้ย" },
        { key: "updated_at", label: "วันที่อัพเดทล่าสุด" },
        { key: "complete", label: "สถานะไถ่ถอน" },
        { key: "action", label: "" },
      ],
    };
  },

  methods: {
    async fetch() {
      try {
        this.loading = true;

        await Pawn.api().get("/pawns");
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },

    showPawnDetail(data) {
      this.shownPawnUserItem = new PawnUserItem({ ...data });
      this.showDetail = true;
    },
  },

  created() {
    this.fetch();
  },
};
</script>