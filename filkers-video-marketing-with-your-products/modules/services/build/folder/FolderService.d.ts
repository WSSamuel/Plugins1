import { WordpressApiService } from "../common/WordpressApiService";
declare class FolderServiceImpl extends WordpressApiService {
    constructor();
    checkFolderVisibility(uid: string): Promise<void>;
}
declare const FolderService: FolderServiceImpl;
export default FolderService;
