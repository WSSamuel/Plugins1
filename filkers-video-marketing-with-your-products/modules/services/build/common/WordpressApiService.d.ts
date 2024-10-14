import { AxiosError, AxiosRequestConfig } from "axios";
export declare class WordpressApiService {
    private readonly servicePath;
    private readonly serviceUrl;
    constructor(servicePath: string);
    protected getServiceUrl(): string;
    protected getServicePath(): string;
    protected getTopWindowReferrer(): string;
    protected createAxiosRequestConfig(ouid?: string): AxiosRequestConfig;
    protected handleRequestError(error: AxiosError): void;
}
