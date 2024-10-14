import autoBind from "auto-bind";
import Axios, {AxiosResponse} from "axios";
import {Design, Item} from "@filkers/filkersjs-model";
import {WidgetsApiService} from "../common/WidgetsApiService";

export interface DesignPlayerData {
    design: Design,
    item: Item
}

class DesignServiceImpl extends WidgetsApiService {

    constructor() {
        super('/design');
        autoBind(this);
    }

    public fetchDesign(uid: string): Promise<Design> {
        return Axios
            .get(`${this.getServiceUrl()}/${uid}`, this.createAxiosRequestConfig())
            .catch(this.handleRequestError)
            .then((rsp: AxiosResponse<DesignPlayerData>) => {
                return rsp.data?.design;
            });
    }
}

const DesignService = new DesignServiceImpl();
export default DesignService;