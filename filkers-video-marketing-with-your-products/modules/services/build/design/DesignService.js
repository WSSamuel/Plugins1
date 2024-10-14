import autoBind from "auto-bind";
import Axios from "axios";
import { WidgetsApiService } from "../common/WidgetsApiService";
class DesignServiceImpl extends WidgetsApiService {
    constructor() {
        super('/design');
        autoBind(this);
    }
    fetchDesign(uid) {
        return Axios
            .get(`${this.getServiceUrl()}/${uid}`, this.createAxiosRequestConfig())
            .catch(this.handleRequestError)
            .then((rsp) => {
            return rsp.data?.design;
        });
    }
}
const DesignService = new DesignServiceImpl();
export default DesignService;
