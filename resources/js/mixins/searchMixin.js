import Pawn from "../models/Pawn";
import PawnItem from "../models/PawnItem";
import User from "../models/User";
import PawnUserItem from "../models/PawnUserItem";
import { sumBy, groupBy, mapValues, omit } from "lodash"

export const searchMixin = {
    data() {
        return {
            perPage: 20,
            currentPage: 1,
            totalRows: 0,
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
        pawnUserItems() {
            return PawnUserItem.query().with(['pawn_items']).all();
        },
        closabledPawnUserItems() {
            return PawnUserItem.query().with(['pawn_items'])
                .where('complete', false)
                .get();
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

        fetchPawnDetailByPawnId(id) {
            return Pawn.api().get(`/pawns/${id}`, {
                params: {
                    // filters: [
                    //     {
                    //         key: 'pawn_id',
                    //         value: pawnId
                    //     },
                    //     {
                    //         key: 'complete',
                    //         value: 0
                    //     }
                    // ],
                    includes: [
                        'pawn_items',
                        'pawn_items.item_damage',
                        'pawn_items.item_category',
                        'payments'
                    ]
                },
            });
        },

        fetchPawnItemsByPawnId(pawnId) {
            return PawnItem.api().get("/pawn_items", {
                params: {
                    filters: [
                        {
                            key: 'pawn_id',
                            value: pawnId
                        },
                        {
                            key: 'complete',
                            value: 0
                        }
                    ],
                    includes: [
                        'item_damage',
                        'item_category'
                    ]
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
            PawnUserItem.deleteAll()
        },

        async searchPawnByCustomerData({
            select = ['pawns:id,full_name,identity_card_id,pawn_no,interest_rate,complete,customer_id,created_at,updated_at,latest_paid_at,next_paid_at'],
            includes = [],
            filters = [
                {
                    key: 'complete',
                    value: 0
                }
            ]
        } = {}) {
            const { perPage: limit, currentPage: page } = this;
            let items = [];

            PawnItem.deleteAll();
            PawnUserItem.deleteAll();

            try {
                this.search = true;
                this.loading = true;

                let promise,
                    params = {
                        filters,
                        select,
                        page,
                        limit
                    };

                if (this.searchInput && this.searchInput.length) {
                    this.$set(
                        params,
                        'search',
                        {
                            keyword: this.searchInput,
                            fields: [
                                'full_name',
                                'identity_card_id',
                                'pawn_no'
                            ],
                        },
                    )
                }

                if (includes.length) {
                    this.$set(params, 'includes', includes);
                }

                promise = await PawnUserItem.api().get('/', {
                    params
                });

                const { total = 0, pawns = [] } = promise.response.data;

                this.totalRows = total;
                items = pawns;
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }

            return items;
        },

        searchPawnByCustomerDataWithItems() {
            return this.searchPawnByCustomerData({
                select: ['pawns:id,full_name,identity_card_id,pawn_no,interest_rate,complete,customer_id,created_at,updated_at,latest_paid_at,next_paid_at,count_items,total_items_value']
            })
        },

        searchAllPawnByCustomerDataWithItems() {
            return this.searchPawnByCustomerData({
                select: ['pawns:id,full_name,identity_card_id,pawn_no,interest_rate,complete,customer_id,created_at,updated_at,latest_paid_at,next_paid_at,count_items,total_items_value'],
                filters: []
            })
        },
    },
}