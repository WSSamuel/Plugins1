import React from "react";
import { UID_CONTROLS_ATTRS } from "../controls/UidControl";
import { LAYOUT_CONTROLS_ATTRS } from "../controls/LayoutControls";
import AbstractServerSideRenderedBlock from "../AbstractServerSideRenderedBlock";
import { PLAYBACK_CONTROLS_ATTRS } from "../controls/PlaybackControls";
import { CLICK_CONTROLS_ATTRS } from "../controls/ClickControls";
import ProductDataBlockEdit from "./ProductDataBlockEdit";
class ProductDataBlock extends AbstractServerSideRenderedBlock {
    constructor(options) {
        super(options);
        this.addAllAttributes(UID_CONTROLS_ATTRS);
        this.addAllAttributes(CLICK_CONTROLS_ATTRS);
        this.addAllAttributes(LAYOUT_CONTROLS_ATTRS);
        this.addAllAttributes(PLAYBACK_CONTROLS_ATTRS);
    }
    edit() {
        return (props) => React.createElement(ProductDataBlockEdit, Object.assign({}, props, { block: this }));
    }
}
export default ProductDataBlock;
