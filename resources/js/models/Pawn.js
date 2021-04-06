import { Model } from "@vuex-orm/core";
import PawnItem from "./PawnItem"
import User from "./User";
export default class Pawn extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return "pawns";
    }

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.
    static fields() {
        return {
            id: this.attr(null),
            pawn_no: this.attr(''),
            interest_rate: this.number(3),
            customer_id: this.attr(null),
            user: this.belongsTo(User, 'customer_id'),
            latest_paid_at: this.attr(null),
            complete: this.boolean(0),
            next_paid_at: this.attr(null),
            latest_paid_at: this.attr(null),
            created_at: this.attr(null),
            updated_at: this.attr(null),
            pawn_item_ids: this.attr(null),
            pawn_items: this.hasManyBy(PawnItem, 'pawn_item_ids', 'pawn_id')
        };
    }

    get totalValue() {
        return this.pawn_items.reduce((carry, pawnItem) => {
            carry += pawnItem.item_value ? pawnItem.item_value : 0;

            return carry;
        }, 0);
    }

    static get apiConfig() {
        return {
            dataKey: "pawns",
            baseURL: "/api/pawns",
        };
    }
}
