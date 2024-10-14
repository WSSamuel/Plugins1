//@ts-ignore
import {__experimentalUnitControl as UnitControl, SelectControl} from "@wordpress/components";

import React, {ReactNode} from "react";
import {BlockEditProps} from "@wordpress/blocks";
import AbstractFilkersBlock from "../AbstractFilkersBlock";

export interface AbstractControlProps<ATTRS, B extends AbstractFilkersBlock = AbstractFilkersBlock> extends BlockEditProps<ATTRS> {
    block: B,
    children?: ReactNode | ReactNode[];
}