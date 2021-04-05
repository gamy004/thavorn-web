import { Model } from "@vuex-orm/core";
import Pawn from './Pawn';
import ItemCategory from './ItemCategory';
import ItemDamage from './ItemDamage';
export default class PawnItem extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return "pawn_items";
    }

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.
    static fields() {
        return {
            id: this.attr(null),
            item_weight: this.number(''),
            item_weight_unit: this.attr('gram'),
            item_value: this.number(''),
            item_value_unit: this.attr('THB'),
            item_category: this.belongsTo(ItemCategory, 'item_category_id'),
            item_category_id: this.attr(null),
            item_damage: this.belongsTo(ItemDamage, 'item_damage_id'),
            item_damage_id: this.attr(null),
            pawn_id: this.attr(null),
            pawn: this.belongsTo(Pawn, 'pawn_id'),
            complete: this.attr(null),
            created_at: this.attr(null),
            updated_at: this.attr(null),
        };
    }

    static get apiConfig() {
        return {
            dataKey: "pawn_items",
            baseURL: "/api",
        };
    }
}
