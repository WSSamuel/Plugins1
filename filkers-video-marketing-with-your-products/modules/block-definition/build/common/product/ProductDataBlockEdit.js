import React from "react";
import { View } from '@wordpress/primitives';
import { useBlockProps } from '@wordpress/block-editor';
// @ts-ignore
import ServerSideRender from '@wordpress/server-side-render';
import ProductDataBlockControls from "./ProductDataBlockControls";
import WooCommerceNotInstalledPanel from "./WooCommerceNotInstalledPanel";
const ProductDataBlockEdit = (props) => {
    const { attributes, setAttributes, block } = props;
    const { uid } = attributes;
    const { children, ...propagatedProps } = props;
    const blockProps = useBlockProps();
    // @ts-ignore
    if (filkersBlocksGlobalVariables.isWooActive !== "1") {
        return React.createElement(WooCommerceNotInstalledPanel, null);
    }
    return (React.createElement(View, Object.assign({}, blockProps),
        React.createElement(ProductDataBlockControls, Object.assign({}, propagatedProps), children),
        React.createElement(ServerSideRender, { key: JSON.stringify(attributes), block: block.getBlockName(), attributes: { ...attributes, preview: true } })));
};
export default ProductDataBlockEdit;
