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
              <pawn-user-searcher :search-fn="searchFn">
                <template v-slot:search-result="{ pawnUsers = [] }">
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
                        v-for="(pawnUser, index) in pawnUsers"
                        :key="`pawn-${index}`"
                      >
                        <th scope="row">{{ pawnUser.pawn_no }}</th>
                        <td>{{ pawnUser.count_items }}</td>
                        <td>
                          {{ pawnUser.total_items_value }}
                        </td>
                        <td>{{ pawnUser.interest_rate }}</td>
                        <td>
                          <button
                            @click.prevent="showPawnReply(pawnUser.pawn_no)"
                            class="btn btn-success btn-sm ml-3"
                          >
                            ไถ่ถอน
                          </button>

                          <!-- Modal สรุปรายการไถ่ถอน -->
                          <pawn-reply :pawn="pawnUser"></pawn-reply>
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
  </div>
</template>

<script>
import { datetimeMixin, searchMixin } from "../../mixins";
import PawnUserSearcher from "../../components/pawn-users/searcher";
import PawnReply from "./modal/pawnReply";

export default {
  mixins: [datetimeMixin, searchMixin],

  components: {
    PawnUserSearcher,
    PawnReply,
  },

  data() {
    return {
      searchFn: searchMixin.methods.searchPawnByCustomerDataWithItems,
    };
  },
  computed: {},

  methods: {
    showPawnReply(id) {
      this.$bvModal.show(`pawn-reply-modal-${id}`);
    },
  },
};
</script>
