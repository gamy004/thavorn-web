<template>
  <div id="app" class="d-flex flex-fill">
    <component :is="layout">
      <transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>
    </component>
  </div>
</template>

<script>
const default_layout = "default";

export default {
  computed: {
    layout() {
      return (this.$route.meta.layout || default_layout) + "-layout";
    },
  },
};
</script>
