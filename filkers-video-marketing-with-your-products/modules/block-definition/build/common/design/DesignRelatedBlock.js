import AbstractServerSideRenderedBlock from "../AbstractServerSideRenderedBlock";
class DesignRelatedBlock extends AbstractServerSideRenderedBlock {
    constructor(options) {
        super(options);
        this.addAttribute("uid", { type: "string", default: '' });
        this.addAttribute("speed", { type: "number", default: 1 });
        this.addAttribute("aspectRatio", { type: "number", default: 1 });
    }
}
export default DesignRelatedBlock;
