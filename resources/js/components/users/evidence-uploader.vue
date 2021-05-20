<template>
  <div class="row">
    <div class="col-12">
      <b-form-checkbox
        id="checkbox-pawn-card"
        v-model="status"
        name="checkbox-pawn-card"
        :value="false"
        :unchecked-value="true"
      >
        <h4>ไม่มีบัตรจำนำ</h4>
      </b-form-checkbox>

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
          v-on:vdropzone-thumbnail="onDropzoneThumbnail"
          v-on:vdropzone-error="onDropzoneError"
          v-on:vdropzone-success="onDropzoneSuccess"
          v-on:vdropzone-removed-file="onDropzoneRemovedFile"
        ></vue-dropzone>

        <button class="btn btn-primary btn-sm ml-3">อัพโหลด</button>
      </fieldset>
    </div>
  </div>
</template>

<script>
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import Evidence from "../../models/Evidence";
import User from "../../models/User";
import vue2Dropzone from "vue2-dropzone";

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

          const fileName = `หลักฐาน-${index}.${file.name.split(".").pop()}`;

          return fileName;
        },
        capture: true,
        acceptedFiles: "image/*",
      },
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
                <a class="dz-remove" href="javascript:undefined;" data-dz-remove>ลบไฟล์</a>
                <a class="dz-show" href="javascript:undefined;" data-dz-show>ดูภาพเต็มจอ</a>
                <a class="dz-download" href="javascript:undefined;" data-dz-download>ดาว์นโหลด</a>
            </div>
        `;
    },

    onDropzoneThumbnail(file, thumbnail) {
      if (file && file.previewElement && thumbnail) {
        const name = file.previewElement.querySelector("span[data-dz-name]");

        if (name) {
          name.innerText = file.upload.filename;
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
        }

        const showButton = file.previewElement.querySelector("a[data-dz-show]");

        if (showButton) {
          showButton.addEventListener("click", async () => {
            let blob;

            try {
              blob = await this.download(uploadedFile);
            } catch (error) {
              console.error(error);
            }

            window.open(URL.createObjectURL(blob));

            return blob;
          });
        }

        const downloadButton = file.previewElement.querySelector(
          "a[data-dz-download]"
        );

        if (downloadButton) {
          downloadButton.addEventListener("click", async () => {
            let blob;

            try {
              blob = await this.download(uploadedFile);
            } catch (error) {
              console.error(error);
            }

            const a = document.createElement("a");

            a.setAttribute("download", uploadedFile.original_name);
            a.setAttribute("href", URL.createObjectURL(blob));
            a.click();

            return blob;
          });
        }
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
          console.log(user);
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

    async onDropzoneRemovedFile(file) {
      let promise;

      try {
        promise = await Evidence.api().destroy(file.id);

        this.toastDeleteEvidenceSuccess = true;
      } catch (error) {
        console.error(error);
        this.toastDeleteEvidenceFail = true;
      }

      return promise;
    },
  },
};
</script>