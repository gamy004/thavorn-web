<template>
  <div>
    <div class="page-title page-title--alt">
      <div class="row">
        <div class="col-xl-7 d-block d-xl-flex align-items-center">
          <div class="pr-0 pr-xl-4 mb-4 mb-xl-0">
            <div
              class="d-70 mx-auto rounded font-size-xxl bg-white text-center shadow-sm"
            >
              <font-awesome-icon icon="database" class="text-primary mt-1" />
            </div>
          </div>
          <div>
            <h5 class="display-4 mt-1 mb-2 font-weight-bold">ข้อมูลลูกค้า</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลลูกค้า</h5>
            </div>
            <div class="card-body">
              <b-table
                id="customerTable"
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
                <template #cell(created_at)="data">
                  {{ formatingDatetime(data.item.created_at, "DD MMM YYYY") }}
                </template>

                <template #cell(action)="data">
                  <b-button
                    variant="link"
                    size="sm"
                    class="p-0"
                    @click="showDetail(data.item)"
                  >
                    ดูรายละเอียด
                  </b-button>
                </template>
              </b-table>

              <b-pagination
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="perPage"
                aria-controls="customerTable"
              ></b-pagination>
            </div>
          </div>
        </div>
      </div>
    </div>

    <user-modal
      :user="showDetailUser"
      v-model="showModalUser"
      @success="toastUpdateUserSuccess = true"
      @fail="toastUpdateUserFail = true"
    ></user-modal>

    <b-toast
      id="pawn-close-toast-success"
      variant="success"
      solid
      no-close-button
      v-model="toastUpdateUserSuccess"
    >
      อัพเดตข้อมูลลูกค้าสำเร็จ
    </b-toast>

    <b-toast
      id="pawn-close-toast-fail"
      variant="danger"
      solid
      no-close-button
      v-model="toastUpdateUserFail"
    >
      อัพเดตข้อมูลลูกค้าไม่สำเร็จ
    </b-toast>
  </div>
</template>

<script>
import { datetimeMixin } from "../../mixins";
import User from "models/User";
import userModal from "../../components/users/modal";

export default {
  mixins: [datetimeMixin],

  components: {
    userModal,
  },

  data() {
    return {
      showDetailUser: new User(),
      showModalUser: false,
      loading: false,
      toastUpdateUserSuccess: false,
      toastUpdateUserFail: false,
      perPage: 20,
      currentPage: 1,
      totalRows: 0,
      fields: [
        { key: "identity_card_id", label: "เลขบัตรประชาชน" },
        { key: "first_name", label: "ชื่อ" },
        { key: "last_name", label: "นามสกุล" },
        { key: "phone_number", label: "เบอร์โทรศัพท์" },
        { key: "created_at", label: "วันที่สร้าง" },
        { key: "action", label: "", tdClass: "text-center" },
      ],
    };
  },

  watch: {
    showModalUser(v) {
      if (!v) {
        this.showDetailUser = new User();
      }
    },
  },

  methods: {
    async itemProvider() {
      let items = [];

      try {
        let promise;

        this.loading = true;

        promise = await User.api().get("/", {
          params: {
            page: this.currentPage,
            limit: this.perPage,
          },
        });

        const { total = 0, users = [] } = promise.response.data;

        this.totalRows = total;
        items = users;
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }

      return items;
    },

    showDetail(user) {
      this.showDetailUser = new User({ ...user });
      this.showModalUser = true;
    },
  },
};
</script>