import {BlockSaveProps} from "@wordpress/blocks";
import {ComponentType} from "react";
import AbstractFilkersBlock, {AbstractFilkersBlockOptions} from "./AbstractFilkersBlock";


abstract class AbstractServerSideRenderedBlock<ATTRS = any> extends AbstractFilkersBlock<ATTRS> {

    protected constructor(options: AbstractFilkersBlockOptions) {
        super(options);
        this.addAttribute("preview", {type: "boolean", default: false});
    }

    protected save(): ComponentType<BlockSaveProps<ATTRS>> {
        return (props) => null;
    }

}

export default AbstractServerSideRenderedBlock;