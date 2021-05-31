<template>
  <b-form>
    <b-form-row v-if="searchable">
      <b-form-group class="col-md-12">
        <label for="inputCustomer">ค้นหาลูกค้า</label>
        <v-select
          v-model="$selectedUser"
          name="customer"
          id="inputCustomer"
          class="w-100"
          :options="options"
          @search="search"
          @input="check"
          @option:selected="error.clear()"
        >
          <template #open-indicator="{ attributes }">
            <span v-bind="attributes"></span>
          </template>
        </v-select>
      </b-form-group>
    </b-form-row>

    <b-form-row>
      <b-form-group class="col-sm-6" label-for="inputFirstname" label="ชื่อ">
        <b-form-input
          name="firstname"
          type="text"
          id="inputFirstname"
          v-model="user.first_name"
          :state="error.state('pawn.user.first_name')"
          @input="error.clear('pawn.user.first_name')"
        ></b-form-input>
        <b-form-invalid-feedback id="inputFirstname-feedback">
          {{ error.message("pawn.user.first_name") }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group class="col-sm-6" label-for="inputLastname" label="สกุล">
        <b-form-input
          name="lastname"
          type="text"
          id="inputLastname"
          :state="error.state('pawn.user.last_name')"
          @input="error.clear('pawn.user.last_name')"
          v-model="user.last_name"
        ></b-form-input>

        <b-form-invalid-feedback id="inputLastname-feedback">
          {{ error.message("pawn.user.last_name") }}
        </b-form-invalid-feedback>
      </b-form-group>

      <!-- <b-form-group
                    label="เพศ"
                    v-slot="{ ariaDescribedby }"
                    class="col-sm-6"
                  >
                    <b-form-radio-group
                      id="inputGender"
                      :options="genderOptions"
                      :aria-describedby="ariaDescribedby"
                      name="gender"
                      v-model="user.gender"
                    ></b-form-radio-group>
                  </b-form-group> -->

      <b-form-group
        class="col-sm-6"
        label-for="inputPhone"
        label="เบอร์โทรศัพท์"
      >
        <b-form-input
          name="phone"
          type="text"
          id="inputPhone"
          :state="error.state('pawn.user.phone_number')"
          @input="error.clear('pawn.user.phone_number')"
          v-model="user.phone_number"
        ></b-form-input>

        <b-form-invalid-feedback id="inputPhone-feedback">
          {{ error.message("pawn.user.phone_number") }}
        </b-form-invalid-feedback>
      </b-form-group>
    </b-form-row>

    <hr />

    <b-row>
      <b-col>
        <h6 class="text-black-50 mb-3">ข้อมูลเพิ่มเติมลูกค้า</h6>
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
          :state="error.state('pawn.user.identity_card_id')"
          @input="error.clear('pawn.user.identity_card_id')"
          v-model="user.identity_card_id"
        ></b-form-input>

        <b-form-invalid-feedback id="inputIdentityCardNo-feedback">
          {{ error.message("pawn.user.identity_card_id") }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group class="col-sm-6" label-for="inputEmail" label="Email">
        <b-form-input
          name="email"
          type="email"
          id="inputEmail"
          :state="error.state('pawn.user.email')"
          @input="error.clear('pawn.user.email')"
          v-model="user.email"
        ></b-form-input>

        <b-form-invalid-feedback id="inputEmail-feedback">
          {{ error.message("pawn.user.email") }}
        </b-form-invalid-feedback>
      </b-form-group>
    </b-form-row>

    <!-- <b-form-row>
                  <b-form-group
                    class="col-sm-6"
                    label-for="inputFacebook"
                    label="Facebook"
                  >
                    <b-form-input
                      name="facebook"
                      type="text"
                      id="inputFacebook"
                      v-model="user.facebook"
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
                      v-model="user.line"
                    ></b-form-input>
                  </b-form-group>
                </b-form-row> -->

    <b-form-row>
      <b-form-group class="col-sm-12" label-for="textareaNote" label="โน้ต">
        <b-form-textarea
          name="note"
          type="text"
          id="textareaNote"
          rows="3"
          max-rows="8"
          no-auto-shrink
          v-model="user.note"
        ></b-form-textarea>
      </b-form-group>
    </b-form-row>
  </b-form>
</template>

<script>
import { debounce } from "lodash";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faSearch } from "@fortawesome/free-solid-svg-icons";
import vSelect from "vue-select";
import User from "models/User";
import { disabledMixin, errorMixin, resetMixin } from "mixins";

library.add(faSearch);

export default {
  mixins: [disabledMixin, errorMixin, resetMixin],

  props: {
    searchable: {
      type: Boolean,
      default: true,
    },

    user: {
      type: User,
      default: () => new User(),
    },
  },

  model: {
    prop: "user",
    event: "change",
  },

  components: {
    vSelect,
  },

  watch: {
    reset(v) {
      if (v) {
        this.clear();
      }
    },
  },

  computed: {
    $selectedUser: {
      get() {
        return this.user ? this.user.full_name : null;
      },

      set(option) {
        const user =
          option !== null ? User.find(option.customerId) : new User();

        this.$emit("change", user);
      },
    },

    options() {
      const data = User.all();

      return data.reduce((carry, record) => {
        carry.push({ label: record.full_name, customerId: record.id });

        return carry;
      }, []);
    },
  },

  methods: {
    async search(keyword, loading) {
      if (!keyword.length) return;

      loading();

      try {
        await User.api().get("/", {
          params: {
            search: {
              keyword,
              fields: ["full_name"],
            },
          },
        });
      } catch (error) {
        console.error(error);
      } finally {
        loading();
      }
    },

    check(input) {
      if (!input) {
        this.clear();
      }
    },

    clear() {
      this.$selectedUser = null;
    },
  },

  created() {
    this.search = debounce(this.search, 500);
  },
};
</script>
