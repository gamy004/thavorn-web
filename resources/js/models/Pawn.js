import { Model } from "@vuex-orm/core";
import User from "./User"
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
            complete: this.attr(null),
            next_paid_at: this.attr(null),
            latest_paid_at: this.attr(null),
            created_at: this.attr(null),
            updated_at: this.attr(null),
        };
    }

    static get apiConfig() {
        return {
            dataKey: "pawns",
            baseURL: "/api/pawns",
        };
    }
}
