(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{203:function(t,e,n){"use strict";n.r(e);var a=n(2),s=n.n(a),r=n(5),i=n(9),o=n(22),l=n(8),c=n(20),u=n(11),d=n(28);function v(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var n=[],a=!0,s=!1,r=void 0;try{for(var i,o=t[Symbol.iterator]();!(a=(i=o.next()).done)&&(n.push(i.value),!e||n.length!==e);a=!0);}catch(t){s=!0,r=t}finally{try{a||null==o.return||o.return()}finally{if(s)throw r}}return n}(t,e)||function(t,e){if(!t)return;if("string"==typeof t)return p(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return p(t,e)}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function p(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,a=new Array(e);n<e;n++)a[n]=t[n];return a}function f(t,e,n,a,s,r,i){try{var o=t[r](i),l=o.value}catch(t){return void n(t)}o.done?e(l):Promise.resolve(l).then(a,s)}function m(t){return function(){var e=this,n=arguments;return new Promise((function(a,s){var r=t.apply(e,n);function i(t){f(r,a,s,i,o,"next",t)}function o(t){f(r,a,s,i,o,"throw",t)}i(void 0)}))}}var _={mixins:[r.a,r.e],components:{EvidenceUploader:d.a},data:function(){return{loadingPawnItems:!1,isSubmitting:!1,status:!0,form:{close_amount:null,interest_value:null}}},props:{show:{type:Boolean,default:!1},pawn:{type:i.a,default:function(){return new i.a}}},model:{prop:"show",event:"change"},watch:{show:{immediate:!0,handler:function(t){t&&this.fetch()}}},computed:{pawnItems:function(){return this.pawn&&this.pawn.id?u.a.query().where("pawn_id",this.pawn.id).where("complete",!1).with(["item_damage","item_category"]).get():[]},payments:function(){return this.pawn&&this.pawn.id?c.a.query().where("pawn_id",this.pawn.id).get():[]}},methods:{closePawnReply:function(t){this.$emit("change",!1)},fetch:function(){var t=this;return m(s.a.mark((function e(){var n,a,r;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.loadingPawnItems=!0,e.prev=1,e.next=4,Promise.all([t.fetchPawnDetailByPawnId(t.pawn.id),l.a.api().getCloseAmount(t.pawn.id)]);case 4:a=e.sent,r=v(a,2),r[0],(n=r[1])&&n.close_amount&&t.$set(t.form,"close_amount",n.close_amount),n&&n.interest_value&&t.$set(t.form,"interest_value",n.interest_value),e.next=15;break;case 12:e.prev=12,e.t0=e.catch(1),console.error(e.t0);case 15:return e.prev=15,t.loadingPawnItems=!1,e.finish(15);case 18:case"end":return e.stop()}}),e,null,[[1,12,15,18]])})))()},submit:function(t){var e=this;return m(s.a.mark((function n(){var a;return s.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return e.isSubmitting=!0,n.prev=1,n.next=4,l.a.api().close(t,e.form.close_amount);case 4:a=n.sent,e.$emit("success",a),e.$emit("change",!1),n.next=12;break;case 9:n.prev=9,n.t0=n.catch(1),e.$emit("fail",n.t0);case 12:return n.prev=12,e.isSubmitting=!1,e.form={close_amount:null,interest_value:null},n.finish(12);case 16:case"end":return n.stop()}}),n,null,[[1,9,12,16]])})))()}}},b=n(3),w=Object(b.a)(_,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("b-modal",{attrs:{id:"pawn-reply-modal-"+t.pawn.pawn_no,"no-close-on-backdrop":""},model:{value:t.show,callback:function(e){t.show=e},expression:"show"}},[n("template",{staticClass:"modal-header ml-3 mr-3",slot:"modal-header"},[n("h4",[t._v("สรุปรายการไถ่ถอน")])]),t._v(" "),n("div",{staticClass:"modal-body"},[n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-12"},[n("b",{staticClass:"ft-s-16"},[t._v("เลขที่บัตรจำนำ")]),t._v(" "),n("div",[t._v(t._s(t.pawn.pawn_no))])])]),t._v(" "),n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-12"},[n("b",{staticClass:"ft-s-16"},[t._v("ผู้จำนำ")]),t._v(" "),n("div",[t._v("\n            "+t._s(t.pawn.fullName)+"\n          ")])])]),t._v(" "),n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-12"},[n("b",{staticClass:"ft-s-16"},[t._v("จำนวนสินค้า")]),t._v(" "),n("div",[t._v("\n            "+t._s(t.pawn.count_items)+"\n          ")])])]),t._v(" "),n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-12"},[n("b",{staticClass:"ft-s-16"},[t._v("ประวัติการจำนำ")]),t._v(" "),n("ul",{staticClass:"ul__no-bullets mb-0"},[n("li",[t._v("\n              "+t._s(t.formatingDatetime(t.pawn.created_at,"DD MMM YYYY"))+" -\n              จำนำสินค้า\n            ")]),t._v(" "),t._l(t.payments,(function(e){return[n("li",{key:"payment_"+e.id},[t._v("\n                "+t._s(e.timeDescription)+"\n              ")])]}))],2)])]),t._v(" "),n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-12"},[n("b",{staticClass:"ft-s-16"},[t._v("รายการสินค้าจำนำ")]),t._v(" "),t.loadingPawnItems?n("b-spinner",{attrs:{label:"Fetching pawn items",variant:"primary"}}):n("table",{staticClass:"table table-hover table-striped table-bordered mt-3"},[n("thead",{staticClass:"thead-light"},[n("tr",[n("th",{attrs:{scope:"col"}},[t._v("ประเภทของทอง")]),t._v(" "),n("th",{attrs:{scope:"col"}},[t._v("น้ำหนักทอง (กรัม)")]),t._v(" "),n("th",{attrs:{scope:"col"}},[t._v("มูลค่า (บาท)")]),t._v(" "),n("th",{attrs:{scope:"col"}},[t._v("ความเสียหาย")])])]),t._v(" "),n("tbody",t._l(t.pawnItems,(function(e,a){return n("tr",{key:"pawn-item-"+a},[n("th",{attrs:{scope:"row"}},[t._v("\n                  "+t._s(e.item_category.item_category)+"\n                ")]),t._v(" "),n("td",[t._v("\n                  "+t._s(e.item_weight)+"\n                ")]),t._v(" "),n("td",[t._v(t._s(e.item_value))]),t._v(" "),n("td",[t._v("\n                  "+t._s(e.item_damage.item_damage)+"\n                ")])])})),0)])],1)]),t._v(" "),n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-12"},[n("b",{staticClass:"ft-s-16"},[t._v("อัตราดอกเบี้ย")]),t._v(" "),n("div",[t._v(t._s(t.pawn.interest_rate)+" %")])])]),t._v(" "),n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-6"},[n("b",{staticClass:"ft-s-16"},[t._v("วันที่มาจำนำ")]),t._v(" "),n("div",[t._v("\n            "+t._s(t.formatingDatetime(t.pawn.created_at,"DD MMM YYYY"))+"\n          ")])]),t._v(" "),n("div",{staticClass:"col-6"},[n("b",{staticClass:"ft-s-16"},[t._v("วันที่ต่อดอกล่าสุด")]),t._v(" "),n("div",[t._v("\n            "+t._s(t.formatingDatetime(t.pawn.latest_paid_at,"DD MMM YYYY"))+"\n          ")])])]),t._v(" "),n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-6"},[n("b",{staticClass:"ft-s-16"},[t._v("รวมมูลค่าสินค้า(บาท)")]),t._v(" "),n("div",[t._v(t._s(t.pawn.total_items_value))])]),t._v(" "),n("div",{staticClass:"col-6"},[n("b",{staticClass:"ft-s-16"},[t._v("ดอกเบี้ย(บาท)")]),t._v(" "),t.loadingPawnItems?n("b-spinner",{attrs:{label:"Fetching pawn items",variant:"primary"}}):n("div",[t._v("\n            "+t._s(t.form.interest_value?""+t.form.interest_value:"ไม่สามารถระบุได้")+"\n          ")])],1)]),t._v(" "),n("div",{staticClass:"row mb-4"},[n("div",{staticClass:"col-12"},[n("h2",[t._v("รวมยอดชำระ(บาท)")]),t._v(" "),t.loadingPawnItems?n("b-spinner",{attrs:{label:"Fetching pawn items",variant:"primary"}}):n("h5",[t._v("\n            "+t._s(t.form.close_amount?""+t.form.close_amount:"ไม่สามารถระบุได้")+"\n          ")])],1)]),t._v(" "),n("evidence-uploader",{ref:"evidenceUploader",attrs:{"user-id":t.pawn.customer_id}})],1),t._v(" "),n("template",{staticClass:"modal-footer ml-3 mr-3",slot:"modal-footer"},[n("button",{staticClass:"btn btn-secondary",attrs:{type:"button",disabled:!!t.$refs.evidenceUploader&&t.$refs.evidenceUploader.isProcessing||t.isSubmitting},on:{click:function(e){return t.closePawnReply(t.pawn.pawn_no)}}},[t.$refs.evidenceUploader&&t.$refs.evidenceUploader.isProcessing||t.isSubmitting?n("b-spinner"):n("span",[t._v("ปิดหน้าต่าง")])],1),t._v(" "),n("button",{staticClass:"btn btn-primary",attrs:{type:"button",disabled:t.loadingPawnItems||!!t.$refs.evidenceUploader&&t.$refs.evidenceUploader.isProcessing||t.isSubmitting},on:{click:function(e){return e.preventDefault(),t.submit(t.pawn.id)}}},[t.loadingPawnItems||t.$refs.evidenceUploader&&t.$refs.evidenceUploader.isProcessing||t.isSubmitting?n("b-spinner"):n("span",[t._v("ไถ่ถอน")])],1)])],2)],1)}),[],!1,null,null,null).exports;function h(t,e){if(null==t)return{};var n,a,s=function(t,e){if(null==t)return{};var n,a,s={},r=Object.keys(t);for(a=0;a<r.length;a++)n=r[a],e.indexOf(n)>=0||(s[n]=t[n]);return s}(t,e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);for(a=0;a<r.length;a++)n=r[a],e.indexOf(n)>=0||Object.prototype.propertyIsEnumerable.call(t,n)&&(s[n]=t[n])}return s}function y(t,e,n,a,s,r,i){try{var o=t[r](i),l=o.value}catch(t){return void n(t)}o.done?e(l):Promise.resolve(l).then(a,s)}function C(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,a)}return n}function g(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var P={mixins:[r.a],components:{PawnUserSearcher:o.a,PawnReply:w},data:function(){return{selectedReplyPawn:null,showReply:!1,toastCloseFail:!1,toastCloseSuccess:!1,fields:[{key:"pawn_no",label:"เลขที่บัตรจำนำ"},{key:"count_items",label:"จำนวนสินค้า (ชิ้น)"},{key:"total_items_value",label:"มูลค่าสินค้า (บาท)"},{key:"interest_rate",label:"อัตราดอกเบี้ย (%)"},{key:"action",label:"",tdClass:"text-center"}]}},watch:{showReply:function(t){t||(this.selectedReplyPawn=null)}},methods:{showPawnReply:function(t){this.selectedReplyPawn=new i.a(function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?C(Object(n),!0).forEach((function(e){g(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):C(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},t)),this.showReply=!0},onClosePawnSuccess:function(t){var e,n=this;return(e=s.a.mark((function e(){var a,r;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a=t.id,r=h(t,["id"]),n.toastCloseSuccess=!0,i.a.update({where:a,data:r}),n.$refs.pawnUserSearcher.refresh();case 4:case"end":return e.stop()}}),e)})),function(){var t=this,n=arguments;return new Promise((function(a,s){var r=e.apply(t,n);function i(t){y(r,a,s,i,o,"next",t)}function o(t){y(r,a,s,i,o,"throw",t)}i(void 0)}))})()}}},x=Object(b.a)(P,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"page-title page-title--alt"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-xl-7 d-block d-xl-flex align-items-center"},[n("div",{staticClass:"pr-0 pr-xl-4 mb-4 mb-xl-0"},[n("div",{staticClass:"d-70 mx-auto rounded font-size-xxl bg-white text-center shadow-sm"},[n("font-awesome-icon",{staticClass:"text-primary mt-1",attrs:{icon:"reply"}})],1)]),t._v(" "),t._m(0)])])]),t._v(" "),n("div",{staticClass:"container-fluid"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-12"},[n("div",{staticClass:"card card-box"},[t._m(1),t._v(" "),n("div",{staticClass:"card-body"},[n("pawn-user-searcher",{ref:"pawnUserSearcher",attrs:{fields:t.fields,"search-fn":"searchPawnByCustomerDataWithItems"},scopedSlots:t._u([{key:"cell(action)",fn:function(e){return[n("button",{staticClass:"btn btn-primary btn-sm",on:{click:function(n){return n.preventDefault(),t.showPawnReply(e.item)}}},[t._v("\n                  ไถ่ถอน\n                ")])]}}])}),t._v(" "),t.selectedReplyPawn?n("pawn-reply",{attrs:{pawn:t.selectedReplyPawn},on:{success:t.onClosePawnSuccess,fail:function(e){t.toastCloseFail=!0}},model:{value:t.showReply,callback:function(e){t.showReply=e},expression:"showReply"}}):t._e(),t._v(" "),n("b-toast",{attrs:{id:"pawn-close-toast-success",variant:"success",solid:"","no-close-button":""},model:{value:t.toastCloseSuccess,callback:function(e){t.toastCloseSuccess=e},expression:"toastCloseSuccess"}},[t._v("\n              ไถ่ถอนการจำนำสำเร็จ\n            ")]),t._v(" "),n("b-toast",{attrs:{id:"pawn-close-toast-fail",variant:"danger",solid:"","no-close-button":""},model:{value:t.toastCloseFail,callback:function(e){t.toastCloseFail=e},expression:"toastCloseFail"}},[t._v("\n              ไถ่ถอนการจำนำไม่สำเร็จ\n            ")])],1)])])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",[e("h5",{staticClass:"display-4 mt-1 mb-2 font-weight-bold"},[this._v("ไถ่ถอน")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"card-header"},[e("h5",{staticClass:"my-3"},[this._v("ข้อมูลสินค้าจำนำ")])])}],!1,null,null,null);e.default=x.exports},22:function(t,e,n){"use strict";var a=n(5),s={mixins:[a.a,a.e],props:{fields:{type:Array,default:[]},searchFn:{type:String,default:"searchPawnByCustomerData"}},methods:{itemProvider:function(){return this[this.searchFn]()},refresh:function(){return this.$refs.pawnTable.refresh()}}},r=n(3),i=Object(r.a)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("form",[t._m(0),t._v(" "),n("div",{staticClass:"form-row"},[n("div",{staticClass:"col-sm-10"},[n("b-form-input",{attrs:{name:"inputCustomerInfoExtend",type:"text",id:"inputCustomerInfoExtend",placeholder:"ระบุชื่อ, นามสกุล, เลขบัตรประจำตัวประชาชน หรือเลขบัตรจำนำ",disabled:t.loading},on:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.refresh(e)}},model:{value:t.searchInput,callback:function(e){t.searchInput=e},expression:"searchInput"}})],1),t._v(" "),n("div",{staticClass:"col-sm-2"},[n("button",{staticClass:"btn btn-primary btn-md",attrs:{disabled:t.loading},on:{click:function(e){return e.preventDefault(),t.refresh(e)}}},[t._v("\n        ค้นหา\n      ")])])]),t._v(" "),n("div",{staticClass:"row mt-3"},[n("div",{staticClass:"col-xl-12 d-block"},[n("b-table",{ref:"pawnTable",staticClass:"mt-3 mb-5",attrs:{id:"pawnTable",hover:"",striped:"",bordered:"",fields:t.fields,items:t.itemProvider,"per-page":t.perPage,"current-page":t.currentPage,"table-busy":t.loading},scopedSlots:t._u([t._l(t.$scopedSlots,(function(e,n){return{key:n,fn:function(e){return[t._t(n,null,null,e)]}}}))],null,!0)},[t._t("default")],2),t._v(" "),n("b-pagination",{attrs:{"total-rows":t.totalRows,"per-page":t.perPage,"aria-controls":"pawnTable"},model:{value:t.currentPage,callback:function(e){t.currentPage=e},expression:"currentPage"}})],1)])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"form-row"},[e("label",{staticClass:"col-md-12",attrs:{for:"inputCustomerInfoExtend"}},[this._v("ค้นหาจากฐานข้อมูลลูกค้า")])])}],!1,null,null,null);e.a=i.exports}}]);