import WordpressApiService from "../common/WordpressApiService";
import { useEffect, useState } from "react";
class ProductServiceImpl extends WordpressApiService {
    useProducts(search) {
        const [args, setArgs] = useState({ per_page: 0 });
        useEffect(() => {
            if (search === undefined || search.trim() === "") {
                setArgs((args) => {
                    return { ...args, search: undefined };
                });
            }
            else {
                setArgs((args) => {
                    return { ...args, search: search.trim() };
                });
            }
        }, [search, setArgs]);
        return this.useQuery(`wc/store/products`, args);
    }
}
const ProductService = new ProductServiceImpl();
export default ProductService;
