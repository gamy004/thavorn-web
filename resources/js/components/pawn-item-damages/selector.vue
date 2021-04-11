<template>
  <b-form-group
    label="ความเสียหาย"
    v-slot="{ ariaDescribedby }"
    class="col-sm-6"
  >
    <b-spinner
      v-if="isLoading"
      small
      label="Small Spinner Item Damages"
    ></b-spinner>

    <b-form-radio-group
      v-else-if="options && options.length"
      id="inputItemDamages"
      :options="options"
      :aria-describedby="ariaDescribedby"
      name="itemDamages"
      @input="error.clear('item_damage')"
      v-model="$itemDamage"
    ></b-form-radio-group>

    <div v-else class="text-muted">ไม่พบข้อมูลความเสียหาย</div>

    <small v-if="error.has('item_damage')" class="text-danger error__message">{{
      error.message("item_damage")
    }}</small>
  </b-form-group>
</template>

<script>
import { errorMixin } from "mixins";
import ItemDamage from "models/ItemDamage";

export default {
  mixins: [errorMixin],

  props: {
    itemDamage: {
      type: ItemDamage,
      default: () => new ItemDamage(),
    },
  },

  model: {
    prop: "itemDamage",
    event: "change",
  },

  data() {
    return {
      isLoading: false,
    };
  },

  computed: {
    $itemDamage: {
      get() {
        return this.itemDamage ? this.itemDamage.id : null;
      },

      set(v) {
        const itemDamage = v !== null ? ItemDamage.find(v) : null;

        this.$emit("change", itemDamage);
      },
    },

    options() {
      const data = ItemDamage.all();

      return data.reduce((carry, record) => {
        carry.push({ text: record.item_damage, value: record.id });

        return carry;
      }, []);
    },
  },

  methods: {
    async fetch() {
      if (this.options && this.options.length) return;

      this.isLoading = true;

      try {
        await ItemDamage.api().get();
      } catch (error) {
        console.error(error);
      } finally {
        this.isLoading = false;
      }
    },
  },

  mounted() {
    this.fetch();
  },
};
</script>

<style lang="scss" scoped>
.error__message {
  position: relative;
  top: 5px;
}
</style>