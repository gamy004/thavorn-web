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
          @keyup.enter="refresh"
        ></b-form-input>
      </div>
      <div class="col-sm-2">
        <button
          class="btn btn-primary btn-md"
          :disabled="loading"
          @click.prevent="refresh"
        >
          ค้นหา
        </button>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-xl-12 d-block">
        <!-- <slot
          name="search-result"
          v-bind:loading="loading"
          v-bind:itemProvider="searchFn"
          v-bind:pawnUserItems="pawnUserItems"
          v-bind:closabledPawnUserItems="closabledPawnUserItems"
        ></slot> -->
        <b-table
          id="pawnTable"
          ref="pawnTable"
          class="mt-3 mb-5"
          hover
          striped
          bordered
          :fields="fields"
          :items="itemProvider"
          :per-page="perPage"
          :current-page="currentPage"
          :table-busy="loading"
        >
          <slot></slot>
          <template
            v-for="(_, name) in $scopedSlots"
            :slot="name"
            slot-scope="data"
          >
            <slot :name="name" v-bind="data" />
          </template>
        </b-table>

        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          aria-controls="pawnTable"
        ></b-pagination>
      </div>
    </div>
  </form>
</template>

<script>
import { datetimeMixin, searchMixin } from "../../mixins";

export default {
  mixins: [datetimeMixin, searchMixin],

  props: {
    fields: {
      type: Array,
      default: [],
    },

    searchFn: {
      type: String,
      default: "searchPawnByCustomerData",
    },
  },

  methods: {
    itemProvider() {
      return this[this.searchFn]();
    },

    refresh() {
      return this.$refs.pawnTable.refresh();
    },
  },
};
</script>
