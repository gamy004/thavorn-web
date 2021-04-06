<template>
  <b-form-group>
    <label for="inputItem">ประเภททอง</label>

    <v-select
      v-model="$itemCategory"
      name="ItemCategory"
      id="inputItemCategorySelector"
      class="w-100"
      :loading="isLoading"
      :options="options"
      @search:focus="fetch"
    >
      <template #open-indicator="{ attributes }">
        <span v-bind="attributes"></span>
      </template>
    </v-select>

    <small v-if="error.has('item_category')" class="text-danger">{{
      error.message("item_category")
    }}</small>
  </b-form-group>
</template>

<script>
import vSelect from "vue-select";
import { errorMixin } from "mixins";
import ItemCategory from "models/ItemCategory";

export default {
  mixins: [errorMixin],

  props: {
    itemCategory: {
      type: ItemCategory,
      default: () => new ItemCategory(),
    },
  },

  model: {
    prop: "itemCategory",
    event: "change",
  },

  components: {
    vSelect,
  },

  data() {
    return {
      isLoading: false,
    };
  },

  computed: {
    $itemCategory: {
      get() {
        return this.itemCategory ? this.itemCategory.item_category : null;
      },

      set({ value }) {
        this.$emit("change", ItemCategory.find(value));
      },
    },

    options() {
      const data = ItemCategory.all();

      return data.reduce((carry, record) => {
        carry.push({ label: record.item_category, value: record.id });

        return carry;
      }, []);
    },
  },

  methods: {
    async fetch() {
      if (this.options && this.options.length) return;

      this.isLoading = true;

      try {
        await ItemCategory.api().get();
      } catch (error) {
        console.error(error);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>