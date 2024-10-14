import { Design, Item } from "@filkers/filkersjs-model";
import { WordpressApiService } from "../common/WordpressApiService";
export interface DesignPlayerData {
    design: Design;
    item: Item;
}
declare class DesignServiceImpl extends WordpressApiService {
    constructor();
    fetchDesign(uid: string): Promise<Design>;
}
declare const DesignService: DesignServiceImpl;
export default DesignService;
