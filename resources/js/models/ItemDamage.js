import { Model } from "@vuex-orm/core";

export default class ItemDamage extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return "pawn_item_damages";
    }

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.
    static fields() {
        return {
            id: this.attr(null),
            item_damage: this.attr(null),
            created_at: this.attr(null),
            updated_at: this.attr(null)
        };
    }

    static get apiConfig() {
        return {
            dataKey: "item_damages",
            baseURL: "/api/item_damages",
        };
    }
}
