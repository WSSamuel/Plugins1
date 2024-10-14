import React from "react";
import { RangeControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
export const PLAYBACK_CONTROLS_ATTRS = {
    "playback_speed": { type: "number", default: 1 },
};
const SliderControls = ({ children, attributes, setAttributes }) => {
    const { playback_speed } = attributes;
    return (React.createElement(React.Fragment, null,
        React.createElement(RangeControl, { label: __('Playback speed'), value: playback_speed, onChange: value => setAttributes({ playback_speed: value }), min: 0.5, max: 2, 
            // @ts-ignore
            resetFallbackValue: 1.0, allowReset: true, beforeIcon: 'clock', marks: [
                { value: 0.5, label: "0.5x" },
                { value: 1, label: "1x" },
                { value: 1.5, label: "1.5x" },
                { value: 2, label: "2x" }
            ], withInputField: false, step: 0.01 }),
        children));
};
export default SliderControls;
