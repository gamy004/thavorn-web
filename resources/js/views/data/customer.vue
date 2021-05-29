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
              <b-spinner
                v-if="loading"
                label="Fetching pawn"
                variant="primary"
              ></b-spinner>
              <table
                v-else
                class="table table-hover table-striped table-bordered mt-3 mb-3"
              >
                <thead class="thead-light">
                  <tr>
                    <th scope="col">เลขบัตรประชาชน</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">นามสกุล</th>
                    <th scope="col">เบอร์โทรศัพท์</th>
                    <th scope="col">วันที่สร้าง</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, index) in users" :key="`user-${index}`">
                    <th scope="row">{{ user.identity_card_id }}</th>
                    <td>{{ user.first_name }}</td>
                    <td>{{ user.last_name }}</td>
                    <td>{{ user.phone_number }}</td>
                    <td>
                      {{ formatingDatetime(user.created_at, "DD MMM YYYY") }}
                    </td>
                    <td>
                      <b-button
                        variant="link"
                        size="sm"
                        class="p-0"
                        @click="showDetail(user)"
                      >
                        ดูรายละเอียด
                      </b-button>
                    </td>
                  </tr>
                </tbody>
              </table>
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
    };
  },

  watch: {
    showModalUser(v) {
      if (!v) {
        this.showDetailUser = new User();
      }
    },
  },

  computed: {
    users() {
      return User.all();
    },
  },

  methods: {
    async getUsers() {
      try {
        this.loading = true;

        await User.api().get("/");
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },

    showDetail(user) {
      this.showDetailUser = new User({ ...user });
      this.showModalUser = true;
    },
  },

  created() {
    this.getUsers();
  },
};
</script>