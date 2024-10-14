import React, {ComponentType} from "react"
import FolderPlayerIcon from "./FolderPlayerIcon";
import {__} from "@wordpress/i18n";
import {BlockEditProps} from "@wordpress/blocks";
import FolderPlayerEdit from "./FolderPlayerEdit";
import {SLIDER_CONTROLS_ATTRS, SliderControlsAttrs} from "../common/controls/SliderControls";
import AbstractServerSideRenderedBlock from "../common/AbstractServerSideRenderedBlock";
import {SIZE_CONTROLS_ATTRS, SizeControlsAttrs} from "../common/controls/SizeControls";
import {PLAYBACK_CONTROLS_ATTRS, PlaybackControlsAttrs} from "../common/controls/PlaybackControls";
import {CLICK_CONTROLS_ATTRS, ClickControlsAttrs} from "../common/controls/ClickControls";
import {UID_CONTROLS_ATTRS, UidControlAttrs} from "../common/controls/UidControl";

export interface FolderPlayerPropsAttrs extends UidControlAttrs, SliderControlsAttrs, SizeControlsAttrs, PlaybackControlsAttrs, ClickControlsAttrs {
    uid: string,
}

export default class FolderPlayerBlock extends AbstractServerSideRenderedBlock<FolderPlayerPropsAttrs> {

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

    protected edit(): ComponentType<BlockEditProps<FolderPlayerPropsAttrs>> {
        return (props) => <FolderPlayerEdit {...props} block={this}/>;
    }

}

