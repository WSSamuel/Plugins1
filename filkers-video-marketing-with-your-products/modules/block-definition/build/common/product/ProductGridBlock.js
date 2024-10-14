import DesignRelatedBlock from "../design/DesignRelatedBlock";
class ProductGridBlock extends DesignRelatedBlock {
    constructor(options) {
        super(options);
        this.addAttribute('columns', { type: 'number', default: 4 });
        this.addAttribute('rows', { type: 'number', default: 1 });
        this.addAttribute('buttonType', { type: 'string', default: 'buy_now' });
    }
}
export default ProductGridBlock;
