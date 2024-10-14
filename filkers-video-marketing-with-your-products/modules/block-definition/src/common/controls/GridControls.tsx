import React from "react";
import {RangeControl, ToggleControl} from "@wordpress/components";
import {__} from "@wordpress/i18n";
import {FilkersBlockAttributesMap} from "../AbstractFilkersBlock";
import {AbstractControlProps} from "./AbstractControls";


export const GRID_CONTROLS_ATTRS: FilkersBlockAttributesMap = {
    "show_button": {type: "boolean", default: false},
    "grid_columns": {type: "number", default: 4},
    "grid_rows": {type: "number", default: 1},
}

export interface GridControlsAttrs {
    show_button: boolean,
    grid_columns: number,
    grid_rows: number,
}

export interface GridControlsProps extends AbstractControlProps<GridControlsAttrs> {
}

const GridControls = ({children, attributes, setAttributes}: GridControlsProps) => {

    const {show_button, grid_columns, grid_rows} = attributes;

    return (
        <>
            <ToggleControl
                label={__('Add to cart button', 'filkers-wordpress-blocks')}
                help={__('Add to cart button is visible', 'filkers-wordpress-blocks')}
                checked={show_button === true}
                onChange={checked => setAttributes({show_button: checked})}
            />

            <RangeControl
                label={__('Grid columns')}
                value={grid_columns}
                onChange={value => setAttributes({grid_columns: value})}
                min={1}
                max={4}
                //@ts-ignore
                marks={[
                    {value: 1, label: "1"},
                    {value: 2, label: "2"},
                    {value: 3, label: "3"},
                    {value: 4, label: "4"},
                ]}
                step={1}
            />
            {children}
        </>
    );
}

export default GridControls;