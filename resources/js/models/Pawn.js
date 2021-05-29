import { Model } from "@vuex-orm/core";
import Payment from "./Payment";
import PawnItem from "./PawnItem";
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
            pawn_items: this.hasManyBy(PawnItem, 'pawn_item_ids', 'pawn_id'),
            payment_ids: this.attr(null),
            payments: this.hasManyBy(Payment, 'payment_ids', 'pawn_id')
        };
    }

    get totalValue() {
        return this.pawn_items.reduce((carry, pawnItem) => {
            carry += pawnItem.item_value ? pawnItem.item_value : 0;

            return carry;
        }, 0);
    }

    static get apiConfig() {
        const model = this;

        return {
            dataKey: "pawns",
            baseURL: "/api",
            actions: {
                async getPaidAmount(id, month_amount) {
                    let res;

                    try {
                        res = await this.get(
                            `pawns/${id}/paid-amount`,
                            {
                                params: { month_amount },
                                save: false
                            }
                        );
                    } catch (error) {
                        throw error;
                    }

                    const { response } = res;

                    if (response && response.data && response.data.paid_amount) {
                        return response.data.paid_amount;
                    }
                },

                async getCloseAmount(id) {
                    let res;

                    try {
                        res = await this.get(
                            `pawns/${id}/close-amount`,
                            {
                                save: false
                            }
                        );
                    } catch (error) {
                        throw error;
                    }

                    const { response } = res;

                    if (response && response.data) {
                        return response.data;
                    }
                },

                async extend(id, month_amount, amount) {
                    let res;

                    try {
                        res = await this.post(
                            `pawns/${id}/pay`,
                            { month_amount, amount }
                        );
                    } catch (error) {
                        throw error;
                    }

                    const { response } = res;

                    if (response && response.data) {
                        model.update({
                            where: id,
                            data: response.data
                        })

                        return response.data;
                    }
                },

                async close(id, amount) {
                    let res;

                    try {
                        res = await this.post(
                            `pawns/${id}/close`,
                            { amount }
                        );
                    } catch (error) {
                        throw error;
                    }

                    const { response } = res;

                    if (response && response.data) {
                        model.update({
                            where: id,
                            data: response.data
                        })

                        return response.data;
                    }
                }
            }
        };
    }
}
