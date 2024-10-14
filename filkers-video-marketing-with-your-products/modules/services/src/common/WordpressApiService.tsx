import {useEffect, useState} from 'react';
import {addQueryArgs} from '@wordpress/url';
import apiFetch from '@wordpress/api-fetch';


export interface QueryArgs {
    page?: number,
    per_page?: number,
    search?: string,
    orderby?: string
}

export interface QueryState<T> {
    loading: boolean,
    data?: T[],
    error?: string
}

export default class WordpressApiService {


    protected useQuery<T>(endpoint: string, queryArgs: QueryArgs): QueryState<T> {
        const [state, setState] = useState<QueryState<T>>({loading: true, data: []});

        useEffect(() => {
            console.log(`${endpoint} - Query: ${JSON.stringify(queryArgs)} `);
            this.query<T>(endpoint, queryArgs)
                .then((data) => {
                    setState({loading: false, data: data});
                })
                .catch((err) => {
                    setState({loading: false, data: [], error: `${err}`});
                })
        }, [endpoint, queryArgs, setState]);
        return state;
    }

    protected query<T>(endpoint: string, queryArgs: QueryArgs): Promise<T[]> {
        const path = addQueryArgs(endpoint, queryArgs);
        return apiFetch({path});
    }

}