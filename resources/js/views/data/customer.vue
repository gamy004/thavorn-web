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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                    v-for="(user, index) in users"
                                    :key="`user-${index}`"
                                    >
                                        <th scope="row"> {{ user.identity_card_id }} </th>
                                        <td> {{ user.first_name }} </td>
                                        <td> {{ user.last_name }} </td>
                                        <td> {{ user.phone_number }} </td>
                                        <td>
                                            {{
                                                formatingDatetime(
                                                    user.created_at,
                                                    "DD MMM YYYY"
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { datetimeMixin } from "../../mixins";
import User from "models/User";

export default {
  mixins: [datetimeMixin],

  components: {
    
  },

  data() {
    return {
        users: [],
        loading: false,
    };
  },
  computed: {},

  methods: {
      async getUsers(){
          try {
                this.loading = true;
                let { response } = await User.api().get("users");
                if (response && response.data && response.data.users){
                    this.users = response.data.users;
                }
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
      }
  },

  created(){
      this.getUsers()
  }
};
</script>