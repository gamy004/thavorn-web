<template>
  <div class="app-sidebar app-sidebar--dark bg-plum-plate">
    <div class="app-sidebar--header">
      <div class="nav-logo w-100 text-center">
        <router-link
          tag="a"
          class="d-block"
          active-class="active"
          to="/"
          exact
          v-b-tooltip.hover
          title="Fully built and powered by Vue.js 🚀"
        >
          <img src="/assets/img/admin-logo.png" alt="" />
        </router-link>
      </div>
    </div>
    <VuePerfectScrollbar class="app-sidebar--content">
      <div class="sidebar-navigation--mini">
        <ul>
          <li>
            <router-link
              tag="a"
              active-class="active"
              exact
              to="/"
              v-b-tooltip.hover
              title="Dashboard"
            >
              <span>
                <truck-icon></truck-icon>
              </span>
            </router-link>
          </li>
          <li>
            <router-link
              tag="a"
              active-class="active"
              exact
              to="/applications/apps-widgets"
              v-b-tooltip.hover
              title="App widgets"
            >
              <span>
                <database-icon></database-icon>
              </span>
            </router-link>
          </li>
          <li>
            <router-link
              tag="a"
              active-class="active"
              exact
              to="/applications/chat"
              v-b-tooltip.hover
              title="Chat"
            >
              <span>
                <map-pin-icon></map-pin-icon>
              </span>
            </router-link>
          </li>
          <li>
            <router-link
              tag="a"
              active-class="active"
              exact
              to="/applications/contacts"
              v-b-tooltip.hover
              title="Contacts"
            >
              <span>
                <pie-chart-icon></pie-chart-icon>
              </span>
            </router-link>
          </li>
          <li>
            <router-link
              tag="a"
              active-class="active"
              exact
              to="/applications/file-manager"
              v-b-tooltip.hover
              title="File manager"
            >
              <span>
                <user-check-icon></user-check-icon>
              </span>
            </router-link>
          </li>
          <li>
            <router-link
              tag="a"
              active-class="active"
              exact
              to="/applications/mail"
              v-b-tooltip.hover
              title="Mail"
            >
              <span>
                <cpu-icon></cpu-icon>
              </span>
            </router-link>
          </li>
          <li>
            <router-link
              tag="a"
              active-class="active"
              exact
              to="/applications/events-calendar"
              v-b-tooltip.hover
              title="Events calendar"
            >
              <span>
                <battery-charging-icon></battery-charging-icon>
              </span>
            </router-link>
          </li>
        </ul>
        <div class="text-center">
          <a
            href="javascript:history.back()"
            class="m-1 btn btn-warning p-0 d-inline-block shadow-none text-center font-size-lg d-40 rounded"
            id="tooltipBack"
          >
            <font-awesome-icon icon="arrow-left" />
          </a>
          <b-tooltip
            @show="showTooltip"
            ref="tooltipWarning"
            placement="right"
            target="tooltipBack"
          >
            Back to previous page
          </b-tooltip>
        </div>
      </div>
    </VuePerfectScrollbar>
  </div>
</template>

<script>
import Vue from "vue";

Vue.component("truck-icon", TruckIcon);
Vue.component("battery-charging-icon", BatteryChargingIcon);
Vue.component("cpu-icon", CpuIcon);
Vue.component("user-check-icon", UserCheckIcon);
Vue.component("database-icon", DatabaseIcon);
Vue.component("map-pin-icon", MapPinIcon);
Vue.component("pie-chart-icon", PieChartIcon);

import VuePerfectScrollbar from "vue-perfect-scrollbar";
import {
  TruckIcon,
  BatteryChargingIcon,
  CpuIcon,
  UserCheckIcon,
  DatabaseIcon,
  MapPinIcon,
  PieChartIcon,
} from "vue-feather-icons";

import { library } from "@fortawesome/fontawesome-svg-core";
import { faArrowLeft } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faArrowLeft);

export default {
  components: {
    VuePerfectScrollbar,
    "font-awesome-icon": FontAwesomeIcon,
  },
  methods: {
    showTooltip() {
      this.$refs.tooltipWarning._toolpop
        .getTipElement()
        .classList.add("tooltip-warning");
    },
  },
};
</script>
