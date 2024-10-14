import {AbstractFilkersBlockOptions} from "../AbstractFilkersBlock";
import AbstractServerSideRenderedBlock from "../AbstractServerSideRenderedBlock";

export interface DesignRelatedBlockAttrs {
    uid: string,
    speed?: number,
    aspectRatio?: number
}

abstract class DesignRelatedBlock<ATTRS extends DesignRelatedBlockAttrs> extends AbstractServerSideRenderedBlock<ATTRS> {

    protected constructor(options: AbstractFilkersBlockOptions) {
        super(options);

        this.addAttribute("uid", {type: "string", default: ''});
        this.addAttribute("speed", {type: "number", default: 1});
        this.addAttribute("aspectRatio", {type: "number", default: 1});

    }


}

export default DesignRelatedBlock;