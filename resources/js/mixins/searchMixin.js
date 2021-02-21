import Pawn from "../models/Pawn";
import PawnItem from "../models/PawnItem";
import User from "../models/User";
import { sumBy } from "lodash"

export const searchMixin = {
    models: [Pawn, User, PawnItem],

    data() {
        return {
            searchInput: "",
            search: false,
            loading: false,
        }
    },

    computed: {
        pawns() {
            return Pawn.query().get()
        },
        user() {
            return User.query().first()
        },
        pawnItems() {
            return PawnItem.query().get()
        },
        fullName() {
            return this.user ? this.user.full_name : "-"
        }
    },

    methods: {
        async fetchPawns(keyword = "", fieldKeys = []) {
            return Pawn.api().get("/pawns", {
                params: {
                    search: {
                        keyword: keyword,
                        fields: fieldKeys,
                    },
                },
            });
        },
        async fetchPawnItems(keyword = "", fieldKeys = []) {
            return PawnItem.api().get("/pawn_user_items", {
                params: {
                    search: {
                        keyword: keyword,
                        fields: fieldKeys,
                    },
                },
            });
        },
        fullNameByPawnNo(id) {
            console.log('1');
            return PawnItem.query().where('pawn_no', id).first() ? `${PawnItem.query().where('pawn_no', id).first().first_name} ${PawnItem.query().where('pawn_no', id).first().last_name}` : this.fullName
        },
        pawnItemByPawnNo(id) {
            console.log('2');
            return PawnItem.query().where('pawn_no', id).get() ? PawnItem.query().where('pawn_no', id).get() : []
        },
        pawnItemCount(id) {
            console.log('3');
            return this.pawnItemByPawnNo(id) ? this.pawnItemByPawnNo(id).length : "0"
        },
        sumPawnItemValueByPawnNo(id) {
            if (!this.pawnItemByPawnNo(id)) return "0"
            let sumItemValue = sumBy(this.pawnItemByPawnNo(id), 'item_value')
            sumItemValue = sumItemValue.toString().split(".")
            console.log('4');
            if (sumItemValue.length > 1) {
                return `${sumItemValue[0]}.${sumItemValue[1].substring(0, 2)}`
            } else {
                return `${sumItemValue[0]}`
            }
            // return sumBy(this.pawnItemByPawnNo(id), 'item_value')
        },
        clearDataVuex(){
            User.deleteAll() // Delete all Users.
            Pawn.deleteAll() // Delete all Pawns.
            PawnItem.deleteAll() // Delete all PawnItems.
        },
        async searchPawnByCustomerData() {
            if (!this.searchInput) return;
                this.clearDataVuex()
            try {
                /*
                    Search Pawn by Pawn ID
                */
                this.search = true;
                this.loading = true;
                let { response } = await this.fetchPawns(this.searchInput, ["pawn_no"]);
                if (response && response.data && response.data.pawns.length) {
                    await this.fetchPawnItems(this.searchInput, ["pawn_no"]);

                } else {
                    /*
                        Search Pawn by Customer Name and Identity ID
                    */
                    let { response } = await User.api().get("users", {
                        params: {
                            search: {
                                keyword: this.searchInput,
                                fields: ["full_name", "identity_card_id"],
                            },
                        }
                    });
                    if (response && response.data && response.data.users.length) {
                        let { users = [] } = response.data;
                        let result = await this.fetchPawns(users[0].id, ["customer_id"]);
                        if (
                            result.response &&
                            result.response.data &&
                            result.response.data.pawns.length
                        ) {
                            await this.fetchPawnItems(users[0].id, ["customer_id"]);
                        }
                    }
                }
            } catch (error) {

            } finally {
                this.loading = false;
            }
        }
    },
}