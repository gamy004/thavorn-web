import Pawn from "../models/Pawn";
import PawnItem from "../models/PawnItem";
import User from "../models/User";
import { sumBy, groupBy, mapValues, omit } from "lodash"

export const searchMixin = {
    models: [Pawn, User, PawnItem],

    data() {
        return {
            searchInput: "",
            search: false,
            loading: false,
            items: {}
        }
    },

    computed: {
        pawns() {
            return Pawn.query().get()
        },
        user() {
            return groupBy(User.query().get(), user => user.id);
        },
        pawnItems() {
            return PawnItem.query().get();
        },
        pawnItemsByPawnID() {
            return groupBy(PawnItem.query().get(), pawn_item => pawn_item.pawn_id);
        },
        fullName() {
            return this.user ? this.user.full_name : "-"
        }
    },

    methods: {
        fetchPawns(keyword = "", fieldKeys = []) {
            return Pawn.api().get("/pawns", {
                params: {
                    search: {
                        keyword: keyword,
                        fields: fieldKeys,
                    },
                    includes: [
                        "user",
                        "pawn_items",
                        "pawns.pawn_items.item_damage",
                        "pawns.pawn_items.item_category"
                    ]
                },
            });
        },
        fetchUserPawn(keyword = "", fieldKeys = []) {
            return User.api().get("users", {
                params: {
                    search: {
                        keyword: keyword,
                        fields: fieldKeys,
                    },
                    includes: [
                        "pawns",
                        "pawns.pawn_items",
                        "pawns.pawn_items.item_category",
                        "pawns.pawn_items.item_damage"
                    ]
                }
            });
        },
        fetchPawnItems(keyword = "", fieldKeys = []) {
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
        clearDataVuex() {
            User.deleteAll() // Delete all Users.
            Pawn.deleteAll() // Delete all Pawns.
            PawnItem.deleteAll() // Delete all PawnItems.
        },
        async searchPawnByCustomerData() {
            if (!this.searchInput) return;
            this.clearDataVuex()
            try {
                this.search = true;
                this.loading = true;
                // let { response } = await this.fetchPawnItems(this.searchInput, ["pawn_no", "first_name", "last_name", "identity_card_id"]);
                // if (response && response.data && response.data.pawn_items) {
                //     const { pawn_items } = response.data
                //     this.items = groupBy(pawn_items, pawn_item => pawn_item.pawn_no);
                // }

                /*
                    Search Pawn by Pawn ID, Name, Identity Card ID
                */
                let { response } = await this.fetchPawns(this.searchInput, ["pawn_no"]);

                if (response && response.data && !response.data.pawns.length) {
                    /*
                        Search Pawn by Customer Name and Identity ID
                    */
                    await this.fetchUserPawn(this.searchInput, ["full_name", "identity_card_id"])
                }
            } catch (error) {

            } finally {
                this.loading = false;
            }
        }
    },
}