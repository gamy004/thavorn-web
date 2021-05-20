import { Model } from "@vuex-orm/core";

export default class Evidence extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return "evidences";
    }

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.
    static fields() {
        return {
            id: this.attr(null),
            path: this.string(''),
            original_name: this.string(''),
            mime: this.string(''),
            extension: this.string(''),
            pivot: this.attr(null),
            created_at: this.attr(null),
            updated_at: this.attr(null)
        };
    }

    static destroy() {
        return this.api().destroy(this.id);
    }

    static get apiConfig() {
        const model = this;

        return {
            dataKey: "files",
            baseURL: "/api/files",
            actions: {
                async destroy(id) {
                    let promise;

                    try {
                        promise = await this.delete(`/${id}`, { save: false });

                        model.delete(id);

                    } catch (error) {
                        throw error;
                    }

                    return promise;
                },

                async download(id) {
                    return await this.get(`/evidences/${id}`, { responseType: 'blob', save: false });
                }
            }
        };
    }
}
