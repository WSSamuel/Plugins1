// @ts-ignore
import {__experimentalUnitControl as UnitControl, PanelBody, RangeControl, SelectControl, TextControl, ToggleControl, ToolbarButton} from '@wordpress/components';

import React from "react";
import {__} from '@wordpress/i18n';
import {InspectorControls} from '@wordpress/block-editor';
import {FolderPlayerPropsAttrs} from "./FolderPlayerBlock";
import SliderControls from "../common/controls/SliderControls";
import SizeControls from "../common/controls/SizeControls";
import PlaybackControls from "../common/controls/PlaybackControls";
import ClickControls from "../common/controls/ClickControls";
import {FilkersBlockEditProps} from "../common/AbstractFilkersBlock";
import UidControl from "../common/controls/UidControl";
import FolderService from "@filkers-wordpress/services/build/folder/FolderService";


export interface FolderPlayerControlsProps extends FilkersBlockEditProps<FolderPlayerPropsAttrs> {
}

const FolderPlayerControls = (props: FolderPlayerControlsProps) => {

    const uidValidator = (uid: string) => {
        return FolderService
            .checkFolderVisibility(uid)
    }

    return (
        <InspectorControls>

            <PanelBody title={__('Content settings')}>
                <UidControl
                    {...props}
                    uidValidator={uidValidator}
                    placeholder={__('Paste folder UID here')}
                    uidHelpLink="https://www.filkers.com/filkers-folder-player/"
                />
                <SliderControls {...props} />
            </PanelBody>

            <PanelBody title={__('Playback settings')}>
                <SizeControls {...props} />
                <PlaybackControls {...props} />
            </PanelBody>

            <PanelBody title={__('Click settings')}>
                <ClickControls {...props} />
            </PanelBody>


        </InspectorControls>
    );


}

export default FolderPlayerControls;