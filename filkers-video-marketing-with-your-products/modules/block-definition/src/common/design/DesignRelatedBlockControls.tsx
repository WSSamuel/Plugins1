import React, {ReactNode} from "react";
import {BlockEditProps} from "@wordpress/blocks";
import {DesignRelatedBlockAttrs} from "./DesignRelatedBlock";
import {BlockControls, InspectorControls} from '@wordpress/block-editor';
import {ToolbarButton} from "@wordpress/components";
import {__} from "@wordpress/i18n";

export interface DesignRelatedBlockControlsProps<ATTRS extends DesignRelatedBlockAttrs> extends BlockEditProps<ATTRS> {
    children?: ReactNode | ReactNode[];
    onEditRequested: () => any;
}

const DesignRelatedBlockControls = <ATTRS extends DesignRelatedBlockAttrs>(props: DesignRelatedBlockControlsProps<ATTRS>) => {

    const {onEditRequested, children} = props;

    return (
        <>
            <BlockControls>
                <ToolbarButton
                    className="components-toolbar__control"
                    // @ts-ignore
                    label={__('Edit design UID')}
                    icon="edit"
                    onClick={onEditRequested}
                />
            </BlockControls>
            <InspectorControls>
                {children}
            </InspectorControls>
        </>
    );
}

export default DesignRelatedBlockControls;