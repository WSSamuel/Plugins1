import autoBind from "auto-bind";
import {EnvironmentUtils} from "@filkers/filkersjs-model";
import {AxiosError, AxiosRequestConfig} from "axios";


export class WidgetsApiService {

	private readonly servicePath: string;
	private readonly serviceUrl: string;

	constructor(servicePath: string) {
		autoBind(this);
		this.servicePath = servicePath;
		this.serviceUrl = `${EnvironmentUtils.getHost()}/api/widgets/v1${servicePath}`;
	}

	protected getServiceUrl(): string {
		return this.serviceUrl;
	}

	protected getServicePath(): string {
		return this.servicePath;
	}

	protected getTopWindowReferrer(): string {
		return (window.location !== window.parent.location)
			? document.referrer
			: document.location.href;
	}

	protected createAxiosRequestConfig(): AxiosRequestConfig {
		const config: AxiosRequestConfig = {
			timeout: 5000,
			params: {},
		}
		return config;
	}

	protected handleRequestError(error: AxiosError) {
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
