import React from "react";
import { PanelBody, ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
export const SLIDER_BLOCK_ATTRS = {
    "slider_arrows": { type: "string", default: "none" },
    "slider_dots": { type: "string", default: "none" },
    "slider_random": { type: "boolean", default: false }
};
const SliderControls = ({ children, attributes, setAttributes }) => {
    const { slider_arrows, slider_dots, slider_random } = attributes;
    return (React.createElement(PanelBody, { title: __('Slider settings') },
        React.createElement(ToggleControl, { label: __('Show navigation arrows'), checked: slider_arrows !== "none", onChange: checked => setAttributes({ slider_arrows: checked ? "arrows" : "none" }) }),
        React.createElement(ToggleControl, { label: __('Show navigation dots'), checked: slider_dots !== "none", onChange: checked => setAttributes({ slider_dots: checked ? "dots" : "none" }) }),
        React.createElement(ToggleControl, { label: __('Start at a random element'), checked: slider_random === true, onChange: checked => setAttributes({ slider_random: checked }) }),
        children));
};
export default SliderControls;
