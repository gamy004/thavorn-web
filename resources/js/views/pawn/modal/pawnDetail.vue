<template>
  <div>
    <b-modal :id="`pawn-detail-modal-${pawn.pawn_no}`" no-close-on-backdrop>
      <template slot="modal-header" class="modal-header ml-3 mr-3">
        <h4>ข้อมูลการจำนำ</h4>
      </template>
      <div class="modal-body">
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">เลขที่บัตรจำนำ</b>
            <div>{{ pawn.pawn_no }}</div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">ผู้จำนำ</b>
            <div v-if="user[pawn.customer_id]">
              {{ user[pawn.customer_id][0].first_name }}
              {{ user[pawn.customer_id][0].last_name }}
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">จำนวนสินค้า</b>
            <div
              v-if="
                pawnItemsByPawnID[pawn.id] && pawnItemsByPawnID[pawn.id].length
              "
            >
              {{ pawnItemsByPawnID[pawn.id].length }}
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">ประวัติการจำนำ</b>
            <div>{{ pawn.pawn_no }}</div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">อัตราดอกเบี้ย</b>
            <div>{{ pawn.interest_rate }}</div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-6">
            <b class="ft-s-16">วันที่มาจำนำ</b>
            <div>
              {{ formatingDatetime(pawn.created_at, "DD MMM YYYY") }}
            </div>
          </div>
          <div class="col-6">
            <b class="ft-s-16">วันที่ต่อดอกล่าสุด</b>
            <div>
              {{ formatingDatetime(pawn.latest_paid_at, "DD MMM YYYY") }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <a href="#" class="ft-s-16" @click="showPawnItems(pawn.pawn_no)"
              >แสดงรายการภายในบัตร</a
            >
          </div>
        </div>
      </div>
      <template slot="modal-footer" class="modal-footer ml-3 mr-3">
        <button
          type="button"
          class="btn btn-secondary"
          @click="closePawnDetail(pawn.pawn_no)"
        >
          <a class="ft-s-16">ปิดหน้าต่าง</a>
        </button>
        <button
          type="button"
          class="btn btn-primary"
          @click="showPawnRenew(pawn.pawn_no)"
        >
          <a class="ft-s-16">ต่ออายุดอกเบี้ย</a>
        </button>
      </template>
    </b-modal>

    <!-- Modal แสดงรายการสินค้าภายในบัตร -->
    <b-modal :id="`pawn-list-item-modal-${pawn.pawn_no}`" no-close-on-backdrop>
      <template slot="modal-header" class="modal-header ml-3 mr-3">
        <h4>รายการสินค้าในบัตร</h4>
      </template>
      <div class="modal-body">
        <div class="row mb">
          <div class="col-12">
            <table class="table table-hover table-striped table-bordered mt-3">
              <thead class="thead-light">
                <tr>
                  <th scope="col">ประเภทของทอง</th>
                  <th scope="col">น้ำหนักทอง (กรัม)</th>
                  <th scope="col">มูลค่า (บาท)</th>
                  <th scope="col">ความเสียหาย</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(pawnItem, index) in pawnItemsByPawnID[pawn.id]"
                  :key="`pawn-item-${index}`"
                >
                  <th scope="row">
                    {{ pawnItem.item_category }}
                  </th>
                  <td>
                    {{ pawnItem.item_weight }}
                  </td>
                  <td>{{ pawnItem.item_value }}</td>
                  <td>
                    {{ pawnItem.item_damage }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <template slot="modal-footer" class="modal-footer ml-3 mr-3">
        <button
          type="button"
          class="btn btn-primary"
          @click="closePawnItems(pawn.pawn_no)"
        >
          <a class="ft-s-16">ปิดหน้าต่างนี้</a>
        </button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import Pawn from "../../../models/Pawn";
import { datetimeMixin, searchMixin } from "../../../mixins";

export default {
  mixins: [datetimeMixin, searchMixin],

  props: {
    pawn: new Pawn(),
  },

  methods: {
    showPawnRenew(id) {
      this.$bvModal.hide(`pawn-detail-modal-${id}`);
      this.$bvModal.show(`pawn-renew-modal-${id}`);
    },
    showPawnItems(id) {
      this.$bvModal.hide(`pawn-detail-modal-${id}`);
      this.$bvModal.show(`pawn-list-item-modal-${id}`);
    },
    closePawnDetail(id) {
      this.$bvModal.hide(`pawn-detail-modal-${id}`);
    },
    closePawnItems(id) {
      this.$bvModal.hide(`pawn-list-item-modal-${id}`);
      this.$bvModal.show(`pawn-detail-modal-${id}`);
    },
  },
};
</script>