<template>
  <b-form-group>
    <label for="inputItem">ประเภทของทอง</label>

    <v-select
      name="ItemCategory"
      id="inputItemCategorySelector"
      class="w-100"
      :loading="isLoading"
      :options="options"
      @search:focus="fetch"
      @option:selected="update"
    >
      <template #open-indicator="{ attributes }">
        <span v-bind="attributes"></span>
      </template>
    </v-select>
  </b-form-group>
</template>

<script>
import vSelect from "vue-select";
import ItemCategory from "models/ItemCategory";

export default {
  props: {
    ItemCategory: {
      type: ItemCategory,
      default: () => new ItemCategory(),
    },
  },

  model: {
    prop: "ItemCategory",
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
    $ItemCategory: {
      get() {
        return this.ItemCategory;
      },

      set(v) {
        this.$emit("change", v);
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

    update(option) {
      const { value } = option;

      this.$ItemCategory = ItemCategory.find(value);
    },
  },
};
</script>