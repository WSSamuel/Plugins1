import { registerBlockType } from "@wordpress/blocks";
import FolderPlayerBlock from "./folder-player/FolderPlayerBlock";
import FeaturedProductsBlock from "./featured-products/FeaturedProductsBlock";
import OnSaleProductsBlock from "./onsale-products/OnSaleProductsBlock";
import NewestProductsBlock from "./newest-products/NewestProductsBlock";
import HandpickedProductsBlock from "./handpicked-products/HandpickedProductsBlock";
class BlockRegistryImpl {
    constructor() {
        this.registeredBlocks = [];
        this.addToRegistry(new FolderPlayerBlock());
        this.addToRegistry(new FeaturedProductsBlock());
        this.addToRegistry(new OnSaleProductsBlock());
        this.addToRegistry(new NewestProductsBlock());
        this.addToRegistry(new HandpickedProductsBlock());
    }
    addToRegistry(block) {
        this.registeredBlocks.push(block);
    }
    registerBlocks() {
        this.registeredBlocks
            .forEach(bl => {
            registerBlockType(bl.getBlockName(), bl.getSettings());
        });
    }
}
export default new BlockRegistryImpl();
