import React from "react";
import FolderPlayerIcon from "./FolderPlayerIcon";
import { __ } from "@wordpress/i18n";
import FolderPlayerEdit from "./FolderPlayerEdit";
import { SLIDER_CONTROLS_ATTRS } from "../common/controls/SliderControls";
import AbstractServerSideRenderedBlock from "../common/AbstractServerSideRenderedBlock";
import { SIZE_CONTROLS_ATTRS } from "../common/controls/SizeControls";
import { PLAYBACK_CONTROLS_ATTRS } from "../common/controls/PlaybackControls";
import { CLICK_CONTROLS_ATTRS } from "../common/controls/ClickControls";
import { UID_CONTROLS_ATTRS } from "../common/controls/UidControl";
export default class FolderPlayerBlock extends AbstractServerSideRenderedBlock {
    constructor() {
        super({
            name: 'folder-player',
            icon: FolderPlayerIcon,
            title: __('Folder Player')
        });
        this.addAllAttributes(UID_CONTROLS_ATTRS);
        this.addAllAttributes(CLICK_CONTROLS_ATTRS);
        this.addAllAttributes(PLAYBACK_CONTROLS_ATTRS);
        this.addAllAttributes(SLIDER_CONTROLS_ATTRS);
        this.addAllAttributes(SIZE_CONTROLS_ATTRS);
    }
    edit() {
        return (props) => React.createElement(FolderPlayerEdit, Object.assign({}, props, { block: this }));
    }
}
