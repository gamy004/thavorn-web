<template>
  <div>
    <b-modal
      v-model="show"
      :id="`pawn-renew-modal-${pawn.pawn_no}`"
      size="lg"
      no-close-on-backdrop
    >
      <template slot="modal-header" class="modal-header ml-3 mr-3">
        <h4>รายการต่ออายุดอกเบี้ย</h4>
      </template>
      <div class="modal-body">
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">เลือกเดือนที่ต่ออายุดอกเบี้ย</b>
            <div class="row">
              <div class="col-lg-6 my-2">
                <label for="date-picker-extend-from">เดือนที่เริ่ม</label>
                <datepicker
                  id="date-picker-extend-from"
                  :inline="true"
                  :bootstrap-styling="true"
                  wrapper-class="datepicker-wrapper-flush w-100"
                  calendar-class="datepicker datepicker-inline"
                  :language="th"
                  minimum-view="month"
                  maximum-view="month"
                  :disabledDates="disabledDateStart"
                  v-model="selectedDate.start"
                ></datepicker>
              </div>
              <div class="col-lg-6 my-2">
                <label for="date-picker-extend-from">เดือนที่สิ้นสุด</label>
                <datepicker
                  :inline="true"
                  :bootstrap-styling="true"
                  wrapper-class="datepicker-wrapper-flush w-100"
                  calendar-class="datepicker datepicker-inline"
                  :language="th"
                  minimum-view="month"
                  maximum-view="month"
                  :disabledDates="disabledDateEnd"
                  v-model="selectedDate.end"
                ></datepicker>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <b class="ft-s-16">สรุปเดือนที่ต่ออายุดอกเบี้ย</b>
            <div>
              {{ selectedMonthDescription }}
              {{
                form.month_amount
                  ? `(${form.month_amount} เดือน)`
                  : "ไม่สามารถระบุได้"
              }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h2>รวมยอดชำระ(บาท)</h2>
            <b-spinner
              v-if="checkingPaidAmount"
              label="Checking paid amount"
              variant="primary"
            ></b-spinner>
            <h5 v-else>
              {{
                form.paid_amount ? `${form.paid_amount}` : "ไม่สามารถระบุได้"
              }}
            </h5>
          </div>
        </div>
      </div>
      <template slot="modal-footer" class="modal-footer ml-3 mr-3">
        <button type="button" class="btn btn-secondary" @click="closePawnRenew">
          <span class="ft-s-16">ปิดหน้าต่าง</span>
        </button>
        <button type="button" class="btn btn-primary" @click.prevent="submit">
          <b-spinner v-if="submitting" label="Submitting extend"></b-spinner>
          <span v-else class="ft-s-16">ต่ออายุ</span>
        </button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import { th } from "vuejs-datepicker/dist/locale";
import Pawn from "../../../models/Pawn";
import { datetimeMixin, searchMixin } from "../../../mixins";

export default {
  mixins: [datetimeMixin, searchMixin],

  props: {
    pawn: new Pawn(),

    show: {
      type: Boolean,
      default: () => false,
    },
  },

  model: {
    prop: "show",
    event: "change",
  },

  components: {
    Datepicker,
  },

  data() {
    return {
      th,
      submitting: false,
      checkingPaidAmount: false,
      toastSuccess: false,
      selectedDate: {
        start: this.pawn
          ? new Date(
              this.pawn.next_paid_at
                ? this.pawn.next_paid_at
                : this.pawn.created_at
            )
          : null,
        end: null,
      },

      form: {
        month_amount: null,
        paid_amount: null,
      },
    };
  },

  watch: {
    "selectedDate.start": {
      immediate: true,
      handler: "onSelectedStartDateChanged",
    },
    "selectedDate.end": "onSelectedEndDateChanged",
    monthAmount: {
      immediate: true,
      handler: "onMonthAmountChanged",
    },
  },

  computed: {
    disabledDateTo() {
      const to = this.pawn
        ? new Date(
            this.pawn.next_paid_at
              ? this.pawn.next_paid_at
              : this.pawn.created_at
          )
        : null;

      return to;
    },

    disabledDateFrom() {
      const from = this.pawn
        ? new Date(
            this.pawn.latest_paid_at
              ? this.pawn.latest_paid_at
              : this.pawn.created_at
          )
        : null;

      return from;
    },

    disabledDateStart() {
      if (!this.pawn) return {};

      return {
        to: this.disabledDateTo,
        from: this.disabledDateFrom,
      };
    },

    disabledDateEnd() {
      if (!this.pawn) return {};

      let to = new Date(this.disabledDateTo);

      if (this.selectedDate && this.selectedDate.start) {
        to = new Date(this.selectedDate.start);
      }

      to.setMonth(to.getMonth() + 1);

      return {
        to,
      };
    },

    selectedMonthDescription() {
      const monthStart = this.formatingDatetime(
        this.selectedDate.start,
        "DD MMM YYYY"
      );

      const monthEnd = this.formatingDatetime(
        this.selectedDate.end,
        "DD MMM YYYY"
      );

      let description = monthStart;

      if (monthStart !== monthEnd) {
        description += ` - ${monthEnd}`;
      }

      return description;
    },

    monthAmount() {
      return this.diffMonth(this.selectedDate.start, this.selectedDate.end);
    },
  },

  methods: {
    closePawnRenew() {
      this.$emit("change", false);
    },

    onSelectedStartDateChanged(selectedStartDate) {
      if (selectedStartDate) {
        const selectedStartDateMonth = selectedStartDate.getMonth();

        const selectedEndDate = new Date(selectedStartDate);

        selectedEndDate.setMonth(selectedStartDateMonth + 1);

        this.$set(this.selectedDate, "end", selectedEndDate);
      }
    },

    onSelectedEndDateChanged(selectedEndDate) {
      const selectedStartDate = this.selectedDate.start;

      if (selectedEndDate) {
        const selectedStartDateDay = selectedStartDate.getDate();
        const selectedEndDateDay = selectedEndDate.getDate();

        if (selectedStartDateDay !== selectedEndDateDay) {
          selectedEndDate.setDate(selectedStartDateDay);

          this.$set(this.selectedDate, "end", selectedEndDate);
        }
      }
    },

    async onMonthAmountChanged(monthAmount) {
      if (!this.pawn || !monthAmount) return;

      let paidAmount;

      this.$set(this.form, "month_amount", monthAmount);

      this.checkingPaidAmount = true;

      try {
        paidAmount = await Pawn.api().getPaidAmount(
          this.pawn.id,
          this.form.month_amount
        );
      } catch (error) {
        console.error(error);
      } finally {
        setTimeout(() => {
          this.checkingPaidAmount = false;
        }, 500);
      }

      if (paidAmount) {
        this.$set(this.form, "paid_amount", paidAmount);
      }
    },

    async submit() {
      this.submitting = true;

      let res;

      try {
        res = await Pawn.api().extend(
          this.pawn.id,
          this.form.month_amount,
          this.form.paid_amount
        );
      } catch (error) {
        console.error(error);
      } finally {
        setTimeout(() => {
          this.submitting = false;
        }, 500);
      }

      setTimeout(() => {
        this.$emit("update:pawn", res);
      }, 500);
    },
  },
};
</script>