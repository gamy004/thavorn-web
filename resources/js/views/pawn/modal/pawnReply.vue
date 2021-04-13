<template>
  <div>
    <b-modal
      v-model="show"
      :id="`pawn-reply-modal-${pawn.pawn_no}`"
      no-close-on-backdrop
    >
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
              {{ pawn.fullName }}
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">จำนวนสินค้า</b>
            <div>
              {{ pawn.count_items }}
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
            <b class="ft-s-16">รายการสินค้าจำนำ</b>
            <b-spinner
              v-if="loadingPawnItems"
              label="Fetching pawn items"
              variant="primary"
            ></b-spinner>

            <table
              v-else
              class="table table-hover table-striped table-bordered mt-3"
            >
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
                    {{ pawnItem.item_category.item_category }}
                  </th>
                  <td>
                    {{ pawnItem.item_weight }}
                  </td>
                  <td>{{ pawnItem.item_value }}</td>
                  <td>
                    {{ pawnItem.item_damage.item_damage }}
                  </td>
                </tr>
              </tbody>
            </table>
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
        <div class="row mb-4">
          <div class="col-6">
            <b class="ft-s-16">รวมมูลค่าสินค้า(บาท)</b>
            <div>{{ pawn.total_items_value }}</div>
          </div>
          <div class="col-6">
            <b class="ft-s-16">ดอกเบี้ย(บาท)</b>
            <b-spinner
              v-if="loadingPawnItems"
              label="Fetching pawn items"
              variant="primary"
            ></b-spinner>
            <div v-else>
              {{
                form.interest_value
                  ? `${form.interest_value}`
                  : "ไม่สามารถระบุได้"
              }}
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <h2>รวมยอดชำระ(บาท)</h2>
            <b-spinner
              v-if="loadingPawnItems"
              label="Fetching pawn items"
              variant="primary"
            ></b-spinner>
            <h5 v-else>
              {{
                form.close_amount ? `${form.close_amount}` : "ไม่สามารถระบุได้"
              }}
            </h5>
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
import { datetimeMixin, searchMixin } from "../../../mixins";
import Pawn from "../../../models/Pawn";
import Payment from "../../../models/Payment";
import PawnItem from "../../../models/PawnItem";
import PawnUserItem from "../../../models/PawnUserItem";

export default {
  mixins: [datetimeMixin, searchMixin],

  data() {
    return {
      loadingPawnItems: false,
      status: true,
      form: {
        close_amount: null,
        interest_value: null,
      },
    };
  },

  props: {
    show: {
      type: Boolean,
      default: false,
    },

    pawn: {
      type: PawnUserItem,
      default: () => new PawnUserItem(),
    },
  },

  model: {
    prop: "show",
    event: "change",
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

  methods: {
    closePawnReply(id) {
      // this.$bvModal.hide(`pawn-reply-modal-${id}`);
      this.$emit("change", false);
    },

    async fetch() {
      this.loadingPawnItems = true;
      let pawnDetailPromise, closeAmountResponse;

      try {
        // pawnDetailPromise = this.fetchPawnDetailByPawnId(this.pawn.id);
        // closeAmount = Pawn.api().getCloseAmount(this.pawn.id);

        [pawnDetailPromise, closeAmountResponse] = await Promise.all([
          this.fetchPawnDetailByPawnId(this.pawn.id),
          Pawn.api().getCloseAmount(this.pawn.id),
        ]);

        if (closeAmountResponse && closeAmountResponse.close_amount) {
          this.$set(
            this.form,
            "close_amount",
            closeAmountResponse.close_amount
          );
        }

        if (closeAmountResponse && closeAmountResponse.interest_value) {
          this.$set(
            this.form,
            "interest_value",
            closeAmountResponse.interest_value
          );
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.loadingPawnItems = false;
      }
    },
  },
};
</script>