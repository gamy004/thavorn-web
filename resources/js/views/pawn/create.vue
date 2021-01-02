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
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      id="inputEmail4"
                      placeholder="Email"
                    />
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputPassword46">Password</label>
                    <input
                      type="password"
                      class="form-control"
                      id="inputPassword46"
                      placeholder="Password"
                    />
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputPassword4">Location</label>
                    <input
                      type="text"
                      class="form-control"
                      disabled
                      id="inputPassword4"
                      placeholder="Disabled"
                    />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" id="inputCity" />
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputState">State</label>
                    <select id="inputState" class="form-control">
                      <option selected>Choose...</option>
                      <option>...</option>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="text" class="form-control" id="inputZip" />
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
import { faHandHoldingUsd } from "@fortawesome/free-solid-svg-icons";

library.add(faHandHoldingUsd);

export default {
  components: {
    PageTitle,
  },
};
</script>