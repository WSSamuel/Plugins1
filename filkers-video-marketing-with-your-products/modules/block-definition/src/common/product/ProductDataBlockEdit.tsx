import React from "react";
import {View} from '@wordpress/primitives';
import {useBlockProps} from '@wordpress/block-editor';

// @ts-ignore
import ServerSideRender from '@wordpress/server-side-render';
import {FilkersBlockEditProps} from "../AbstractFilkersBlock";
import ProductDataBlock, {ProductDataBlockAttrs} from "./ProductDataBlock";
import ProductDataBlockControls from "./ProductDataBlockControls";
import WooCommerceNotInstalledPanel from "./WooCommerceNotInstalledPanel";

export interface ProductDataBlockEditProps extends FilkersBlockEditProps<ProductDataBlockAttrs, ProductDataBlock<any>> {
}


const ProductDataBlockEdit = (props: ProductDataBlockEditProps) => {

    const {attributes, setAttributes, block} = props;
    const {uid} = attributes;
    const {children, ...propagatedProps} = props;

    const blockProps = useBlockProps();

    // @ts-ignore
    if (filkersBlocksGlobalVariables.isWooActive !== "1") {
        return <WooCommerceNotInstalledPanel/>;
    }

    return (
        <View {...blockProps}>
            <ProductDataBlockControls
                {...propagatedProps}
            >
                {children}
            </ProductDataBlockControls>
            <ServerSideRender
                key={JSON.stringify(attributes)}
                block={block.getBlockName()}
                attributes={{...attributes, preview: true}}
            />
        </View>
    );

}

export default ProductDataBlockEdit;