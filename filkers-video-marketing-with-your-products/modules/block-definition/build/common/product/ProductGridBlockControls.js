import React from "react";
import { __ } from '@wordpress/i18n';
import { PanelBody, RangeControl, SelectControl } from "@wordpress/components";
import DesignRelatedBlockControls from "../design/DesignRelatedBlockControls";
;
const ProductGridBlockControls = (props) => {
    const { attributes, setAttributes } = props;
    const { columns, buttonType, speed } = attributes;
    return (React.createElement(DesignRelatedBlockControls, Object.assign({}, props),
        React.createElement(PanelBody, { title: __('Grid settings') },
            React.createElement(RangeControl, { label: __('Grid columns'), value: columns, onChange: value => setAttributes({ columns: value }), min: 1, max: 4, 
                //@ts-ignore
                marks: [
                    { value: 1, label: "1" },
                    { value: 2, label: "2" },
                    { value: 3, label: "3" },
                    { value: 4, label: "4" },
                ], step: 1 }),
            React.createElement(SelectControl, { label: __('Product Button type'), value: buttonType, onChange: (value) => setAttributes({ buttonType: value }), options: [
                    { label: 'None', value: 'none' },
                    { label: 'Add to cart', value: 'add_to_cart' },
                    { label: 'Buy now', value: 'buy_now' },
                ] })),
        React.createElement(PanelBody, { title: __('Playback settings') },
            React.createElement(RangeControl, { label: __('Playback speed'), value: speed, onChange: value => setAttributes({ speed: value }), min: 0.5, max: 2, 
                //@ts-ignore
                resetFallbackValue: 1.0, allowReset: true, beforeIcon: 'clock', marks: [
                    { value: 0.5, label: "0.5x" },
                    { value: 1, label: "1x" },
                    { value: 1.5, label: "1.5x" },
                    { value: 2, label: "2x" }
                ], withInputField: false, step: 0.01 }))));
};
export default ProductGridBlockControls;
