import WordpressApiService, {QueryArgs, QueryState} from "../common/WordpressApiService";
import {useEffect, useState} from "react";

export interface WC_Product {
    id: number,
    name: string
}

class ProductServiceImpl extends WordpressApiService {

    public useProducts(search: string): QueryState<WC_Product> {
        const [args, setArgs] = useState<QueryArgs>({per_page: 0});
        useEffect(() => {
            if (search === undefined || search.trim() === "") {
                setArgs((args) => {
                    return {...args, search: undefined};
                })
            } else {
                setArgs((args) => {
                    return {...args, search: search.trim()};
                })
            }
        }, [search, setArgs]);
        return this.useQuery(`wc/store/products`, args);
    }


}

const ProductService = new ProductServiceImpl();
export default ProductService;