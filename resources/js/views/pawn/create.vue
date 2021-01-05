<template>
  <div>
    <div class="page-title page-title--alt">
      <div class="row">
        <div class="col-xl-7 d-block d-xl-flex align-items-center">
          <div class="pr-0 pr-xl-4 mb-4 mb-xl-0">
            <div
              class="d-70 mx-auto rounded font-size-xxl bg-white text-center shadow-sm"
            >
              <font-awesome-icon
                icon="hand-holding-usd"
                class="text-primary mt-1"
              />
            </div>
          </div>
          <div>
            <h5 class="display-4 mt-1 mb-2 font-weight-bold">การจำนำ</h5>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลส่วนตัวลูกค้า</h5>
            </div>
            <div class="card-body">
              <form>
                <div class="form-row">
                  <b-form-group class="col-md-12">
                    <label for="inputCustomer">ค้นหาลูกค้า</label>
                    <v-select
                      name="customer"
                      id="inputCustomer"
                      class="w-100"
                      :options="customerOptions"
                      @search="fetchCustomerOptions"
                    >
                      <template #open-indicator="{ attributes }">
                        <span v-bind="attributes"> </span>
                      </template>
                    </v-select>
                  </b-form-group>
                </div>
                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label for="inputFirstName">ชื่อ</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputFirstName"
                      name="firstname"
                    />
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputLastName">สกุล</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputLastName"
                      name="lastname"
                    />
                  </div>
                  <b-form-group
                    label="เพศ"
                    v-slot="{ ariaDescribedby }"
                    class="col-sm-6"
                  >
                    <b-form-radio-group
                      id="inputGender"
                      v-model="selectedGender"
                      :options="genderOptions"
                      :aria-describedby="ariaDescribedby"
                      name="gender"
                    ></b-form-radio-group>
                  </b-form-group>

                  <b-form-group
                    class="col-sm-6"
                    label-for="inputPhone"
                    label="เบอร์โทรศัพท์"
                  >
                    <b-form-input
                      name="phone"
                      type="text"
                      id="inputPhone"
                    ></b-form-input>
                  </b-form-group>
                </div>
                <hr />

                <b-row>
                  <b-col>
                    <h6 class="text-black-50">ข้อมูลเพิ่มเติมลูกค้า</h6>
                  </b-col>
                </b-row>

                <b-form-row>
                  <b-form-group
                    class="col-sm-6"
                    label-for="inputIdentityCardNo"
                    label="เลขบัตรประชาชน"
                  >
                    <b-form-input
                      name="identityCardNo"
                      type="text"
                      id="inputIdentityCardNo"
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    class="col-sm-6"
                    label-for="inputEmail"
                    label="Email"
                  >
                    <b-form-input
                      name="email"
                      type="email"
                      id="inputEmail"
                    ></b-form-input>
                  </b-form-group>
                </b-form-row>

                <b-form-row>
                  <b-form-group
                    class="col-sm-6"
                    label-for="inputFacebook"
                    label="Facebook"
                  >
                    <b-form-input
                      name="facebook"
                      type="text"
                      id="inputFacebook"
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    class="col-sm-6"
                    label-for="inputLine"
                    label="Line"
                  >
                    <b-form-input
                      name="Line"
                      type="text"
                      id="inputLine"
                    ></b-form-input>
                  </b-form-group>
                </b-form-row>

                <b-form-row>
                  <b-form-group
                    class="col-sm-12"
                    label-for="textareaNote"
                    label="โน้ต"
                  >
                    <b-form-textarea
                      name="note"
                      type="text"
                      id="textareaNote"
                      rows="3"
                      max-rows="8"
                      no-auto-shrink
                    ></b-form-textarea>
                  </b-form-group>
                </b-form-row>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-box">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลทอง</h5>
            </div>
            <div class="card-body"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "../../Layout/Components/PageTitle";
import { debounce } from "lodash";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faHandHoldingUsd, faSearch } from "@fortawesome/free-solid-svg-icons";
import vSelect from "vue-select";

library.add(faHandHoldingUsd, faSearch);

export default {
  components: {
    PageTitle,
    vSelect,
  },

  data() {
    return {
      selectedGender: "M",
      selectedCustomer: null,
      customerOptions: [],
      genderOptions: [
        { text: "ชาย", value: "M" },
        { text: "หญิง", value: "F" },
      ],
    };
  },

  methods: {
    fetchCustomerOptions(search, loading) {
      loading();

      setTimeout(() => {
        loading();
      }, 500);
    },
  },

  created() {
    this.fetchCustomerOptions = debounce(this.fetchCustomerOptions, 500);
  },
};
</script>