import React from "react";
import { SelectControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
export const PRODUCT_CARD_CONTROLS_ATTRS = {
    "product_card_button_type": { type: "string", default: "buy_now" }
};
const ProductCardControls = (props) => {
    const { attributes, setAttributes, children } = props;
    const { product_card_button_type } = attributes;
    return (React.createElement(React.Fragment, null,
        React.createElement(SelectControl, { label: __('Product Button type'), value: product_card_button_type, onChange: (value) => setAttributes({ product_card_button_type: value }), options: [
                { label: 'None', value: 'none' },
                { label: 'Add to cart', value: 'add_to_cart' },
                { label: 'Buy now', value: 'buy_now' },
            ] }),
        children));
};
export default ProductCardControls;
