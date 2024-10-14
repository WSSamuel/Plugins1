import AbstractFilkersBlock from "./common/AbstractFilkersBlock";
import {registerBlockType} from "@wordpress/blocks";
import FolderPlayerBlock from "./folder-player/FolderPlayerBlock";
import FeaturedProductsBlock from "./featured-products/FeaturedProductsBlock";
import OnSaleProductsBlock from "./onsale-products/OnSaleProductsBlock";
import NewestProductsBlock from "./newest-products/NewestProductsBlock";
import HandpickedProductsBlock from "./handpicked-products/HandpickedProductsBlock";

class BlockRegistryImpl {

    private registeredBlocks: AbstractFilkersBlock[];

    constructor() {
        this.registeredBlocks = [];
        this.addToRegistry(new FolderPlayerBlock());
        this.addToRegistry(new FeaturedProductsBlock());
        this.addToRegistry(new OnSaleProductsBlock());
        this.addToRegistry(new NewestProductsBlock());
        this.addToRegistry(new HandpickedProductsBlock());
    }

    protected addToRegistry(block: AbstractFilkersBlock) {
        this.registeredBlocks.push(block);
    }

    public registerBlocks() {
        this.registeredBlocks
            .forEach(bl => {
                registerBlockType(bl.getBlockName(), bl.getSettings());
            });
    }

}

export default new BlockRegistryImpl();

