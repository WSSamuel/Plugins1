import React from "react";
import {AbstractFilkersBlockOptions} from "../AbstractFilkersBlock";
import {UID_CONTROLS_ATTRS, UidControlAttrs} from "../controls/UidControl";
import {LAYOUT_CONTROLS_ATTRS, LayoutControlsAttrs} from "../controls/LayoutControls";
import AbstractServerSideRenderedBlock from "../AbstractServerSideRenderedBlock";
import {PLAYBACK_CONTROLS_ATTRS, PlaybackControlsAttrs} from "../controls/PlaybackControls";
import {CLICK_CONTROLS_ATTRS, ClickControlsAttrs} from "../controls/ClickControls";
import {BlockEditProps} from "@wordpress/blocks";
import ProductDataBlockEdit from "./ProductDataBlockEdit";

export interface ProductDataBlockAttrs extends UidControlAttrs, LayoutControlsAttrs,
    PlaybackControlsAttrs, ClickControlsAttrs {
}


abstract class ProductDataBlock<ATTR extends ProductDataBlockAttrs = ProductDataBlockAttrs> extends AbstractServerSideRenderedBlock<ATTR> {

    protected constructor(options: AbstractFilkersBlockOptions) {
        super(options);

        this.addAllAttributes(UID_CONTROLS_ATTRS);
        this.addAllAttributes(CLICK_CONTROLS_ATTRS);
        this.addAllAttributes(LAYOUT_CONTROLS_ATTRS);
        this.addAllAttributes(PLAYBACK_CONTROLS_ATTRS);

    }

    protected edit(): React.ComponentType<BlockEditProps<ATTR>> {
        return (props) => <ProductDataBlockEdit {...props} block={this}/>;
    }


}

export default ProductDataBlock;