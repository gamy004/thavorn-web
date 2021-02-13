import { Model } from "@vuex-orm/core";

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
            interest_rate: this.number('3.00'),
            customer_id: this.attr(null),
        };
    }

    static get apiConfig() {
        return {
            dataKey: "pawns",
            baseURL: "/api/pawns",
        };
    }
}
