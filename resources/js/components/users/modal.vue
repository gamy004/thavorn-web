<template>
  <div>
    <b-modal v-model="show" id="modalUser" no-close-on-backdrop>
      <template slot="modal-header" class="modal-header ml-3 mr-3">
        <h4>ข้อมูลลูกค้า</h4>
      </template>

      <div class="modal-body">
        <user-form v-model="userForm" :searchable="false"></user-form>

        <evidence-uploader
          ref="evidenceUploader"
          v-if="user && user.id"
          :user-id="user.id"
        ></evidence-uploader>
      </div>

      <template slot="modal-footer" class="modal-footer ml-3 mr-3">
        <button
          type="button"
          class="btn btn-secondary"
          :disabled="
            ($refs.evidenceUploader
              ? $refs.evidenceUploader.isProcessing
              : false) || isUpdating
          "
          @click="close"
        >
          <b-spinner
            v-if="
              ($refs.evidenceUploader
                ? $refs.evidenceUploader.isProcessing
                : false) || isUpdating
            "
          ></b-spinner>

          <a v-else class="ft-s-16">ปิดหน้าต่าง</a>
        </button>
        <button
          type="button"
          class="btn btn-primary"
          :disabled="
            ($refs.evidenceUploader
              ? $refs.evidenceUploader.isProcessing
              : false) || isUpdating
          "
          @click="update"
        >
          <b-spinner
            v-if="
              ($refs.evidenceUploader
                ? $refs.evidenceUploader.isProcessing
                : false) || isUpdating
            "
          ></b-spinner>

          <a v-else class="ft-s-16">อัพเดต</a>
        </button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import User from "../../models/User";
import userForm from "./form";
import evidenceUploader from "./evidence-uploader";

export default {
  props: {
    user: {
      type: User,
      required: true,
    },

    show: {
      type: Boolean,
      default: () => false,
    },
  },

  model: {
    prop: "show",
    event: "change",
  },

  components: {
    evidenceUploader,
    userForm,
  },

  data() {
    return {
      userForm: this.user,
      isUpdating: false,
    };
  },

  watch: {
    user(v) {
      if (v) {
        this.userForm = v;
      }
    },
  },

  methods: {
    close() {
      this.$emit("change", false);
    },

    async update() {
      let promise;

      this.isUpdating = true;

      try {
        let { id, ...data } = this.userForm;

        promise = await User.api().update(id, data);

        this.$emit("success", promise);

        this.$emit("change", false);
      } catch (error) {
        this.$emit("fail", error);
      } finally {
        this.isUpdating = false;
      }
    },
  },
};
</script>