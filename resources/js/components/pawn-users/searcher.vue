<template>
  <form>
    <div class="form-row">
      <label class="col-md-12" for="inputCustomerInfoExtend"
        >ค้นหาจากฐานข้อมูลลูกค้า</label
      >
    </div>
    <div class="form-row">
      <div class="col-sm-10">
        <b-form-input
          name="inputCustomerInfoExtend"
          type="text"
          id="inputCustomerInfoExtend"
          placeholder="ระบุชื่อ, นามสกุล, เลขบัตรประจำตัวประชาชน หรือเลขบัตรจำนำ"
          v-model="searchInput"
          :disabled="loading"
        ></b-form-input>
      </div>
      <div class="col-sm-2">
        <button
          class="btn btn-primary btn-md"
          :disabled="loading"
          @click.prevent="searchFn"
        >
          ค้นหา
        </button>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-xl-12 d-block">
        <h4 v-if="!search" style="text-align: center" class="text-black-50">
          กรุณากรอกข้อมูลเพื่อทำการค้นหา
        </h4>
        <div v-else>
          <b-spinner
            v-if="loading"
            label="Fetching pawn"
            variant="primary"
          ></b-spinner>
          <h4
            v-else-if="!loading && pawnUserItems && pawnUserItems.length == 0"
            style="text-align: center"
            class="text-black-50"
          >
            ไม่พบข้อมูลที่ต้องการ กรุณาตรวจสอบความถูกต้องอีกครั้ง
          </h4>
          <div
            v-else-if="!loading && pawnUserItems && pawnUserItems.length > 0"
          >
            <span>ผลการค้นหา</span>

            <slot
              name="search-result"
              v-bind:pawnUserItems="pawnUserItems"
            ></slot>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { datetimeMixin, searchMixin } from "../../mixins";

export default {
  mixins: [datetimeMixin, searchMixin],

  props: {
    searchFn: {
      type: Function,
      default: searchMixin.methods.searchPawnByCustomerData,
    },
  },
};
</script>
