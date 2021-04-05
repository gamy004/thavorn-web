<template>
  <b-form>
    <b-form-row>
      <b-form-group class="col-md-12">
        <label for="inputCustomer">ค้นหาลูกค้า</label>
        <v-select
          name="customer"
          id="inputCustomer"
          class="w-100"
          :options="options"
          @search="search"
          @input="check"
          @option:selected="update"
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
          v-model="$user.first_name"
        ></b-form-input>
      </b-form-group>

      <b-form-group class="col-sm-6" label-for="inputLastname" label="สกุล">
        <b-form-input
          name="lastname"
          type="text"
          id="inputLastname"
          v-model="$user.last_name"
        ></b-form-input>
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
                      v-model="$user.gender"
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
          v-model="$user.phone_number"
        ></b-form-input>
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
          v-model="$user.identity_card_id"
        ></b-form-input>
      </b-form-group>

      <b-form-group class="col-sm-6" label-for="inputEmail" label="Email">
        <b-form-input
          name="email"
          type="email"
          id="inputEmail"
          v-model="$user.email"
        ></b-form-input>
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
                      v-model="$user.facebook"
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
                      v-model="$user.line"
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
          v-model="$user.note"
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

library.add(faSearch);

export default {
  props: {
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

  computed: {
    $user: {
      get() {
        return this.user;
      },

      set(user) {
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
        await User.api().get("users", {
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

    update(option) {
      const { customerId } = option;

      this.$user = User.find(customerId);
    },

    check(input) {
      if (!input) {
        this.clear();
      }
    },

    clear() {
      if (this.$user && this.$user.id) {
        this.$user = new User();
      }
    },
  },

  created() {
    this.search = debounce(this.search, 500);
  },
};
</script>
