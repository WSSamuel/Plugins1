import autoBind from "auto-bind";
import { EnvironmentUtils } from "@filkers/filkersjs-model";
export class WidgetsApiService {
    constructor(servicePath) {
        autoBind(this);
        this.servicePath = servicePath;
        this.serviceUrl = `${EnvironmentUtils.getHost()}/api/widgets/v1${servicePath}`;
    }
    getServiceUrl() {
        return this.serviceUrl;
    }
    getServicePath() {
        return this.servicePath;
    }
    getTopWindowReferrer() {
        return (window.location !== window.parent.location)
            ? document.referrer
            : document.location.href;
    }
    createAxiosRequestConfig() {
        const config = {
            timeout: 5000,
            params: {},
        };
        return config;
    }
    handleRequestError(error) {
        const message = error?.response?.data;
        if (message === undefined) {
            throw new Error('Connection error');
        }
        switch (message) {
            case "error.design.private":
                throw new Error(`This UID is private`);
            case "error.design.notFound":
                throw new Error(`Invalid UID`);
            default:
                throw new Error(message);
        }
    }
}
