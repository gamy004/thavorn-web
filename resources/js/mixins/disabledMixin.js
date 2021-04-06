export const disabledMixin = {
    props: {
        disabled: {
            type: Boolean,
            default: () => false
        }
    }
}

export default disabledMixin;