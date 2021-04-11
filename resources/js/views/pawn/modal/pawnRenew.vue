<template>
  <div>
    <b-modal :id="`pawn-renew-modal-${pawn.pawn_no}`" no-close-on-backdrop>
      <template slot="modal-header" class="modal-header ml-3 mr-3">
        <h4>รายการต่ออายุดอกเบี้ย</h4>
      </template>
      <div class="modal-body">
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">เลือกเดือนที่ต่ออายุ</b>
            <datepicker
              :inline="true"
              :bootstrap-styling="true"
              wrapper-class="datepicker-wrapper-flush"
              calendar-class="datepicker datepicker-inline"
              :language="th"
              minimum-view="month"
              maximum-view="month"></datepicker>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">สรุปเดือนที่ต่ออายุดอกเบี้ย</b>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h2>รวมยอดชำระ(บาท)</h2>
          </div>
        </div>
      </div>
      <template slot="modal-footer" class="modal-footer ml-3 mr-3">
        <button
          type="button"
          class="btn btn-secondary"
          @click="closePawnRenew(pawn.pawn_no)"
        >
          <a class="ft-s-16">ปิดหน้าต่าง</a>
        </button>
        <button type="button" class="btn btn-success">
          <a class="ft-s-16">ต่ออายุ</a>
        </button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import { th } from 'vuejs-datepicker/dist/locale';
import Pawn from "../../../models/Pawn";
import { datetimeMixin, searchMixin } from "../../../mixins";

export default {
  mixins: [datetimeMixin, searchMixin],

  props: {
    pawn: new Pawn(),
  },

  components: {
    Datepicker
  },

  data() {
    return {
      th
    }
  },

  methods: {
    closePawnRenew(id) {
      this.$bvModal.hide(`pawn-renew-modal-${id}`);
    },
  },
};
</script>