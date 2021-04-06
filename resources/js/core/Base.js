import { get as _get, set as _set } from "lodash";

export function get(data, key, defval = null) {
    return _get(data, key, defval);
}

export function set(data, key = '', value = null) {
    if (typeof key == 'object' && !value) {
        for (const k in key) {
            if (key.hasOwnProperty(k)) {
                _set(data, k, get(key, k));
            }
        }
    } else if (value === null) {
        data = key;
    } else {
        _set(data, key, value);
    }
}

export function toggle(data, key = '') {
    if (data.hasOwnProperty(key)) {
        data[key] = !data[key];
    }

    return data;
}

export const helper = {
    get,
    set,
    toggle
};

class Base {
    constructor() {
        //
    }

    get(key, defval = null) {
        return get(this, key, defval);
    }

    set(key, value) {
        this[key] = value;
    }

    toggle(key) {
        toggle(this, key);
    }

    has(key) {
        return this.get(key) !== null;
    }

    remember(key, fn) {
        if (!this.has(key)) {
            this.set(key, fn);
        }

        return this.get(key);
    }

    // set data(object = {}) {
    //     this.$data = {
    //         ...this.$data,
    //         ...object
    //     };

    //     this.backup = {
    //         ...this.$data
    //     };

    //     for (let field in object) {
    //         this[field] = object[field]
    //     }
    // }

    // get data() {
    //     let data = {};

    //     for (let property in this.$data) {
    //         data[property] = this[property];
    //     }

    //     return data;
    // }
}

export default Base;
