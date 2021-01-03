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
        <div class="col-12">
          <div class="card card-box mb-5">
            <div class="card-header">
              <h5 class="my-3">ข้อมูลส่วนตัวลูกค้า</h5>
            </div>
            <div class="card-body">
              <form>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <b-form-group>
                      <b-input-group
                        class="input-group-seamless"
                        label="ค้นหาลูกค้า"
                        label-for="inputCustomer"
                      >
                        <b-form-input
                          name="customer"
                          type="text"
                          id="inputCustomer"
                          placeholder="ค้นโดยชื่อ เลขบัตรประชาชน หรือ เลขบัตรจำนำ"
                        ></b-form-input>
                        <b-input-group-text slot="append">
                          <font-awesome-icon class="mx-auto" icon="search" />
                        </b-input-group-text>
                      </b-input-group>
                    </b-form-group>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputFirstName">ชื่อ</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputFirstName"
                      name="firstname"
                    />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputLastName">สกุล</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputLastName"
                      name="lastname"
                    />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageTitle from "../../Layout/Components/PageTitle";

import { library } from "@fortawesome/fontawesome-svg-core";
import { faHandHoldingUsd, faSearch } from "@fortawesome/free-solid-svg-icons";

library.add(faHandHoldingUsd, faSearch);

export default {
  components: {
    PageTitle,
  },
};
</script>