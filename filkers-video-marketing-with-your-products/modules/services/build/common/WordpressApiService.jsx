import { useEffect, useState } from 'react';
import { addQueryArgs } from '@wordpress/url';
import apiFetch from '@wordpress/api-fetch';
export default class WordpressApiService {
    useQuery(endpoint, queryArgs) {
        const [state, setState] = useState({ loading: true, data: [] });
        useEffect(() => {
            console.log(`${endpoint} - Query: ${JSON.stringify(queryArgs)} `);
            this.query(endpoint, queryArgs)
                .then((data) => {
                setState({ loading: false, data: data });
            })
                .catch((err) => {
                setState({ loading: false, data: [], error: `${err}` });
            });
        }, [endpoint, queryArgs, setState]);
        return state;
    }
    query(endpoint, queryArgs) {
        const path = addQueryArgs(endpoint, queryArgs);
        return apiFetch({ path });
    }
}
