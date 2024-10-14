import React from "react";
import { BlockControls, InspectorControls } from '@wordpress/block-editor';
import { ToolbarButton } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
const DesignRelatedBlockControls = (props) => {
    const { onEditRequested, children } = props;
    return (React.createElement(React.Fragment, null,
        React.createElement(BlockControls, null,
            React.createElement(ToolbarButton, { className: "components-toolbar__control", 
                // @ts-ignore
                label: __('Edit design UID'), icon: "edit", onClick: onEditRequested })),
        React.createElement(InspectorControls, null, children)));
};
export default DesignRelatedBlockControls;
