import React from "react";
import ProductDataBlock from "../common/product/ProductDataBlock";
import NewestProductsIcon from "./NewestProductsIcon";
import {__} from "@wordpress/i18n";

class NewestProductsBlock extends ProductDataBlock {

    constructor() {
        super({
            name: 'newest-products',
            icon: NewestProductsIcon,
            title: __('Newest Products')
        });
    }

}

export default NewestProductsBlock;