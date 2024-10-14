import React, {useCallback, useState} from "react";
import {SearchListControl} from '@woocommerce/components/build/search-list-control';
import {useThrottle} from "ahooks";
import ProductService from "@filkers-wordpress/services/build/product/ProductService";

export interface ProductSelectControlProps {
    value?: number[],
    onChange?: (value: number[]) => any
}

const ProductSelectControl = ({value, onChange}: ProductSelectControlProps) => {

    const [searchText, setSearchText] = useState<string>();
    const throttledText = useThrottle(searchText, {wait: 500});
    const productQueryState = ProductService.useProducts(throttledText);


    const changeHandler = useCallback((products) => {
        if (onChange !== undefined) {
            if (products === undefined) {
                onChange([]);
            } else {
                onChange(products.map(pr => pr.id));
            }
        }
    }, [onChange]);

    if (productQueryState?.error !== undefined) {
        return <div className="filkers-error-message">${productQueryState?.error}</div>;
    }

    return (
        <SearchListControl
            className="filkers-product-selector"
            list={productQueryState?.data}
            selected={productQueryState?.data.filter(p => value.includes(p.id))}
            onChange={changeHandler}
            setState={state => setSearchText(state.search)}
            isLoading={productQueryState?.loading}
            debouncedSpeak={(message) => null}
            isCompact={true}
        />
    );
}

export default ProductSelectControl;
