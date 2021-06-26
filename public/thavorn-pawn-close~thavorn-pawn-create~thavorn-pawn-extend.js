(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["thavorn-pawn-close~thavorn-pawn-create~thavorn-pawn-extend"],{

/***/ "./resources/js/core/Base.js":
/*!***********************************!*\
  !*** ./resources/js/core/Base.js ***!
  \***********************************/
/*! exports provided: get, set, toggle, helper, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "get", function() { return _get2; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "set", function() { return set; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toggle", function() { return _toggle; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "helper", function() { return helper; });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



function _get2(data, key) {
  var defval = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  return Object(lodash__WEBPACK_IMPORTED_MODULE_0__["get"])(data, key, defval);
}


function set(data) {
  var key = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
  var value = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

  if (_typeof(key) == 'object' && !value) {
    for (var k in key) {
      if (key.hasOwnProperty(k)) {
        Object(lodash__WEBPACK_IMPORTED_MODULE_0__["set"])(data, k, _get2(key, k));
      }
    }
  } else if (value === null) {
    data = key;
  } else {
    Object(lodash__WEBPACK_IMPORTED_MODULE_0__["set"])(data, key, value);
  }
}

function _toggle(data) {
  var key = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

  if (data.hasOwnProperty(key)) {
    data[key] = !data[key];
  }

  return data;
}


var helper = {
  get: _get2,
  set: set,
  toggle: _toggle
};

var Base = /*#__PURE__*/function () {
  function Base() {//

    _classCallCheck(this, Base);
  }

  _createClass(Base, [{
    key: "get",
    value: function get(key) {
      var defval = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      return _get2(this, key, defval);
    }
  }, {
    key: "set",
    value: function set(key, value) {
      this[key] = value;
    }
  }, {
    key: "toggle",
    value: function toggle(key) {
      _toggle(this, key);
    }
  }, {
    key: "has",
    value: function has(key) {
      return this.get(key) !== null;
    }
  }, {
    key: "remember",
    value: function remember(key, fn) {
      if (!this.has(key)) {
        this.set(key, fn);
      }

      return this.get(key);
    } // set data(object = {}) {
    //     this.$data = {
    //         ...this.$data,
    //         ...object
    //     };
    //     this.backup = {
    //         ...this.$data
    //     };
    //     for (let field in object) {
    //         this[field] = object[field]
    //     }
    // }
    // get data() {
    //     let data = {};
    //     for (let property in this.$data) {
    //         data[property] = this[property];
    //     }
    //     return data;
    // }

  }]);

  return Base;
}();

/* harmony default export */ __webpack_exports__["default"] = (Base);

/***/ }),

/***/ "./resources/js/core/Error.js":
/*!************************************!*\
  !*** ./resources/js/core/Error.js ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Base__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Base */ "./resources/js/core/Base.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }




var Error = /*#__PURE__*/function (_Base) {
  _inherits(Error, _Base);

  var _super = _createSuper(Error);

  function Error() {
    var _this;

    var _ref = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
        _ref$errors = _ref.errors,
        errors = _ref$errors === void 0 ? {} : _ref$errors;

    _classCallCheck(this, Error);

    _this = _super.call(this);
    _this.errors = {};

    _this.record(errors);

    return _this;
  }

  _createClass(Error, [{
    key: "record",
    value: function record(errors) {
      this.clear();
      this.errors = _objectSpread({}, errors);
      return this;
    }
  }, {
    key: "add",
    value: function add(errors) {
      this.errors = _objectSpread(_objectSpread({}, this.errors), errors);
      return this;
    }
  }, {
    key: "recordResponse",
    value: function recordResponse(response) {
      if (response && response.data) {
        var _response$data$errors = response.data.errors,
            errors = _response$data$errors === void 0 ? {} : _response$data$errors;
        this.record(errors);
      }

      return this;
    }
  }, {
    key: "all",
    value: function all() {
      return this.errors;
    }
  }, {
    key: "message",
    value: function message(error) {
      var message;
      var target = this.has(error) ? this.errors[error] : this.get("errors.".concat(error), null);

      if (target && Object(lodash__WEBPACK_IMPORTED_MODULE_0__["isArray"])(target) && target.length) {
        message = target[0];
      }

      return message;
    }
  }, {
    key: "has",
    value: function has(error) {
      return this.errors.hasOwnProperty(error);
    }
  }, {
    key: "state",
    value: function state(error) {
      var hasError = this.has(error);
      return hasError ? false : null;
    }
  }, {
    key: "clear",
    value: function clear() {
      var error = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;

      if (error) {
        if (this.errors[error]) {
          if (!Object(lodash__WEBPACK_IMPORTED_MODULE_0__["isArray"])(error)) {
            error = [error];
          }

          this.errors = Object(lodash__WEBPACK_IMPORTED_MODULE_0__["omit"])(this.errors, error);
        }
      } else {
        this.errors = {};
      }

      return this;
    }
  }], [{
    key: "make",
    value: function make() {
      var _ref2 = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
          _ref2$errors = _ref2.errors,
          errors = _ref2$errors === void 0 ? {} : _ref2$errors;

      return new Error({
        errors: errors
      });
    }
  }]);

  return Error;
}(_Base__WEBPACK_IMPORTED_MODULE_1__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (Error);

/***/ }),

/***/ "./resources/js/mixins/datetimeMixin.js":
/*!**********************************************!*\
  !*** ./resources/js/mixins/datetimeMixin.js ***!
  \**********************************************/
/*! exports provided: datetimeMixin */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "datetimeMixin", function() { return datetimeMixin; });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment_timezone__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment-timezone */ "./node_modules/moment-timezone/index.js");
/* harmony import */ var moment_timezone__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment_timezone__WEBPACK_IMPORTED_MODULE_1__);


var datetimeMixin = {
  computed: {
    /**
     * Get now date-time
     * only two arguments: ["format", "toISOString"]
     * 
     * @type {String}
     */
    today: function today() {
      return function (format) {
        return moment__WEBPACK_IMPORTED_MODULE_0___default()()[format]();
      };
    },
    cityTimezone: function cityTimezone() {
      var userTimezone = moment__WEBPACK_IMPORTED_MODULE_0___default.a.tz.guess();
      return userTimezone.substr(userTimezone.indexOf("/") + 1);
    },
    formatingDatetime: function formatingDatetime() {
      return function (datetime, format) {
        moment__WEBPACK_IMPORTED_MODULE_0___default.a.locale('th'); // if (moment(datetime).format('hh') === '12') {
        //   let date = moment(datetime).format("DD MMM YYYY")
        //   let minute = moment(datetime).format("hh:mma").substr(2)
        //   return `${date} 00${minute}`
        // }

        var formattedDatetime = datetime ? moment__WEBPACK_IMPORTED_MODULE_0___default()(datetime).add(543, 'year').format(format) : 'ไม่ระบุ';
        return formattedDatetime;
      };
    }
  },
  methods: {
    diffMonth: function diffMonth(monthStart, monthEnd) {
      return moment__WEBPACK_IMPORTED_MODULE_0___default()(monthEnd).diff(moment__WEBPACK_IMPORTED_MODULE_0___default()(monthStart), 'months');
    }
  }
};

/***/ }),

/***/ "./resources/js/mixins/disabledMixin.js":
/*!**********************************************!*\
  !*** ./resources/js/mixins/disabledMixin.js ***!
  \**********************************************/
/*! exports provided: disabledMixin, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "disabledMixin", function() { return disabledMixin; });
var disabledMixin = {
  props: {
    disabled: {
      type: Boolean,
      "default": function _default() {
        return false;
      }
    }
  }
};
/* harmony default export */ __webpack_exports__["default"] = (disabledMixin);

/***/ }),

/***/ "./resources/js/mixins/errorMixin.js":
/*!*******************************************!*\
  !*** ./resources/js/mixins/errorMixin.js ***!
  \*******************************************/
/*! exports provided: errorMixin, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "errorMixin", function() { return errorMixin; });
/* harmony import */ var core_Error__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core/Error */ "./resources/js/core/Error.js");

var errorMixin = {
  props: {
    error: {
      type: core_Error__WEBPACK_IMPORTED_MODULE_0__["default"],
      "default": function _default() {
        return core_Error__WEBPACK_IMPORTED_MODULE_0__["default"].make();
      }
    }
  }
};
/* harmony default export */ __webpack_exports__["default"] = (errorMixin);

/***/ }),

/***/ "./resources/js/mixins/index.js":
/*!**************************************!*\
  !*** ./resources/js/mixins/index.js ***!
  \**************************************/
/*! exports provided: disabledMixin, datetimeMixin, errorMixin, searchMixin, resetMixin */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _disabledMixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./disabledMixin */ "./resources/js/mixins/disabledMixin.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "disabledMixin", function() { return _disabledMixin__WEBPACK_IMPORTED_MODULE_0__["disabledMixin"]; });

/* harmony import */ var _datetimeMixin__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./datetimeMixin */ "./resources/js/mixins/datetimeMixin.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "datetimeMixin", function() { return _datetimeMixin__WEBPACK_IMPORTED_MODULE_1__["datetimeMixin"]; });

/* harmony import */ var _errorMixin__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./errorMixin */ "./resources/js/mixins/errorMixin.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "errorMixin", function() { return _errorMixin__WEBPACK_IMPORTED_MODULE_2__["errorMixin"]; });

/* harmony import */ var _searchMixin__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./searchMixin */ "./resources/js/mixins/searchMixin.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "searchMixin", function() { return _searchMixin__WEBPACK_IMPORTED_MODULE_3__["searchMixin"]; });

/* harmony import */ var _resetMixin__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./resetMixin */ "./resources/js/mixins/resetMixin.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "resetMixin", function() { return _resetMixin__WEBPACK_IMPORTED_MODULE_4__["resetMixin"]; });








/***/ }),

/***/ "./resources/js/mixins/resetMixin.js":
/*!*******************************************!*\
  !*** ./resources/js/mixins/resetMixin.js ***!
  \*******************************************/
/*! exports provided: resetMixin, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "resetMixin", function() { return resetMixin; });
var resetMixin = {
  props: {
    reset: {
      type: Boolean,
      "default": function _default() {
        return false;
      }
    }
  }
};
/* harmony default export */ __webpack_exports__["default"] = (resetMixin);

/***/ }),

/***/ "./resources/js/mixins/searchMixin.js":
/*!********************************************!*\
  !*** ./resources/js/mixins/searchMixin.js ***!
  \********************************************/
/*! exports provided: searchMixin */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "searchMixin", function() { return searchMixin; });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _models_Pawn__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../models/Pawn */ "./resources/js/models/Pawn.js");
/* harmony import */ var _models_PawnItem__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../models/PawnItem */ "./resources/js/models/PawnItem.js");
/* harmony import */ var _models_User__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../models/User */ "./resources/js/models/User.js");
/* harmony import */ var _models_PawnUserItem__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../models/PawnUserItem */ "./resources/js/models/PawnUserItem.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_5__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }






var searchMixin = {
  data: function data() {
    return {
      perPage: 20,
      currentPage: 1,
      totalRows: 0,
      searchInput: "",
      search: false,
      loading: false,
      items: {}
    };
  },
  computed: {
    pawns: function pawns() {
      return _models_Pawn__WEBPACK_IMPORTED_MODULE_1__["default"].query().get();
    },
    user: function user() {
      return Object(lodash__WEBPACK_IMPORTED_MODULE_5__["groupBy"])(_models_User__WEBPACK_IMPORTED_MODULE_3__["default"].query().get(), function (user) {
        return user.id;
      });
    },
    pawnUserItems: function pawnUserItems() {
      return _models_PawnUserItem__WEBPACK_IMPORTED_MODULE_4__["default"].query()["with"](['pawn_items']).all();
    },
    closabledPawnUserItems: function closabledPawnUserItems() {
      return _models_PawnUserItem__WEBPACK_IMPORTED_MODULE_4__["default"].query()["with"](['pawn_items']).where('complete', false).get();
    },
    pawnItemsByPawnID: function pawnItemsByPawnID() {
      return Object(lodash__WEBPACK_IMPORTED_MODULE_5__["groupBy"])(_models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].query().get(), function (pawn_item) {
        return pawn_item.pawn_id;
      });
    },
    fullName: function fullName() {
      return this.user ? this.user.full_name : "-";
    }
  },
  methods: {
    fetchPawns: function fetchPawns() {
      var keyword = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
      var fieldKeys = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
      return _models_Pawn__WEBPACK_IMPORTED_MODULE_1__["default"].api().get("/pawns", {
        params: {
          search: {
            keyword: keyword,
            fields: fieldKeys
          },
          includes: ["user", "pawn_items", "pawns.pawn_items.item_damage", "pawns.pawn_items.item_category"]
        }
      });
    },
    fetchUserPawn: function fetchUserPawn() {
      var keyword = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
      var fieldKeys = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
      return _models_User__WEBPACK_IMPORTED_MODULE_3__["default"].api().get("/", {
        params: {
          search: {
            keyword: keyword,
            fields: fieldKeys
          },
          includes: ["pawns", "pawns.pawn_items", "pawns.pawn_items.item_category", "pawns.pawn_items.item_damage"]
        }
      });
    },
    fetchPawnItems: function fetchPawnItems() {
      var keyword = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
      var fieldKeys = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
      return _models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].api().get("/pawn_user_items", {
        params: {
          search: {
            keyword: keyword,
            fields: fieldKeys
          }
        }
      });
    },
    fetchPawnDetailByPawnId: function fetchPawnDetailByPawnId(id) {
      return _models_Pawn__WEBPACK_IMPORTED_MODULE_1__["default"].api().get("/pawns/".concat(id), {
        params: {
          // filters: [
          //     {
          //         key: 'pawn_id',
          //         value: pawnId
          //     },
          //     {
          //         key: 'complete',
          //         value: 0
          //     }
          // ],
          includes: ['pawn_items', 'pawn_items.item_damage', 'pawn_items.item_category', 'payments']
        }
      });
    },
    fetchPawnItemsByPawnId: function fetchPawnItemsByPawnId(pawnId) {
      return _models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].api().get("/pawn_items", {
        params: {
          filters: [{
            key: 'pawn_id',
            value: pawnId
          }, {
            key: 'complete',
            value: 0
          }],
          includes: ['item_damage', 'item_category']
        }
      });
    },
    fullNameByPawnNo: function fullNameByPawnNo(id) {
      console.log('1');
      return _models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].query().where('pawn_no', id).first() ? "".concat(_models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].query().where('pawn_no', id).first().first_name, " ").concat(_models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].query().where('pawn_no', id).first().last_name) : this.fullName;
    },
    pawnItemByPawnNo: function pawnItemByPawnNo(id) {
      console.log('2');
      return _models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].query().where('pawn_no', id).get() ? _models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].query().where('pawn_no', id).get() : [];
    },
    pawnItemCount: function pawnItemCount(id) {
      console.log('3');
      return this.pawnItemByPawnNo(id) ? this.pawnItemByPawnNo(id).length : "0";
    },
    sumPawnItemValueByPawnNo: function sumPawnItemValueByPawnNo(id) {
      if (!this.pawnItemByPawnNo(id)) return "0";
      var sumItemValue = Object(lodash__WEBPACK_IMPORTED_MODULE_5__["sumBy"])(this.pawnItemByPawnNo(id), 'item_value');
      sumItemValue = sumItemValue.toString().split(".");
      console.log('4');

      if (sumItemValue.length > 1) {
        return "".concat(sumItemValue[0], ".").concat(sumItemValue[1].substring(0, 2));
      } else {
        return "".concat(sumItemValue[0]);
      } // return sumBy(this.pawnItemByPawnNo(id), 'item_value')

    },
    clearDataVuex: function clearDataVuex() {
      _models_User__WEBPACK_IMPORTED_MODULE_3__["default"].deleteAll(); // Delete all Users.

      _models_Pawn__WEBPACK_IMPORTED_MODULE_1__["default"].deleteAll(); // Delete all Pawns.

      _models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].deleteAll(); // Delete all PawnItems.

      _models_PawnUserItem__WEBPACK_IMPORTED_MODULE_4__["default"].deleteAll();
    },
    searchPawnByCustomerData: function searchPawnByCustomerData() {
      var _arguments = arguments,
          _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var _ref, _ref$select, select, _ref$includes, includes, _ref$filters, filters, limit, page, items, promise, params, _promise$response$dat, _promise$response$dat2, total, _promise$response$dat3, pawns;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _ref = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : {}, _ref$select = _ref.select, select = _ref$select === void 0 ? ['pawns:id,full_name,identity_card_id,pawn_no,interest_rate,complete,customer_id,created_at,updated_at,latest_paid_at,next_paid_at'] : _ref$select, _ref$includes = _ref.includes, includes = _ref$includes === void 0 ? [] : _ref$includes, _ref$filters = _ref.filters, filters = _ref$filters === void 0 ? [{
                  key: 'complete',
                  value: 0
                }] : _ref$filters;
                limit = _this.perPage, page = _this.currentPage;
                items = [];
                _models_PawnItem__WEBPACK_IMPORTED_MODULE_2__["default"].deleteAll();
                _models_PawnUserItem__WEBPACK_IMPORTED_MODULE_4__["default"].deleteAll();
                _context.prev = 5;
                _this.search = true;
                _this.loading = true;
                params = {
                  filters: filters,
                  select: select,
                  page: page,
                  limit: limit,
                  sort: ["-pawn_no"]
                };

                if (_this.searchInput && _this.searchInput.length) {
                  _this.$set(params, 'search', {
                    keyword: _this.searchInput,
                    fields: ['full_name', 'identity_card_id', 'pawn_no']
                  });
                }

                if (includes.length) {
                  _this.$set(params, 'includes', includes);
                }

                _context.next = 13;
                return _models_PawnUserItem__WEBPACK_IMPORTED_MODULE_4__["default"].api().get('/', {
                  params: params
                });

              case 13:
                promise = _context.sent;
                _promise$response$dat = promise.response.data, _promise$response$dat2 = _promise$response$dat.total, total = _promise$response$dat2 === void 0 ? 0 : _promise$response$dat2, _promise$response$dat3 = _promise$response$dat.pawns, pawns = _promise$response$dat3 === void 0 ? [] : _promise$response$dat3;
                _this.totalRows = total;
                items = pawns;
                _context.next = 22;
                break;

              case 19:
                _context.prev = 19;
                _context.t0 = _context["catch"](5);
                console.log(_context.t0);

              case 22:
                _context.prev = 22;
                _this.loading = false;
                return _context.finish(22);

              case 25:
                return _context.abrupt("return", items);

              case 26:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[5, 19, 22, 25]]);
      }))();
    },
    searchPawnByCustomerDataWithItems: function searchPawnByCustomerDataWithItems() {
      return this.searchPawnByCustomerData({
        select: ['pawns:id,full_name,identity_card_id,pawn_no,interest_rate,complete,customer_id,created_at,updated_at,latest_paid_at,next_paid_at,count_items,total_items_value']
      });
    },
    searchAllPawnByCustomerDataWithItems: function searchAllPawnByCustomerDataWithItems() {
      return this.searchPawnByCustomerData({
        select: ['pawns:id,full_name,identity_card_id,pawn_no,interest_rate,complete,customer_id,created_at,updated_at,latest_paid_at,next_paid_at,count_items,total_items_value'],
        filters: []
      });
    }
  }
};

/***/ })

}]);