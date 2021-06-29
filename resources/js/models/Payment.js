import { Model } from "@vuex-orm/core";
import Pawn from './Pawn';
import moment from 'moment';

function formatingDatetime(datetime, format) {
    moment.locale('th');

    let formattedDatetime = datetime
        ? moment(datetime).add(543, 'year').format(format)
        : 'ไม่ระบุ';

    return formattedDatetime;
}

export default class Payment extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return "payments";
    }

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.
    static fields() {
        return {
            id: this.attr(null),
            amount: this.number(0),
            month_amount: this.number(0),
            time_start_at: this.attr(null),
            time_end_at: this.attr(null),
            created_at: this.attr(null),
            updated_at: this.attr(null),
            pawn_id: this.attr(null),
            pawn: this.belongsTo(Pawn, 'pawn_id')
        };
    }

    get timeDescription() {
        let payment_datetime = formatingDatetime(this.created_at, "DD MMM YYYY");

        let description = `${payment_datetime}`;

        if (this.time_start_at || this.time_end_at) {
            let time_start_month = formatingDatetime(this.time_start_at, "DD MMM YY");

            description += ` - ต่ออายุดอกเบี้ย ${time_start_month}`;

            if (this.time_end_at !== null && this.time_start_at !== this.time_end_at) {
                let time_end = new Date(this.time_end_at);

                time_end.setMonth(time_end.getMonth());

                let time_end_month = formatingDatetime(time_end, "DD MMM YY");

                description += ` - ${time_end_month}`;
            }

            description += this.month_amount > 0 ? ` (${this.month_amount} เดือน)` : ' (ไถ่ถอน)';
        }

        return description;
    }

    static get apiConfig() {
        return {
            dataKey: "payments",
            baseURL: "/api",
        };
    }
}
