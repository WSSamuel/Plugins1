// @ts-ignore
import { PanelBody } from '@wordpress/components';
import React from "react";
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import SliderControls from "../common/controls/SliderControls";
import SizeControls from "../common/controls/SizeControls";
import PlaybackControls from "../common/controls/PlaybackControls";
import ClickControls from "../common/controls/ClickControls";
import UidControl from "../common/controls/UidControl";
import FolderService from "@filkers-wordpress/services/build/folder/FolderService";
const FolderPlayerControls = (props) => {
    const uidValidator = (uid) => {
        return FolderService
            .checkFolderVisibility(uid);
    };
    return (React.createElement(InspectorControls, null,
        React.createElement(PanelBody, { title: __('Content settings') },
            React.createElement(UidControl, Object.assign({}, props, { uidValidator: uidValidator, placeholder: __('Paste folder UID here'), uidHelpLink: "https://www.filkers.com/filkers-folder-player/" })),
            React.createElement(SliderControls, Object.assign({}, props))),
        React.createElement(PanelBody, { title: __('Playback settings') },
            React.createElement(SizeControls, Object.assign({}, props)),
            React.createElement(PlaybackControls, Object.assign({}, props))),
        React.createElement(PanelBody, { title: __('Click settings') },
            React.createElement(ClickControls, Object.assign({}, props)))));
};
export default FolderPlayerControls;
