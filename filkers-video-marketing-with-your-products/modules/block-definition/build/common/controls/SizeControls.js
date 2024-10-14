import React from "react";
//@ts-ignore
import { __experimentalUnitControl as UnitControl, SelectControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
export const SIZE_CONTROLS_ATTRS = {
    "size_ar": { type: "string", default: "size_16_by_9" },
    "size_width": { type: "string", default: "" },
    "size_height": { type: "string", default: "" },
};
const SizeControlsProps = ({ children, attributes, setAttributes }) => {
    const { size_ar, size_width, size_height } = attributes;
    return (React.createElement(React.Fragment, null,
        React.createElement(SelectControl, { label: __('Aspect ratio'), value: size_ar, onChange: (value) => setAttributes({ size_ar: value, size_width: "", size_height: "" }), options: [
                { label: 'Fill', value: 'size_auto' },
                { label: 'Vertical 9:16', value: 'size_9_by_16' },
                { label: 'Vertical 4:5', value: 'size_4_by_5' },
                { label: 'Square 1:1', value: 'size_1_by_1' },
                { label: 'Horizontal 16:9', value: 'size_16_by_9' },
                { label: 'Horizontal 3:1', value: 'size_3_by_1' },
                { label: 'Horizontal 4:1', value: 'size_4_by_1' }
            ] }),
        size_ar === "size_man" ? (React.createElement("div", { className: "block-editor-filkers-folder-player__row" },
            React.createElement(UnitControl, { label: __('Width'), value: size_width, onChange: value => setAttributes({ size_width: value }) }),
            React.createElement(UnitControl, { label: __('Height'), value: size_height, onChange: value => setAttributes({ size_height: value }) }))) : null,
        children));
};
export default SizeControlsProps;
