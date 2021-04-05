<template>
  <b-form>
    <b-form-row>
      <item-category-selector
        class="col-sm-6"
        v-model="selectedPawnItem.item_category"
      ></item-category-selector>
      <!-- <b-form-group class="col-sm-6">
        <label for="inputItem">ประเภทของทอง</label>
        <b-form-select
          name="item"
          id="itemOptions"
          class="w-100"
          :options="itemOptions"
          v-model="selectedPawnItem.item_category"
          :value="itemOptions"
        >
        </b-form-select>
      </b-form-group> -->

      <!-- <b-form-group
        label="ความเสียหาย"
        v-slot="{ ariaDescribedby }"
        class="col-sm-6"
      >
        <b-form-radio-group
          id="inputItemDamages"
          :options="ItemDamagesOptions"
          :aria-describedby="ariaDescribedby"
          name="itemDamages"
          class="ml-3"
          v-model="selectedPawnItem.item_damage"
        ></b-form-radio-group>
      </b-form-group> -->

      <b-form-group
        class="col-sm-6"
        label-for="itemWeight"
        label="น้ำหนักทอง(กรัม)"
      >
        <b-form-input
          name="itemWeight"
          type="text"
          id="inputItemWeight"
          v-model="selectedPawnItem.item_weight"
        ></b-form-input>
      </b-form-group>

      <b-form-group class="col-sm-6" label-for="itemValue" label="มูลค่า(บาท)">
        <b-form-input
          name="itemValue"
          type="text"
          id="inputItemValue"
          v-model="selectedPawnItem.item_value"
        ></b-form-input>
      </b-form-group>
    </b-form-row>

    <b-button
      variant="primary"
      type="button"
      @click.prevent="add(selectedPawnItem)"
      >เพิ่มเข้ารายการ</b-button
    >

    <hr />

    <b-form-row>
      <table class="table table-hover table-striped table-bordered mt-3 mb-5">
        <thead class="thead-light">
          <tr>
            <th scope="col">ประเภทของทอง</th>
            <th scope="col">น้ำหนักทอง (กรัม)</th>
            <th scope="col">มูลค่า (บาท)</th>
            <th scope="col">ความเสียหาย</th>
            <th scope="col">การกระทำ</th>
          </tr>
        </thead>
        <tbody v-if="$pawnItems && $pawnItems.length > 0">
          <tr
            v-for="(itemList, index) in $pawnItems"
            :key="`pawn-item-${index}`"
          >
            <th scope="row">{{ itemList.item_category }}</th>
            <td>{{ itemList.item_weight }}</td>
            <td>{{ itemList.item_value }}</td>
            <td>{{ itemList.item_damage }}</td>
            <td>
              <a href="" style="color: red" @click.prevent.stop="destroy(index)"
                >นำออก
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </b-form-row>
  </b-form>
</template>

<script>
import PawnItem from "models/PawnItem";
import ItemCategorySelector from "components/pawn-item-categories/selector";

export default {
  props: {
    pawnItems: {
      type: Array,
      default: () => [],
    },
  },

  model: {
    prop: "pawnItems",
    event: "change",
  },

  components: {
    ItemCategorySelector,
  },

  data() {
    return {
      selectedPawnItem: new PawnItem(),
    };
  },

  computed: {
    $pawnItems: {
      get() {
        return this.pawnItems;
      },

      set(pawnItems) {
        this.$emit("change", pawnItems);
      },
    },
  },

  methods: {
    add(selectedPawnItem) {
      const { item_category, item_damage } = selectedPawnItem;

      console.log(item_category && item_category.id);
      if (item_category && item_category.id) {
        this.$set(selectedPawnItem, "item_category_id", item_category.id);
      }

      if (item_damage && item_damage.id) {
        this.$set(selectedPawnItem, "item_damage_id", item_damage.id);
      }

      console.log(selectedPawnItem);
    },

    destroy(index) {},
  },
};
</script>