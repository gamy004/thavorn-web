import { isArray, omit } from "lodash";
import Base from "./Base";

class Error extends Base {
    constructor({
        errors = {}
    } = {}) {
        super();

        this.errors = {};

        this.record(errors);
    }

    static make({
        errors = {}
    } = {}) {
        return new Error({
            errors
        });
    }

    record(errors) {
        this.clear();

        this.errors = { ...errors };

        return this;
    }

    add(errors) {
        this.errors = { ...this.errors, ...errors };

        return this;
    }

    recordResponse(response) {
        if (response && response.data) {
            const { errors = {} } = response.data;

            this.record(errors);
        }

        return this;
    }

    all() {
        return this.errors;
    }

    message(error) {
        let message;

        const target = this.has(error) ?
            this.errors[error] :
            this.get(`errors.${error}`, null);

        if (target && isArray(target) && target.length) {
            message = target[0];
        }

        return message;
    }

    has(error) {
        return this.errors.hasOwnProperty(error);
    }

    state(error) {
        const hasError = this.has(error);

        return hasError ? false : null;
    }

    clear(error = null) {
        if (error) {
            if (this.errors[error]) {
                if (!isArray(error)) {
                    error = [error];
                }

                this.errors = omit(this.errors, error);
            }
        } else {
            this.errors = {};
        }

        return this;
    }
}

export default Error;
