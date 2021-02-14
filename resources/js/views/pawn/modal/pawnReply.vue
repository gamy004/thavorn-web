<template>
  <div>
    <b-modal :id="`pawn-reply-modal-${pawn.pawn_no}`" no-close-on-backdrop>
      <template slot="modal-header" class="modal-header ml-3 mr-3">
        <h4>สรุปรายการไถ่ถอน</h4>
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
            <div>
              {{ fullNameByPawnNo(pawn.pawn_no) }}
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">จำนวนสินค้า</b>
            <div>
              {{ pawnItemCount(pawn.pawn_no) }}
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">รายการสินค้าจำนำ</b>
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
                  v-for="(pawnItem, index) in pawnItemByPawnNo(pawn.pawn_no)"
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
        <div class="row mb-4">
          <div class="col-6">
            <b class="ft-s-16">รวมมูลค่าสินค้า(บาท)</b>
            <div>{{ sumPawnItemValueByPawnNo(pawn.pawn_no) }}</div>
          </div>
          <div class="col-6">
            <b class="ft-s-16">ดอกเบี้ย(บาท)</b>
            <div>{{ pawn.pawn_no }}</div>
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
              :id="`checkbox-pawn-card-${pawn.pawn_no}`"
              v-model="status"
              :name="`checkbox-pawn-card-${pawn.pawn_no}`"
              :value="false"
              :unchecked-value="true"
            >
              <h4>ไม่มีบัตรจำนำ</h4>
            </b-form-checkbox>
            <fieldset
              :id="`fieldset-checkbox-pawn-card-${pawn.pawn_no}`"
              class="mt-2"
              :disabled="status"
            >
              <b>อัพโหลดหลักฐาน</b>
              <button class="btn btn-primary btn-sm ml-3">อัพโหลด</button>
            </fieldset>
          </div>
        </div>
      </div>
      <template slot="modal-footer" class="modal-footer ml-3 mr-3">
        <button
          type="button"
          class="btn btn-secondary"
          @click="closePawnReply(pawn.pawn_no)"
        >
          <a class="ft-s-16">ปิดหน้าต่าง</a>
        </button>
        <button type="button" class="btn btn-success">
          <a class="ft-s-16">ไถ่ถอน</a>
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

  data() {
    return {
      status: true,
    };
  },

  props: {
    pawn: new Pawn(),
  },

  methods: {
    closePawnReply(id) {
      this.$bvModal.hide(`pawn-reply-modal-${id}`);
    },
  },
};
</script>