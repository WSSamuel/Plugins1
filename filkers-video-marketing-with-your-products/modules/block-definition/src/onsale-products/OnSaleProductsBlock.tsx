import React from "react";
import OnSaleProductsIcon from "./OnSaleProductsIcon";
import ProductDataBlock from "../common/product/ProductDataBlock";
import {__} from "@wordpress/i18n";

class OnSaleProductsBlock extends ProductDataBlock {

    constructor() {
        super({
            name: 'onsale-products',
            icon: OnSaleProductsIcon,
            title: __('On Sale Products')
        });
    }

}

export default OnSaleProductsBlock;