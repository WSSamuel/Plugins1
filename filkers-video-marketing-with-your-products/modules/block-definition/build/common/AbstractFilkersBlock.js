import { updateCategory } from "@wordpress/blocks";
import autoBind from "auto-bind";
import FilkersBlocksCategoryIcon from "./FilkersBlocksCategoryIcon";
const FILKERS_BLOCKS_DEFAULT_OPTIONS = {
    package: 'filkers-blocks',
    category: 'filkers-blocks'
};
const FILKERS_BLOCKS_INITIALIZATION_STATE = {
    initialized: false,
};
const initializeFilkersBlocks = () => {
    if (FILKERS_BLOCKS_INITIALIZATION_STATE.initialized === false) {
        FILKERS_BLOCKS_INITIALIZATION_STATE.initialized = true;
        (function () {
            updateCategory(FILKERS_BLOCKS_DEFAULT_OPTIONS.category, { icon: FilkersBlocksCategoryIcon });
        })();
    }
};
class AbstractFilkersBlock {
    constructor(options) {
        autoBind(this);
        initializeFilkersBlocks();
        this.options = Object.assign({ ...FILKERS_BLOCKS_DEFAULT_OPTIONS }, options);
        this.attributes = {};
    }
    addAttribute(name, attribute) {
        this.attributes[name] = attribute;
    }
    addAllAttributes(attrs) {
        Object.keys(attrs).forEach((key => this.addAttribute(key, attrs[key])));
    }
    getBlockName() {
        return `${this.options.package}/${this.options.name}`;
    }
    getBlockTitle() {
        return this.options?.title;
    }
    getBlockIcon() {
        return this.options?.icon;
    }
    getSettings() {
        const config = {
            category: this.options?.category,
            title: this.getBlockTitle(),
            attributes: this.attributes,
            icon: this.options?.icon,
            edit: this.edit(),
            save: this.save(),
            // @ts-ignore
            example: {},
        };
        return config;
    }
}
export default AbstractFilkersBlock;
