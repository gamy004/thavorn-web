import { Model } from "@vuex-orm/core";
import Pawn from './Pawn';
import User from './User';

export default class PawnUserItem extends Pawn {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return "pawn_users";
    }

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.
    static fields() {
        return {
            ...Pawn.fields(),
            full_name: this.attr(""),
            identity_card_id: this.attr(null)
        };
    }

    static get apiConfig() {
        return {
            dataKey: "pawns",
            baseURL: "/api/pawn_user_items",
        };
    }
}
