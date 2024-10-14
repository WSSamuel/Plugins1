import React from "react";
import {SelectControl} from "@wordpress/components";
import {__} from "@wordpress/i18n";
import {FilkersBlockAttributesMap} from "../AbstractFilkersBlock";
import {AbstractControlProps} from "./AbstractControls";
import {useCreation} from "ahooks";
import GridControls, {GRID_CONTROLS_ATTRS, GridControlsAttrs} from "./GridControls";
import SliderControls, {SLIDER_CONTROLS_ATTRS, SliderControlsAttrs} from "./SliderControls";


export const LAYOUT_CONTROLS_ATTRS: FilkersBlockAttributesMap = {
    "layout_type": {type: "string", default: "grid"},
    ...GRID_CONTROLS_ATTRS,
    ...SLIDER_CONTROLS_ATTRS
}

export interface LayoutControlsAttrs extends GridControlsAttrs, SliderControlsAttrs {
    layout_type: string,
}

export interface LayoutControlsProps extends AbstractControlProps<LayoutControlsAttrs> {
}

const LayoutControls = (props: LayoutControlsProps) => {

    const {attributes, setAttributes} = props;
    const {children, ...innerControlProps} = props;

    const {layout_type} = attributes;

    const layoutControls = useCreation(() => {
        switch (layout_type) {
            case "grid":
                return <GridControls {...innerControlProps} />;

            case "slider":
                return <SliderControls {...innerControlProps} minLimit={1} maxLimit={8}/>;

        }
        return null;
    }, [layout_type, innerControlProps]);

    return (
        <>
            <SelectControl
                label={__('Layout type')}
                value={layout_type}
                onChange={(value) => setAttributes({layout_type: value})}
                options={[
                    {label: 'Grid', value: 'grid'},
                    {label: 'Slider', value: 'slider'},
                ]}
            />
            {layoutControls}
            {children}
        </>
    );
}

export default LayoutControls;