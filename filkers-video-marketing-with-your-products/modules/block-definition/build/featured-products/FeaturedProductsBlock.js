import FeaturedProductsIcon from "./FeaturedProductsIcon";
import ProductDataBlock from "../common/product/ProductDataBlock";
import { __ } from "@wordpress/i18n";
class FeaturedProductsBlock extends ProductDataBlock {
    constructor() {
        super({
            name: 'featured-products',
            icon: FeaturedProductsIcon,
            title: __('Featured Products')
        });
    }
}
export default FeaturedProductsBlock;
