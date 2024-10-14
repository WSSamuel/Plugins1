import React from "react";
import {RangeControl, ToggleControl} from "@wordpress/components";
import {__} from "@wordpress/i18n";
import {FilkersBlockAttributesMap} from "../AbstractFilkersBlock";
import {AbstractControlProps} from "./AbstractControls";
import {useCreation} from "ahooks";


export const SLIDER_CONTROLS_ATTRS: FilkersBlockAttributesMap = {
    "slider_arrows": {type: "string", default: "arrows"},
    "slider_dots": {type: "string", default: "dots"},
    "slider_random": {type: "boolean", default: false},
    "slider_limit": {type: "number", default: 4}
}

export interface SliderControlsAttrs {
    slider_arrows: string,
    slider_dots: string,
    slider_random: boolean,
    slider_limit: number
}

export interface SliderControlsProps extends AbstractControlProps<SliderControlsAttrs> {
    maxLimit?: number,
    minLimit?: number,
}

const SliderControls = (props: SliderControlsProps) => {

    const {attributes, maxLimit, minLimit, setAttributes, children} = props;
    const {slider_arrows, slider_dots, slider_random, slider_limit} = attributes;

    const rangeControlMarks = useCreation(() => {
        if (minLimit !== undefined && maxLimit !== undefined) {
            const marks = [];
            for (let i = minLimit; i <= maxLimit; i++) {
                marks.push({value: i, label: `${i}`});
            }
            return marks;
        }
    }, [minLimit, maxLimit]);

    return (
        <>
            <ToggleControl
                label={__('Show navigation arrows')}
                checked={slider_arrows !== "none"}
                onChange={checked => setAttributes({slider_arrows: checked ? "arrows" : "none"})}
            />
            <ToggleControl
                label={__('Show navigation dots')}
                checked={slider_dots !== "none"}
                onChange={checked => setAttributes({slider_dots: checked ? "dots" : "none"})}
            />
            <ToggleControl
                label={__('Start at a random element')}
                checked={slider_random === true}
                onChange={checked => setAttributes({slider_random: checked})}
            />
            {maxLimit !== undefined && minLimit !== undefined ? (
                <RangeControl
                    label={__('Max results limit')}
                    value={slider_limit}
                    onChange={value => setAttributes({slider_limit: value})}
                    min={minLimit}
                    max={maxLimit}
                    //@ts-ignore
                    marks={rangeControlMarks}
                    step={1}
                />
            ) : null}

            {children}
        </>
    );
}

export default SliderControls;