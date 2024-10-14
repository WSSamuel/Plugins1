import React from "react";
import { SelectControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useCreation } from "ahooks";
import GridControls, { GRID_CONTROLS_ATTRS } from "./GridControls";
import SliderControls, { SLIDER_CONTROLS_ATTRS } from "./SliderControls";
export const LAYOUT_CONTROLS_ATTRS = {
    "layout_type": { type: "string", default: "grid" },
    ...GRID_CONTROLS_ATTRS,
    ...SLIDER_CONTROLS_ATTRS
};
const LayoutControls = (props) => {
    const { attributes, setAttributes } = props;
    const { children, ...innerControlProps } = props;
    const { layout_type } = attributes;
    const layoutControls = useCreation(() => {
        switch (layout_type) {
            case "grid":
                return React.createElement(GridControls, Object.assign({}, innerControlProps));
            case "slider":
                return React.createElement(SliderControls, Object.assign({}, innerControlProps, { minLimit: 1, maxLimit: 8 }));
        }
        return null;
    }, [layout_type, innerControlProps]);
    return (React.createElement(React.Fragment, null,
        React.createElement(SelectControl, { label: __('Layout type'), value: layout_type, onChange: (value) => setAttributes({ layout_type: value }), options: [
                { label: 'Grid', value: 'grid' },
                { label: 'Slider', value: 'slider' },
            ] }),
        layoutControls,
        children));
};
export default LayoutControls;
