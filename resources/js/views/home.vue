<template>
  <div>
    <div class="hero-wrapper bg-composed-wrapper bg-neutral-success"></div>
  </div>
</template>

<script>
import Slick from "vue-slick";

import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faQuestionCircle,
  faExternalLinkAlt,
  faStar,
  faQuoteRight,
  faArrowRight,
} from "@fortawesome/free-solid-svg-icons";
import {
  faFacebookSquare,
  faTwitterSquare,
  faDribbble,
  faGithubSquare,
  faAngular,
  faVuejs,
  faReact,
  faHtml5,
} from "@fortawesome/free-brands-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(
  faQuestionCircle,
  faExternalLinkAlt,
  faStar,
  faQuoteRight,
  faArrowRight,
  faFacebookSquare,
  faTwitterSquare,
  faDribbble,
  faGithubSquare,
  faAngular,
  faVuejs,
  faReact,
  faHtml5
);
// import Icons from "../examples/ui-elements/icons";

export default {
  name: "home",
  components: {
    // Icons,
    Slick,
    "font-awesome-icon": FontAwesomeIcon,
  },
  data() {
    return {
      slickOptions: {
        slidesToShow: 2,
        // Any other options that can be got from plugin documentation
      },
    };
  },
  methods: {
    onTooltipShow() {
      this.$refs.FacebookTooltip._toolpop
        .getTipElement()
        .classList.add("tooltip-secondary");
      this.$refs.TwitterTooltip._toolpop
        .getTipElement()
        .classList.add("tooltip-secondary");
      this.$refs.DribbbleTooltip._toolpop
        .getTipElement()
        .classList.add("tooltip-secondary");
      this.$refs.GithubTooltip._toolpop
        .getTipElement()
        .classList.add("tooltip-secondary");
    },
  },
};
</script>
