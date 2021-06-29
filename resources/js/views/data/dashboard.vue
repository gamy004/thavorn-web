<template>
  <div>
    <div class="page-title page-title--alt">
      <div class="row">
        <div class="col-xl-7 d-block d-xl-flex align-items-center">
          <div class="pr-0 pr-xl-4 mb-4 mb-xl-0">
            <div
              class="
                d-70
                mx-auto
                rounded
                font-size-xxl
                bg-white
                text-center
                shadow-sm
              "
            >
              <font-awesome-icon icon="columns" class="text-primary mt-1" />
            </div>
          </div>
          <div>
            <h5 class="display-4 mt-1 mb-2 font-weight-bold">ภาพรวม</h5>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-box mb-4">
            <div class="card-header justify-content-between">
              <h5 class="my-3">สรุปผลการจำนำ</h5>

              <div class="col-sm-8">
                <div class="row">
                  <div class="col-sm-6 my-2">
                    <b-form-group
                      id="startDateInput"
                      label-for="startDate"
                      class="mb-0"
                    >
                      <!-- <b-form-input
                        id="startDate"
                        v-model="name"
                        :state="state"
                        placeholder="วันที่เริ่มต้น"
                        trim
                      ></b-form-input> -->
                      <datepicker
                        id="date-picker-extend-from"
                        :inline="false"
                        :bootstrap-styling="true"
                        wrapper-class="datepicker-wrapper-flush w-100"
                        calendar-class="datepicker datepicker-inline"
                        :language="th"
                        minimum-view="day"
                        maximum-view="month"
                        placeholder="วันที่เริ่มต้น"
                        clear-button
                        v-model="selectedDate.start"
                      ></datepicker>
                    </b-form-group>
                  </div>
                  <div class="col-sm-6 my-2">
                    <b-form-group
                      id="endDateInput"
                      label-for="endDate"
                      class="mb-0"
                    >
                      <!-- <b-form-input
                        id="endDate"
                        v-model="name"
                        :state="state"
                        placeholder="วันที่สิ้นสุด"
                        trim
                      ></b-form-input> -->
                      <datepicker
                        id="date-picker-extend-from"
                        :inline="false"
                        :bootstrap-styling="true"
                        wrapper-class="datepicker-wrapper-flush w-100"
                        calendar-class="datepicker datepicker-inline"
                        :language="th"
                        minimum-view="day"
                        maximum-view="month"
                        placeholder="วันที่สิ้นสุด"
                        clear-button
                        v-model="selectedDate.end"
                      ></datepicker>
                    </b-form-group>
                  </div>
                </div>
              </div>
              <!-- <div class="form-group mb-0 col-md-6">
                <select id="inputState" class="form-control">
                  <option selected="selected">ทั้งหมด</option>
                  <option>ย้อนหลัง 1 เดือน</option>
                  <option>ย้อนหลัง 3 เดือน</option>
                  <option>ย้อนหลัง 5 เดือน</option>
                </select>
              </div> -->
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-4 col-md-6 col-sm-12">
                  <a
                    href="javascript:void(0);"
                    class="
                      my-2
                      card card-box card-box-border-bottom
                      border-primary
                      card-box-hover-rise-alt
                    "
                    ><div class="card-body">
                      <div class="align-box-row">
                        <div class="text-left">
                          <div class="mt-1">
                            <font-awesome-icon
                              icon="hand-holding-usd"
                              size="lg"
                            ></font-awesome-icon>
                          </div>
                          <div class="mt-3 line-height-sm">
                            <b class="font-size-lg text-black pr-1">{{
                              totalItemValue
                            }}</b>
                            <div class="text-black-50">ผลรวมยอดจำนำทั้งหมด</div>
                          </div>
                        </div>
                      </div>
                    </div></a
                  >
                </div>

                <div class="col-xl-4 col-md-6 col-sm-12">
                  <a
                    href="javascript:void(0);"
                    class="
                      my-2
                      card card-box card-box-border-bottom
                      border-success
                      card-box-hover-rise-alt
                    "
                    ><div class="card-body">
                      <div class="align-box-row">
                        <div class="text-left">
                          <div class="mt-1">
                            <font-awesome-icon
                              icon="hand-holding-usd"
                              size="lg"
                              class="text-success"
                            ></font-awesome-icon>
                          </div>
                          <div class="mt-3 line-height-sm">
                            <b class="font-size-lg text-black pr-1">{{
                              incompleteTotalItemValue
                            }}</b>
                            <div class="text-black-50">ยอดจำนำปัจจุบัน</div>
                          </div>
                        </div>
                      </div>
                    </div></a
                  >
                </div>

                <div class="col-xl-4 col-md-6 col-sm-12">
                  <a
                    href="javascript:void(0);"
                    class="
                      my-2
                      card card-box card-box-border-bottom
                      border-info
                      card-box-hover-rise-alt
                    "
                    ><div class="card-body">
                      <div class="align-box-row">
                        <div class="text-left">
                          <div class="mt-1">
                            <font-awesome-icon
                              icon="reply"
                              size="lg"
                              class="text-info"
                            ></font-awesome-icon>
                          </div>
                          <div class="mt-3 line-height-sm">
                            <b class="font-size-lg text-black pr-1">{{
                              completeTotalCloseValue
                            }}</b>
                            <div class="text-black-50">ยอดไถ่ถอนทั้งหมด</div>
                          </div>
                        </div>
                      </div>
                    </div></a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="col-xl-4 col-md-6 col-sm-12">
          <a
            href="javascript:void(0);"
            class="
              my-2
              card card-box card-box-border-bottom
              border-primary
              card-box-hover-rise-alt
            "
            ><div class="card-body">
              <div class="align-box-row">
                <div class="text-left">
                  <div class="mt-1">
                    <font-awesome-icon
                      icon="hand-holding-usd"
                      size="lg"
                    ></font-awesome-icon>
                  </div>
                  <div class="mt-3 line-height-sm">
                    <b class="font-size-lg text-black pr-1">234,000,000</b>
                    <div class="text-black-50">ผลรวมยอดจำนำทั้งหมด</div>
                  </div>
                </div>
              </div>
            </div></a
          >
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import { th } from "vuejs-datepicker/dist/locale";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faColumns,
  faHandHoldingUsd,
  faReply,
} from "@fortawesome/free-solid-svg-icons";
import Datepicker from "vuejs-datepicker";
import Pawn from "models/Pawn";

library.add(faColumns, faHandHoldingUsd, faReply);

export default {
  components: {
    Datepicker,
  },

  data() {
    return {
      th,
      fetching: false,
      selectedDate: {
        start: null,
        end: null,
      },
      totalItemValue: 0,
      incompleteTotalItemValue: 0,
      completeTotalCloseValue: 0,
    };
  },

  watch: {
    "selectedDate.start": "fetch",
    "selectedDate.end": "fetch",
  },

  methods: {
    async fetch() {
      let result,
        params = {};

      this.fetching = true;

      if (this.selectedDate.start) {
        this.$set(
          params,
          "time_start_at",
          this.selectedDate.start.toDateString()
        );
      }

      if (this.selectedDate.end) {
        this.$set(params, "time_end_at", this.selectedDate.end.toDateString());
      }

      try {
        result = await Pawn.api().get("/pawns/dashboard", {
          params,
          save: false,
        });
      } catch (error) {
        console.log(error);
      } finally {
        this.fetching = false;
      }

      const { response } = result;

      if (response && response.data) {
        const {
          total_item_value = null,
          incomplete_total_item_value = null,
          complete_total_close_value = null,
        } = response.data;

        this.totalItemValue = total_item_value || 0;
        this.incompleteTotalItemValue = incomplete_total_item_value || 0;
        this.completeTotalCloseValue = complete_total_close_value || 0;
      }
    },
  },

  mounted() {
    this.fetch();
  },
};
</script>