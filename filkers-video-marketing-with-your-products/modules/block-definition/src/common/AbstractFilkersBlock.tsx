import {BlockAttribute, BlockConfiguration, BlockEditProps, BlockIcon, BlockSaveProps, updateCategory} from "@wordpress/blocks";
import autoBind from "auto-bind";
import {ComponentType, ReactNode} from "react";
import FilkersBlocksCategoryIcon from "./FilkersBlocksCategoryIcon";


export type FilkersBlockAttributesMap = { [name: string]: BlockAttribute<any> };

export interface FilkersBlockEditProps<ATTRS extends any, B extends AbstractFilkersBlock = AbstractFilkersBlock> extends BlockEditProps<ATTRS> {
    block: B,
    children?: ReactNode | ReactNode[]
}

export interface AbstractFilkersBlockOptions {
    package?: string,
    category?: string,
    name: string,
    title: string,
    icon: BlockIcon
}

const FILKERS_BLOCKS_DEFAULT_OPTIONS: Partial<AbstractFilkersBlockOptions> = {
    package: 'filkers-blocks',
    category: 'filkers-blocks'
}

const FILKERS_BLOCKS_INITIALIZATION_STATE = {
    initialized: false,
}

const initializeFilkersBlocks = () => {
    if (FILKERS_BLOCKS_INITIALIZATION_STATE.initialized === false) {
        FILKERS_BLOCKS_INITIALIZATION_STATE.initialized = true;
        (function () {
            updateCategory(FILKERS_BLOCKS_DEFAULT_OPTIONS.category, {icon: FilkersBlocksCategoryIcon});
        })();
    }
}

abstract class AbstractFilkersBlock<ATTRS = any> {

    private options: AbstractFilkersBlockOptions;
    private readonly attributes: FilkersBlockAttributesMap;

    protected constructor(options: AbstractFilkersBlockOptions) {
        autoBind(this);
        initializeFilkersBlocks();
        this.options = Object.assign({...FILKERS_BLOCKS_DEFAULT_OPTIONS}, options);
        this.attributes = {};
    }

    protected addAttribute<T = any>(name: string, attribute: BlockAttribute<T>) {
        this.attributes[name] = attribute;
    }

    protected addAllAttributes(attrs: FilkersBlockAttributesMap) {
        Object.keys(attrs).forEach((key => this.addAttribute(key, attrs[key])));
    }

    public getBlockName() {
        return `${this.options.package}/${this.options.name}`;
    }

    public getBlockTitle() {
        return this.options?.title;
    }

    public getBlockIcon() {
        return this.options?.icon;
    }

    public getSettings(): BlockConfiguration<any> {
        const config: BlockConfiguration<any> = {
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

    protected abstract edit(): ComponentType<BlockEditProps<ATTRS>>;

    protected abstract save(): ComponentType<BlockSaveProps<ATTRS>>;


}

export default AbstractFilkersBlock;