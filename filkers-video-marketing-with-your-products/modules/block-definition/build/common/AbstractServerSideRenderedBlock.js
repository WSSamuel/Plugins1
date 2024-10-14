import AbstractFilkersBlock from "./AbstractFilkersBlock";
class AbstractServerSideRenderedBlock extends AbstractFilkersBlock {
    constructor(options) {
        super(options);
        this.addAttribute("preview", { type: "boolean", default: false });
    }
    save() {
        return (props) => null;
    }
}
export default AbstractServerSideRenderedBlock;
