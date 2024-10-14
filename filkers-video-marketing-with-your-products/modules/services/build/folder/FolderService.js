import autoBind from "auto-bind";
import Axios from "axios";
import { WidgetsApiService } from "../common/WidgetsApiService";
class FolderServiceImpl extends WidgetsApiService {
    constructor() {
        super('/folder');
        autoBind(this);
    }
    checkFolderVisibility(uid) {
        return Axios
            .get(`${this.getServiceUrl()}/isVisible/${uid}`, this.createAxiosRequestConfig())
            .catch(this.handleRequestError)
            .then(() => undefined);
    }
}
const FolderService = new FolderServiceImpl();
export default FolderService;
