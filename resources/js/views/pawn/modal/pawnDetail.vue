<template>
  <div>
    <b-modal
      v-model="show"
      :id="`pawn-detail-modal-${pawn.pawn_no}`"
      no-close-on-backdrop
    >
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
            <div>
              {{ pawn.fullName }}
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
            <ul class="ul__no-bullets mb-0">
              <li>
                {{ formatingDatetime(pawn.created_at, "DD MMM YYYY") }} -
                จำนำสินค้า
              </li>
              <template v-for="payment in payments">
                <li :key="`payment_${payment.id}`">
                  {{ payment.timeDescription }}
                </li>
              </template>
            </ul>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">อัตราดอกเบี้ย</b>
            <div>{{ pawn.interest_rate }} %</div>
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
            <b-spinner
              v-if="loadingPawnItems"
              label="Fetching pawn items"
              variant="primary"
            ></b-spinner>

            <b-button
              v-else
              variant="link"
              class="ft-s-16 pl-0"
              @click="showPawnItems"
              >แสดงรายการภายในบัตร</b-button
            >
          </div>
        </div>
      </div>
      <template slot="modal-footer" class="modal-footer ml-3 mr-3">
        <button
          type="button"
          class="btn btn-secondary"
          @click="closePawnDetail"
        >
          <a class="ft-s-16">ปิดหน้าต่าง</a>
        </button>
        <button type="button" class="btn btn-primary" @click="showPawnRenew">
          <a class="ft-s-16">ต่ออายุดอกเบี้ย</a>
        </button>
      </template>
    </b-modal>

    <!-- Modal แสดงรายการสินค้าภายในบัตร -->
    <b-modal
      v-model="showItems"
      :id="`pawn-list-item-modal-${pawn.pawn_no}`"
      no-close-on-backdrop
      no-fade
    >
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
                  v-for="(pawnItem, index) in pawnItems"
                  :key="`pawn-item-${index}`"
                >
                  <th scope="row">
                    {{
                      pawnItem.item_category
                        ? pawnItem.item_category.item_category
                        : "ไม่ระบุ"
                    }}
                  </th>
                  <td>
                    {{ pawnItem.item_weight }}
                  </td>
                  <td>{{ pawnItem.item_value }}</td>
                  <td>
                    {{
                      pawnItem.item_damage
                        ? pawnItem.item_damage.item_damage
                        : "ไม่ระบุ"
                    }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <template slot="modal-footer" class="modal-footer ml-3 mr-3">
        <button type="button" class="btn btn-primary" @click="closePawnItems">
          <a class="ft-s-16">ปิดหน้าต่างนี้</a>
        </button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import Payment from "../../../models/Payment";
import PawnUserItem from "../../../models/PawnUserItem";
import PawnItem from "../../../models/PawnItem";
import { datetimeMixin, searchMixin } from "../../../mixins";

export default {
  mixins: [datetimeMixin, searchMixin],

  props: {
    pawn: {
      type: PawnUserItem,
    },

    show: {
      type: Boolean,
      default: () => false,
    },
  },

  model: {
    prop: "show",
    event: "change",
  },

  data() {
    return {
      loadingPawnItems: false,
      showItems: false,
    };
  },

  watch: {
    show: {
      immediate: true,
      handler(v) {
        if (v) {
          this.fetch();
        }
      },
    },
  },

  methods: {
    showPawnRenew() {
      this.$emit("renew", this.pawn.pawn_no);
      // this.$bvModal.hide(`pawn-detail-modal-${this.pawn.pawn_no}`);
      // this.$bvModal.show(`pawn-renew-modal-${this.pawn.pawn_no}`);
    },
    async showPawnItems() {
      // this.$emit('change', false);
      this.showItems = true;
      // this.$bvModal.hide(`pawn-detail-modal-${this.pawn.pawn_no}`);
      // this.$bvModal.show(`pawn-list-item-modal-${this.pawn.pawn_no}`);
    },
    closePawnDetail() {
      this.$emit("change", false);
      // this.$bvModal.hide(`pawn-detail-modal-${this.pawn.pawn_no}`);
    },
    closePawnItems() {
      // this.$emit('change', true);
      this.showItems = false;
      // this.$bvModal.hide(`pawn-list-item-modal-${this.pawn.pawn_no}`);
      // this.$bvModal.show(`pawn-detail-modal-${this.pawn.pawn_no}`);
    },

    async fetch() {
      this.loadingPawnItems = true;

      try {
        await this.fetchPawnDetailByPawnId(this.pawn.id);
      } catch (error) {
        console.error(error);
      } finally {
        this.loadingPawnItems = false;
      }
    },
  },

  computed: {
    pawnItems() {
      return this.pawn && this.pawn.id
        ? PawnItem.query()
            .where("pawn_id", this.pawn.id)
            .where("complete", false)
            .with(["item_damage", "item_category"])
            .get()
        : [];
    },

    payments() {
      return this.pawn && this.pawn.id
        ? Payment.query().where("pawn_id", this.pawn.id).get()
        : [];
    },
  },
};
</script>