import React from "react";
import {View} from '@wordpress/primitives';
import {useBlockProps} from '@wordpress/block-editor';
import FolderPlayerBlock, {FolderPlayerPropsAttrs} from "./FolderPlayerBlock";
import FolderPlayerControls from "./FolderPlayerControls";

// @ts-ignore
import ServerSideRender from '@wordpress/server-side-render';
import {FilkersBlockEditProps} from "../common/AbstractFilkersBlock";

export interface FolderPlayerEditProps extends FilkersBlockEditProps<FolderPlayerPropsAttrs, FolderPlayerBlock> {
}


const FolderPlayerEdit = (props: FolderPlayerEditProps) => {

    const {attributes, block} = props;
    const {uid} = attributes;

    const blockProps = useBlockProps();

    return (
        <View {...blockProps}>
            <FolderPlayerControls
                {...props}
            />
            <ServerSideRender
                key={JSON.stringify(attributes)}
                block={block.getBlockName()}
                attributes={{...attributes, preview: true}}
            />
        </View>
    );

}

export default FolderPlayerEdit;