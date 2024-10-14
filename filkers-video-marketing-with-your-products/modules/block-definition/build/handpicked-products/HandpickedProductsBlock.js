import React from "react";
import ProductDataBlock from "../common/product/ProductDataBlock";
import HandpickedProductsIcon from "./HandpickedProductsIcon";
import ProductDataBlockEdit from "../common/product/ProductDataBlockEdit";
import { __ } from "@wordpress/i18n";
import { PanelBody } from '@wordpress/components';
import ProductSelectControl from "@filkers-wordpress/components/build/product/ProductSelectControl";
class HandpickedProductsBlock extends ProductDataBlock {
    constructor() {
        super({
            name: 'handpicked-products',
            icon: HandpickedProductsIcon,
            title: __('Handpicked Products')
        });
        this.addAttribute('product_ids', { type: "array", default: [] });
    }
    edit() {
        return (props) => (React.createElement(ProductDataBlockEdit, Object.assign({}, props, { block: this }),
            React.createElement(PanelBody, { title: __('Selected products') },
                React.createElement(ProductSelectControl, { value: props?.attributes.product_ids, onChange: value => props.setAttributes({ product_ids: value }) }))));
    }
}
export default HandpickedProductsBlock;
