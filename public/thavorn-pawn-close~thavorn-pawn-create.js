(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["thavorn-pawn-close~thavorn-pawn-create"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/users/evidence-uploader.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/users/evidence-uploader.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue2_dropzone_dist_vue2Dropzone_min_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue2-dropzone/dist/vue2Dropzone.min.css */ "./node_modules/vue2-dropzone/dist/vue2Dropzone.min.css");
/* harmony import */ var vue2_dropzone_dist_vue2Dropzone_min_css__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue2_dropzone_dist_vue2Dropzone_min_css__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _models_Evidence__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../models/Evidence */ "./resources/js/models/Evidence.js");
/* harmony import */ var _models_User__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../models/User */ "./resources/js/models/User.js");
/* harmony import */ var vue2_dropzone__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue2-dropzone */ "./node_modules/vue2-dropzone/dist/vue2Dropzone.js");
/* harmony import */ var vue2_dropzone__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(vue2_dropzone__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _helper__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../helper */ "./resources/js/helper.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    userId: {
      type: Number,
      required: true
    }
  },
  components: {
    vueDropzone: vue2_dropzone__WEBPACK_IMPORTED_MODULE_4___default.a
  },
  data: function data() {
    var _this = this;

    return {
      status: true,
      isProcessing: false,
      dropzoneOptions: {
        url: "/api/files/upload/".concat(this.userId, "/evidences"),
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content
        },
        thumbnailMethod: "contain",
        thumbnailWidth: 500,
        thumbnailHeight: 500,
        previewTemplate: this.template(),
        renameFile: function renameFile(file) {
          var index = 1;

          var previews = _this.$refs.dropzoneIdCard.$refs.dropzoneElement.querySelectorAll(".dz-preview");

          if (previews) {
            index = previews.length + 1;
          }

          var user = _this.user;
          var fileName = "".concat(_this.user.evidenceFileNamePrefix, "-").concat(index, ".").concat(file.name.split(".").pop());
          return fileName;
        },
        capture: true,
        acceptedFiles: "image/*"
      },
      toastUploadEvidenceSuccess: false,
      toastUploadEvidenceFail: false,
      toastDeleteEvidenceSuccess: false,
      toastDeleteEvidenceFail: false
    };
  },
  watch: {
    userId: {
      immediate: true,
      handler: function handler(userId) {
        this.fetch(userId);
      }
    }
  },
  computed: {
    user: function user() {
      return _models_User__WEBPACK_IMPORTED_MODULE_3__["default"].query().find(this.userId);
    }
  },
  methods: {
    template: function template() {
      return "<div class=\"dz-preview dz-file-preview\">\n                <div class=\"dz-image\">\n                    <img data-dz-thumbnail />\n                </div>\n                <div class=\"dz-details\">\n                    <div class=\"dz-filename\"><span data-dz-name></span></div>\n                </div>\n                <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n                <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n                <a class=\"dz-custom-remove\" href=\"javascript:undefined;\" data-dz-custom-remove>\u0E25\u0E1A\u0E44\u0E1F\u0E25\u0E4C</a>\n                <a class=\"dz-show\" href=\"javascript:undefined;\" data-dz-show>\u0E14\u0E39\u0E20\u0E32\u0E1E\u0E40\u0E15\u0E47\u0E21\u0E08\u0E2D</a>\n                <a class=\"dz-download\" href=\"javascript:undefined;\" data-dz-download>\u0E14\u0E32\u0E27\u0E4C\u0E19\u0E42\u0E2B\u0E25\u0E14</a>\n            </div>\n        ";
    },
    onDropzoneThumbnail: function onDropzoneThumbnail(file, thumbnail) {
      if (file && file.previewElement && thumbnail) {
        var name = file.previewElement.querySelector("span[data-dz-name]");

        if (name) {
          if (file.upload) {
            name.innerText = file.upload.filename;
          }
        }
      }
    },
    onDropzoneError: function onDropzoneError(file, response) {
      this.toastUploadEvidenceFail = true;

      if (file && file.previewElement && response && response.message) {
        var errormessage = file.previewElement.querySelector("span[data-dz-errormessage]");

        if (errormessage) {
          errormessage.innerText = response.message;
        }
      }
    },
    onDropzoneSuccess: function onDropzoneSuccess(file, response) {
      this.toastUploadEvidenceSuccess = true;

      if (file && file.previewElement && response && response.files && response.files.length) {
        var uploadedFile = response.files[0];

        if (uploadedFile) {
          this.$set(file, "id", uploadedFile.id);
          this.$set(file, "mime", uploadedFile.mime);
          this.$set(file, "original_name", uploadedFile.original_name);
          this.$set(file, "path", uploadedFile.path);
        }

        this.bindEvent(file);
      }
    },
    bindEvent: function bindEvent(file) {
      var _this2 = this;

      var customRemoveButton = file.previewElement.querySelector("a[data-dz-custom-remove]");

      if (customRemoveButton) {
        customRemoveButton.addEventListener("click", /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
          var promise;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  _context.prev = 0;
                  _context.next = 3;
                  return _models_Evidence__WEBPACK_IMPORTED_MODULE_2__["default"].api().destroy(file.id);

                case 3:
                  promise = _context.sent;
                  _this2.toastDeleteEvidenceSuccess = true;

                  _this2.$refs.dropzoneIdCard.removeFile(file);

                  _context.next = 12;
                  break;

                case 8:
                  _context.prev = 8;
                  _context.t0 = _context["catch"](0);
                  console.error(_context.t0);
                  _this2.toastDeleteEvidenceFail = true;

                case 12:
                  return _context.abrupt("return", promise);

                case 13:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee, null, [[0, 8]]);
        })));
      }

      var showButton = file.previewElement.querySelector("a[data-dz-show]");

      if (showButton) {
        showButton.addEventListener("click", function () {
          window.open("".concat(window.location.origin, "/").concat(file.path));
        });
      }

      var downloadButton = file.previewElement.querySelector("a[data-dz-download]");

      if (downloadButton) {
        downloadButton.addEventListener("click", function () {
          var a = document.createElement("a");
          a.setAttribute("download", file.original_name);
          a.setAttribute("href", "".concat(window.location.origin, "/").concat(file.path));
          a.click();
        });
      }
    },
    fetch: function fetch(userId) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3() {
        var promise, user, _user$file_ids, file_ids, files;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.prev = 0;
                _context3.next = 3;
                return _models_User__WEBPACK_IMPORTED_MODULE_3__["default"].api().get("/".concat(userId), {
                  params: {
                    includes: ["files"]
                  }
                });

              case 3:
                promise = _context3.sent;
                user = _models_User__WEBPACK_IMPORTED_MODULE_3__["default"].query()["with"](["files"]).find(userId);

                if (user) {
                  _user$file_ids = user.file_ids, file_ids = _user$file_ids === void 0 ? [] : _user$file_ids;

                  if (file_ids.length) {
                    files = _models_Evidence__WEBPACK_IMPORTED_MODULE_2__["default"].findIn(file_ids);
                    files.forEach( /*#__PURE__*/function () {
                      var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2(file) {
                        var mockFile;
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
                          while (1) {
                            switch (_context2.prev = _context2.next) {
                              case 0:
                                mockFile = new File([Object(_helper__WEBPACK_IMPORTED_MODULE_5__["randStrlen"])(file.size)], file.original_name, {
                                  type: file.mime
                                });

                                _this3.$set(mockFile, "id", file.id);

                                _this3.$set(mockFile, "path", file.path);

                                _this3.$refs.dropzoneIdCard.manuallyAddFile(mockFile, "".concat(window.location.origin, "/").concat(file.path));

                              case 4:
                              case "end":
                                return _context2.stop();
                            }
                          }
                        }, _callee2);
                      }));

                      return function (_x) {
                        return _ref2.apply(this, arguments);
                      };
                    }());
                  }
                }

                _context3.next = 11;
                break;

              case 8:
                _context3.prev = 8;
                _context3.t0 = _context3["catch"](0);
                console.error(_context3.t0);

              case 11:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, null, [[0, 8]]);
      }))();
    },
    download: function download(file) {
      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee4() {
        var promise, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.next = 2;
                return _models_Evidence__WEBPACK_IMPORTED_MODULE_2__["default"].api().download(file.id);

              case 2:
                promise = _context4.sent;
                data = promise.response.data;
                return _context4.abrupt("return", new Blob([data], {
                  type: file.mime
                }));

              case 5:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    onDropzoneFileAdded: function onDropzoneFileAdded(file) {
      if (file.manuallyAdded) {
        this.bindEvent(file);
      }
    },
    onDropzoneProcessing: function onDropzoneProcessing() {
      this.isProcessing = true;
    },
    onDropzoneComplete: function onDropzoneComplete() {
      this.isProcessing = false;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/users/evidence-uploader.vue?vue&type=template&id=c9deb43c&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/users/evidence-uploader.vue?vue&type=template&id=c9deb43c& ***!
  \**************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "row" },
    [
      _c("div", { staticClass: "col-12" }, [
        _c(
          "fieldset",
          {
            staticClass: "mt-2",
            attrs: { id: "fieldset-checkbox-pawn-card", disabled: _vm.status }
          },
          [
            _c("b", [_vm._v("อัพโหลดหลักฐาน")]),
            _vm._v(" "),
            _c("vue-dropzone", {
              ref: "dropzoneIdCard",
              attrs: { id: "dropzone", options: _vm.dropzoneOptions },
              on: {
                "vdropzone-processing": _vm.onDropzoneProcessing,
                "vdropzone-complete": _vm.onDropzoneComplete,
                "vdropzone-thumbnail": _vm.onDropzoneThumbnail,
                "vdropzone-error": _vm.onDropzoneError,
                "vdropzone-success": _vm.onDropzoneSuccess,
                "vdropzone-file-added": _vm.onDropzoneFileAdded
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c(
        "b-toast",
        {
          attrs: {
            id: "evidence-upload-toast-success",
            variant: "success",
            solid: "",
            "no-close-button": ""
          },
          model: {
            value: _vm.toastUploadEvidenceSuccess,
            callback: function($$v) {
              _vm.toastUploadEvidenceSuccess = $$v
            },
            expression: "toastUploadEvidenceSuccess"
          }
        },
        [_vm._v("\n    อัพโหลดหลักฐานการจำนำสำเร็จเรียบร้อย\n  ")]
      ),
      _vm._v(" "),
      _c(
        "b-toast",
        {
          attrs: {
            id: "evidence-upload-toast-fail",
            variant: "danger",
            solid: "",
            "no-close-button": ""
          },
          model: {
            value: _vm.toastUploadEvidenceFail,
            callback: function($$v) {
              _vm.toastUploadEvidenceFail = $$v
            },
            expression: "toastUploadEvidenceFail"
          }
        },
        [_vm._v("\n    อัพโหลดหลักฐานการจำนำไม่สำเร็จ\n  ")]
      ),
      _vm._v(" "),
      _c(
        "b-toast",
        {
          attrs: {
            id: "evidence-delete-toast-success",
            variant: "success",
            solid: "",
            "no-close-button": ""
          },
          model: {
            value: _vm.toastDeleteEvidenceSuccess,
            callback: function($$v) {
              _vm.toastDeleteEvidenceSuccess = $$v
            },
            expression: "toastDeleteEvidenceSuccess"
          }
        },
        [_vm._v("\n    ลบหลักฐานการจำนำสำเร็จเรียบร้อย\n  ")]
      ),
      _vm._v(" "),
      _c(
        "b-toast",
        {
          attrs: {
            id: "evidence-delete-toast-fail",
            variant: "danger",
            solid: "",
            "no-close-button": ""
          },
          model: {
            value: _vm.toastDeleteEvidenceFail,
            callback: function($$v) {
              _vm.toastDeleteEvidenceFail = $$v
            },
            expression: "toastDeleteEvidenceFail"
          }
        },
        [_vm._v("\n    ลบหลักฐานการจำนำไม่สำเร็จ\n  ")]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/users/evidence-uploader.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/users/evidence-uploader.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _evidence_uploader_vue_vue_type_template_id_c9deb43c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./evidence-uploader.vue?vue&type=template&id=c9deb43c& */ "./resources/js/components/users/evidence-uploader.vue?vue&type=template&id=c9deb43c&");
/* harmony import */ var _evidence_uploader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./evidence-uploader.vue?vue&type=script&lang=js& */ "./resources/js/components/users/evidence-uploader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _evidence_uploader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _evidence_uploader_vue_vue_type_template_id_c9deb43c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _evidence_uploader_vue_vue_type_template_id_c9deb43c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/users/evidence-uploader.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/users/evidence-uploader.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/users/evidence-uploader.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_evidence_uploader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./evidence-uploader.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/users/evidence-uploader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_evidence_uploader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/users/evidence-uploader.vue?vue&type=template&id=c9deb43c&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/users/evidence-uploader.vue?vue&type=template&id=c9deb43c& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_evidence_uploader_vue_vue_type_template_id_c9deb43c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./evidence-uploader.vue?vue&type=template&id=c9deb43c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/users/evidence-uploader.vue?vue&type=template&id=c9deb43c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_evidence_uploader_vue_vue_type_template_id_c9deb43c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_evidence_uploader_vue_vue_type_template_id_c9deb43c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/helper.js":
/*!********************************!*\
  !*** ./resources/js/helper.js ***!
  \********************************/
/*! exports provided: randStrlen */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "randStrlen", function() { return randStrlen; });
function randStrlen(length) {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < length; i++) {
    text += possible.charAt(Math.floor(Math.random() * possible.length));
  }

  return text;
}

/***/ })

}]);