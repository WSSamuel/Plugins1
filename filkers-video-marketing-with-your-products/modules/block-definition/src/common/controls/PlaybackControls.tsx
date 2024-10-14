import React from "react";
import {RangeControl} from "@wordpress/components";
import {__} from "@wordpress/i18n";
import {FilkersBlockAttributesMap} from "../AbstractFilkersBlock";
import {AbstractControlProps} from "./AbstractControls";


export const PLAYBACK_CONTROLS_ATTRS: FilkersBlockAttributesMap = {
    "playback_speed": {type: "number", default: 1},
}

export interface PlaybackControlsAttrs {
    playback_speed: number,
}

export interface PlaybackControlsProps extends AbstractControlProps<PlaybackControlsAttrs> {
}

const SliderControls = ({children, attributes, setAttributes}: PlaybackControlsProps) => {

    const {playback_speed} = attributes;

    return (
        <>
            <RangeControl
                label={__('Playback speed')}
                value={playback_speed}
                onChange={value => setAttributes({playback_speed: value})}
                min={0.5}
                max={2}
                // @ts-ignore
                resetFallbackValue={1.0}
                allowReset={true}
                beforeIcon='clock'
                marks={[
                    {value: 0.5, label: "0.5x"},
                    {value: 1, label: "1x"},
                    {value: 1.5, label: "1.5x"},
                    {value: 2, label: "2x"}
                ]}
                withInputField={false}
                step={0.01}
            />
            {children}
        </>
    );
}

export default SliderControls;