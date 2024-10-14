import React from "react";
import ProductDataBlock, {ProductDataBlockAttrs} from "../common/product/ProductDataBlock";
import HandpickedProductsIcon from "./HandpickedProductsIcon";
import {BlockEditProps} from "@wordpress/blocks";
import ProductDataBlockEdit from "../common/product/ProductDataBlockEdit";
import {__} from "@wordpress/i18n";
import {PanelBody} from '@wordpress/components';
import ProductSelectControl from "@filkers-wordpress/components/build/product/ProductSelectControl";


export interface HandpickedProductsBlockAttrs extends ProductDataBlockAttrs {
    product_ids: number[]
}

class HandpickedProductsBlock extends ProductDataBlock<HandpickedProductsBlockAttrs> {

    constructor() {
        super({
            name: 'handpicked-products',
            icon: HandpickedProductsIcon,
            title: __('Handpicked Products')
        });

        this.addAttribute('product_ids', {type: "array", default: []});
    }

    protected edit(): React.ComponentType<BlockEditProps<HandpickedProductsBlockAttrs>> {
        return (props) => (
            <ProductDataBlockEdit {...props} block={this}>
                <PanelBody title={__('Selected products')}>
                    <ProductSelectControl value={props?.attributes.product_ids} onChange={value => props.setAttributes({product_ids: value})}/>
                </PanelBody>
            </ProductDataBlockEdit>
        );
    }
}

export default HandpickedProductsBlock;