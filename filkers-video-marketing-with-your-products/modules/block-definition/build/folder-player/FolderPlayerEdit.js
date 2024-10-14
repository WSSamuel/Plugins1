import React from "react";
import { View } from '@wordpress/primitives';
import { useBlockProps } from '@wordpress/block-editor';
import FolderPlayerControls from "./FolderPlayerControls";
// @ts-ignore
import ServerSideRender from '@wordpress/server-side-render';
const FolderPlayerEdit = (props) => {
    const { attributes, block } = props;
    const { uid } = attributes;
    const blockProps = useBlockProps();
    return (React.createElement(View, Object.assign({}, blockProps),
        React.createElement(FolderPlayerControls, Object.assign({}, props)),
        React.createElement(ServerSideRender, { key: JSON.stringify(attributes), block: block.getBlockName(), attributes: { ...attributes, preview: true } })));
};
export default FolderPlayerEdit;
