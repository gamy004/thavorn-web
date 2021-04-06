import Error from 'core/Error';

export const errorMixin = {
    props: {
        error: {
            type: Error,
            default: () => Error.make()
        }
    }
}

export default errorMixin;