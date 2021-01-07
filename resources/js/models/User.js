import { Model } from "@vuex-orm/core";

export default class User extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return "users";
    }

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.
    static fields() {
        return {
            id: this.attr(null),
            first_name: this.attr(""),
            last_name: this.attr(""),
            full_name: this.attr(""),
            gender: this.attr("M"),
            phone_number: this.attr(""),
            identity_card_id: this.attr(null),
            email: this.attr(null),
            facebook: this.attr(null),
            line: this.attr(null),
            note: this.attr(null),
            role_id: this.attr(null)
        };
    }

    static get apiConfig() {
        return {
            dataKey: "users"
        };
    }
}
