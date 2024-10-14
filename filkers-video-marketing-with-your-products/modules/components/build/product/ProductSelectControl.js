import React, { useCallback, useState } from "react";
import { SearchListControl } from '@woocommerce/components/build/search-list-control';
import { useThrottle } from "ahooks";
import ProductService from "@filkers-wordpress/services/build/product/ProductService";
const ProductSelectControl = ({ value, onChange }) => {
    const [searchText, setSearchText] = useState();
    const throttledText = useThrottle(searchText, { wait: 500 });
    const productQueryState = ProductService.useProducts(throttledText);
    const changeHandler = useCallback((products) => {
        if (onChange !== undefined) {
            if (products === undefined) {
                onChange([]);
            }
            else {
                onChange(products.map(pr => pr.id));
            }
        }
    }, [onChange]);
    if (productQueryState?.error !== undefined) {
        return React.createElement("div", { className: "filkers-error-message" },
            "$",
            productQueryState?.error);
    }
    return (React.createElement(SearchListControl, { className: "filkers-product-selector", list: productQueryState?.data, selected: productQueryState?.data.filter(p => value.includes(p.id)), onChange: changeHandler, setState: state => setSearchText(state.search), isLoading: productQueryState?.loading, debouncedSpeak: (message) => null, isCompact: true }));
};
export default ProductSelectControl;
