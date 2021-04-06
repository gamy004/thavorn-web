<template>
  <b-form>
    <b-form-row>
      <item-category-selector
        class="col-sm-6"
        :error="selectedPawnItemError"
        v-model="selectedPawnItem.item_category"
      ></item-category-selector>

      <item-damage-selector
        class="col-sm-6"
        :error="selectedPawnItemError"
        v-model="selectedPawnItem.item_damage"
      ></item-damage-selector>

      <b-form-group
        class="col-sm-6"
        label-for="itemWeight"
        label="น้ำหนักทอง(กรัม)"
      >
        <b-form-input
          name="itemWeight"
          type="number"
          :step="0.01"
          :min="0"
          id="inputItemWeight"
          :state="selectedPawnItemError.state('item_weight')"
          v-model.number="selectedPawnItem.item_weight"
        ></b-form-input>

        <b-form-invalid-feedback id="inputItemWeight-feedback">
          {{ selectedPawnItemError.message("item_weight") }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group class="col-sm-6" label-for="itemValue" label="มูลค่า(บาท)">
        <b-form-input
          name="itemValue"
          type="number"
          :step="0.01"
          :min="0"
          id="inputItemValue"
          :state="selectedPawnItemError.state('item_value')"
          v-model.number="selectedPawnItem.item_value"
        ></b-form-input>

        <b-form-invalid-feedback id="inputItemValue-feedback">
          {{ selectedPawnItemError.message("item_value") }}
        </b-form-invalid-feedback>
      </b-form-group>
    </b-form-row>

    <b-button
      v-if="isEditing"
      variant="primary"
      type="button"
      @click.prevent="update"
      >แก้ไข</b-button
    >

    <b-button
      v-else
      variant="primary"
      type="button"
      :disabled="disabled"
      @click.prevent="add"
      >เพิ่มเข้ารายการ</b-button
    >

    <b-button
      v-if="isEditing"
      variant="secondary"
      type="button"
      class="ml-2"
      @click.prevent="clear"
      >ยกเลิก</b-button
    >

    <hr />

    <b-form-row>
      <table class="table table-hover table-striped table-bordered mt-3 mb-5">
        <thead class="thead-light">
          <tr>
            <th scope="col">ประเภททอง</th>
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
            <th scope="row">
              {{
                itemList.item_category
                  ? itemList.item_category.item_category
                  : "ไม่ได้ระบุประเภททอง"
              }}
            </th>
            <td>{{ itemList.item_weight }}</td>
            <td>{{ itemList.item_value }}</td>
            <td>
              {{
                itemList.item_damage
                  ? itemList.item_damage.item_damage
                  : "ไม่ได้ระบุความเสียหาย"
              }}
            </td>
            <td>
              <b-button
                variant="outline-primary"
                :disabled="disabled || isEditing"
                size="sm"
                @click.prevent.stop="edit(index)"
                >แก้ไข</b-button
              >
              <b-button
                variant="outline-danger"
                :disabled="disabled || isEditing"
                size="sm"
                @click.prevent.stop="destroy(index)"
                >นำออก</b-button
              >
            </td>
          </tr>
        </tbody>
      </table>

      <b-alert :show="error.has('pawn.pawn_items')" variant="danger">
        {{ error.message("pawn.pawn_items") }}
      </b-alert>
    </b-form-row>
  </b-form>
</template>

<script>
import { disabledMixin, errorMixin } from "mixins";
import Error from "core/Error";
import PawnItem from "models/PawnItem";
import ItemCategorySelector from "components/pawn-item-categories/selector";
import ItemDamageSelector from "components/pawn-item-damages/selector";

export default {
  mixins: [disabledMixin, errorMixin],

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
    ItemDamageSelector,
  },

  data() {
    return {
      isEditing: false,
      editingIndex: null,
      selectedPawnItemError: Error.make(),
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
    validate() {
      let pass = true;

      const { selectedPawnItem } = this;

      const {
        item_category,
        item_damage,
        item_weight,
        item_value,
      } = selectedPawnItem;

      if (!item_category) {
        pass = false;
        this.selectedPawnItemError.add({
          item_category: ["กรุณาเลือกประเภททอง อย่างน้อย 1 ตัวเลือก"],
        });
      }

      if (!item_damage) {
        pass = false;
        this.selectedPawnItemError.add({
          item_damage: ["กรุณาเลือกความเสียหาย อย่างน้อย 1 ตัวเลือก"],
        });
      }

      if (item_weight <= 0) {
        pass = false;
        this.selectedPawnItemError.add({
          item_weight: ["น้ำหนักทองควรมีค่ามากกว่า 0"],
        });
      }

      if (item_value <= 0) {
        pass = false;
        this.selectedPawnItemError.add({
          item_value: ["มูลค่าควรมีค่ามากกว่า 0"],
        });
      }

      return pass;
    },

    getValidatedSelectedPawnItem() {
      const { selectedPawnItem } = this;

      const { item_category, item_damage } = selectedPawnItem;

      if (item_category && item_category.id) {
        this.$set(selectedPawnItem, "item_category_id", item_category.id);
      }

      if (item_damage && item_damage.id) {
        this.$set(selectedPawnItem, "item_damage_id", item_damage.id);
      }

      if (this.pawn && this.pawn.id) {
        this.$set(selectedPawnItem, "pawn_id", pawn.id);
        this.$set(selectedPawnItem, "pawn", pawn);
      }

      return selectedPawnItem;
    },

    add() {
      this.selectedPawnItemError.clear();

      if (this.validate()) {
        this.$pawnItems.push(this.getValidatedSelectedPawnItem());

        this.clear();
      }
    },

    edit(index) {
      this.isEditing = true;

      this.editingIndex = index;

      this.selectedPawnItem = new PawnItem({ ...this.$pawnItems[index] });
    },

    update() {
      const { isEditing, editingIndex, $pawnItems } = this;

      this.selectedPawnItemError.clear();

      if (
        isEditing &&
        editingIndex !== null &&
        $pawnItems.length >= editingIndex + 1 &&
        this.validate()
      ) {
        $pawnItems.splice(editingIndex, 1, this.getValidatedSelectedPawnItem());
        this.$pawnItems = [...$pawnItems];
        this.clear();
      }
    },

    clear() {
      this.selectedPawnItemError.clear();
      this.editingIndex = null;
      this.selectedPawnItem = new PawnItem();
      this.isEditing = false;
    },

    destroy(index) {
      const { $pawnItems } = this;

      if ($pawnItems.length >= index + 1) {
        $pawnItems.splice(index, 1);
      }

      this.$pawnItems = [...$pawnItems];
    },
  },
};
</script>