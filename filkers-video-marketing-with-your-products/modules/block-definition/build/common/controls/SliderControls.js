import React from "react";
import { RangeControl, ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useCreation } from "ahooks";
export const SLIDER_CONTROLS_ATTRS = {
    "slider_arrows": { type: "string", default: "arrows" },
    "slider_dots": { type: "string", default: "dots" },
    "slider_random": { type: "boolean", default: false },
    "slider_limit": { type: "number", default: 4 }
};
const SliderControls = (props) => {
    const { attributes, maxLimit, minLimit, setAttributes, children } = props;
    const { slider_arrows, slider_dots, slider_random, slider_limit } = attributes;
    const rangeControlMarks = useCreation(() => {
        if (minLimit !== undefined && maxLimit !== undefined) {
            const marks = [];
            for (let i = minLimit; i <= maxLimit; i++) {
                marks.push({ value: i, label: `${i}` });
            }
            return marks;
        }
    }, [minLimit, maxLimit]);
    return (React.createElement(React.Fragment, null,
        React.createElement(ToggleControl, { label: __('Show navigation arrows'), checked: slider_arrows !== "none", onChange: checked => setAttributes({ slider_arrows: checked ? "arrows" : "none" }) }),
        React.createElement(ToggleControl, { label: __('Show navigation dots'), checked: slider_dots !== "none", onChange: checked => setAttributes({ slider_dots: checked ? "dots" : "none" }) }),
        React.createElement(ToggleControl, { label: __('Start at a random element'), checked: slider_random === true, onChange: checked => setAttributes({ slider_random: checked }) }),
        maxLimit !== undefined && minLimit !== undefined ? (React.createElement(RangeControl, { label: __('Max results limit'), value: slider_limit, onChange: value => setAttributes({ slider_limit: value }), min: minLimit, max: maxLimit, 
            //@ts-ignore
            marks: rangeControlMarks, step: 1 })) : null,
        children));
};
export default SliderControls;
