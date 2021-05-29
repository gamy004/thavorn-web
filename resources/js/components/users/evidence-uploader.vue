<template>
  <div class="row">
    <div class="col-12">
      <fieldset
        id="fieldset-checkbox-pawn-card"
        class="mt-2"
        :disabled="status"
      >
        <b>อัพโหลดหลักฐาน</b>

        <vue-dropzone
          ref="dropzoneIdCard"
          id="dropzone"
          :options="dropzoneOptions"
          v-on:vdropzone-processing="onDropzoneProcessing"
          v-on:vdropzone-complete="onDropzoneComplete"
          v-on:vdropzone-thumbnail="onDropzoneThumbnail"
          v-on:vdropzone-error="onDropzoneError"
          v-on:vdropzone-success="onDropzoneSuccess"
          v-on:vdropzone-file-added="onDropzoneFileAdded"
        ></vue-dropzone>
      </fieldset>
    </div>

    <b-toast
      id="evidence-upload-toast-success"
      variant="success"
      solid
      no-close-button
      v-model="toastUploadEvidenceSuccess"
    >
      อัพโหลดหลักฐานการจำนำสำเร็จเรียบร้อย
    </b-toast>

    <b-toast
      id="evidence-upload-toast-fail"
      variant="danger"
      solid
      no-close-button
      v-model="toastUploadEvidenceFail"
    >
      อัพโหลดหลักฐานการจำนำไม่สำเร็จ
    </b-toast>

    <b-toast
      id="evidence-delete-toast-success"
      variant="success"
      solid
      no-close-button
      v-model="toastDeleteEvidenceSuccess"
    >
      ลบหลักฐานการจำนำสำเร็จเรียบร้อย
    </b-toast>

    <b-toast
      id="evidence-delete-toast-fail"
      variant="danger"
      solid
      no-close-button
      v-model="toastDeleteEvidenceFail"
    >
      ลบหลักฐานการจำนำไม่สำเร็จ
    </b-toast>
  </div>
</template>

<script>
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import Evidence from "../../models/Evidence";
import User from "../../models/User";
import vue2Dropzone from "vue2-dropzone";
import { randStrlen } from "../../helper";

export default {
  props: {
    userId: {
      type: Number,
      required: true,
    },
  },

  components: {
    vueDropzone: vue2Dropzone,
  },

  data() {
    return {
      status: true,
      isProcessing: false,
      dropzoneOptions: {
        url: `/api/files/upload/${this.userId}/evidences`,
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]')
            .content,
        },
        thumbnailMethod: "contain",
        thumbnailWidth: 500,
        thumbnailHeight: 500,
        previewTemplate: this.template(),
        renameFile: (file) => {
          let index = 1;
          const previews = this.$refs.dropzoneIdCard.$refs.dropzoneElement.querySelectorAll(
            ".dz-preview"
          );

          if (previews) {
            index = previews.length + 1;
          }

          const { user } = this;

          const fileName = `${
            this.user.evidenceFileNamePrefix
          }-${index}.${file.name.split(".").pop()}`;

          return fileName;
        },
        capture: true,
        acceptedFiles: "image/*",
      },
      toastUploadEvidenceSuccess: false,
      toastUploadEvidenceFail: false,
      toastDeleteEvidenceSuccess: false,
      toastDeleteEvidenceFail: false,
    };
  },

  watch: {
    userId: {
      immediate: true,
      handler(userId) {
        this.fetch(userId);
      },
    },
  },

  computed: {
    user() {
      return User.query().find(this.userId);
    },
  },

  methods: {
    template() {
      return `<div class="dz-preview dz-file-preview">
                <div class="dz-image">
                    <img data-dz-thumbnail />
                </div>
                <div class="dz-details">
                    <div class="dz-filename"><span data-dz-name></span></div>
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
                <a class="dz-custom-remove" href="javascript:undefined;" data-dz-custom-remove>ลบไฟล์</a>
                <a class="dz-show" href="javascript:undefined;" data-dz-show>ดูภาพเต็มจอ</a>
                <a class="dz-download" href="javascript:undefined;" data-dz-download>ดาว์นโหลด</a>
            </div>
        `;
    },

    onDropzoneThumbnail(file, thumbnail) {
      if (file && file.previewElement && thumbnail) {
        const name = file.previewElement.querySelector("span[data-dz-name]");

        if (name) {
          if (file.upload) {
            name.innerText = file.upload.filename;
          }
        }
      }
    },

    onDropzoneError(file, response) {
      this.toastUploadEvidenceFail = true;

      if (file && file.previewElement && response && response.message) {
        const errormessage = file.previewElement.querySelector(
          "span[data-dz-errormessage]"
        );

        if (errormessage) {
          errormessage.innerText = response.message;
        }
      }
    },

    onDropzoneSuccess(file, response) {
      this.toastUploadEvidenceSuccess = true;

      if (
        file &&
        file.previewElement &&
        response &&
        response.files &&
        response.files.length
      ) {
        const uploadedFile = response.files[0];

        if (uploadedFile) {
          this.$set(file, "id", uploadedFile.id);
          this.$set(file, "mime", uploadedFile.mime);
          this.$set(file, "original_name", uploadedFile.original_name);
          this.$set(file, "path", uploadedFile.path);
        }

        this.bindEvent(file);
      }
    },

    bindEvent(file) {
      const customRemoveButton = file.previewElement.querySelector(
        "a[data-dz-custom-remove]"
      );

      if (customRemoveButton) {
        customRemoveButton.addEventListener("click", async () => {
          let promise;

          try {
            promise = await Evidence.api().destroy(file.id);

            this.toastDeleteEvidenceSuccess = true;

            this.$refs.dropzoneIdCard.removeFile(file);
          } catch (error) {
            console.error(error);
            this.toastDeleteEvidenceFail = true;
          }

          return promise;
        });
      }

      const showButton = file.previewElement.querySelector("a[data-dz-show]");

      if (showButton) {
        showButton.addEventListener("click", () => {
          window.open(`${window.location.origin}/${file.path}`);
        });
      }

      const downloadButton = file.previewElement.querySelector(
        "a[data-dz-download]"
      );

      if (downloadButton) {
        downloadButton.addEventListener("click", () => {
          const a = document.createElement("a");

          a.setAttribute("download", file.original_name);
          a.setAttribute("href", `${window.location.origin}/${file.path}`);
          a.click();
        });
      }
    },

    async fetch(userId) {
      let promise;

      try {
        promise = await User.api().get(`/${userId}`, {
          params: {
            includes: ["files"],
          },
        });

        const user = User.query().with(["files"]).find(userId);

        if (user) {
          const { file_ids = [] } = user;

          if (file_ids.length) {
            const files = Evidence.findIn(file_ids);

            files.forEach(async (file) => {
              const mockFile = new File(
                [randStrlen(file.size)],
                file.original_name,
                {
                  type: file.mime,
                }
              );

              this.$set(mockFile, "id", file.id);
              this.$set(mockFile, "path", file.path);

              this.$refs.dropzoneIdCard.manuallyAddFile(
                mockFile,
                `${window.location.origin}/${file.path}`
              );
            });
          }
        }
      } catch (error) {
        console.error(error);
      }
    },

    async download(file) {
      let promise;

      promise = await Evidence.api().download(file.id);

      const { data } = promise.response;

      return new Blob([data], { type: file.mime });
    },

    onDropzoneFileAdded(file) {
      if (file.manuallyAdded) {
        this.bindEvent(file);
      }
    },

    onDropzoneProcessing() {
      this.isProcessing = true;
    },

    onDropzoneComplete() {
      this.isProcessing = false;
    },
  },
};
</script>